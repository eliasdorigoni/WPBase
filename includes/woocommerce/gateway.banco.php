<?php
if (!defined('ABSPATH')) exit;

/**
 * Reemplaza la forma de pago "Transferencia bancaria" para acomodarse mejor
 * a los datos de bancos argentinos.
 */
function cargarClaseCBU() {
class WC_Gateway_BACS_ARGENTINA extends WC_Gateway_BACS
{

    function __construct()
    {
        parent::__construct();

        foreach ($this->account_details as $k => $item) {
            if (!isset($this->account_details[$k]['cbu'])) {
                $this->account_details[$k]['cbu'] = $this->get_option( 'cbu' );
            }

            if (!isset($this->account_details[$k]['account_type'])) {
                $this->account_details[$k]['account_type'] = $this->get_option( 'account_type' );
            }

            if (!isset($this->account_details[$k]['cuil'])) {
                $this->account_details[$k]['cuil'] = $this->get_option( 'cuil' );
            }

            unset($this->account_details[$k]['sort_code']);
            unset($this->account_details[$k]['iban']);
            unset($this->account_details[$k]['bic']);
        }
    }

    /**
     * Reemplaza <th> de IBAN con CBU y elimina el de BIC / Swift,
     * cambia input:text de BIC a input:hidden en la tabla y en JS.
     */
    public function generate_account_details_html()
    {
        ob_start();

        ?>
        <tr valign="top">
            <th scope="row" class="titledesc"><?php _e( 'Account details', 'woocommerce' ); ?>:</th>
            <td class="forminp" id="bacs_accounts">
                <table class="widefat wc_input_table sortable" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sort">&nbsp;</th>
                            <th><?php _e( 'Account name', 'woocommerce' ); ?></th>
                            <th><?php _e( 'Account number', 'woocommerce' ); ?></th>
                            <th><?php _e( 'Bank name', 'woocommerce' ); ?></th>
                            <th>CBU</th>
                            <th>Tipo de cuenta</th>
                            <th>CUIL/CUIT</th>
                        </tr>
                    </thead>
                    <tbody class="accounts">
                        <?php
                        $i = -1;
                        if ( $this->account_details ) {
                            foreach ( $this->account_details as $account ) {
                                $i++;
                                echo '<tr class="account">
                                    <td class="sort"></td>
                                    <td><input type="text" value="' . esc_attr( wp_unslash( $account['account_name'] ) ) . '" name="bacs_account_name[' . $i . ']" /></td>
                                    <td><input type="text" value="' . esc_attr( $account['account_number'] ) . '" name="bacs_account_number[' . $i . ']" /></td>
                                    <td><input type="text" value="' . esc_attr( wp_unslash( $account['bank_name'] ) ) . '" name="bacs_bank_name[' . $i . ']" /></td>
                                    <td><input type="text" value="' . esc_attr( $account['cbu'] ) . '" name="bacs_cbu[' . $i . ']" /></td>
                                    <td><input type="text" value="' . esc_attr( $account['account_type'] ) . '" name="bacs_account_type[' . $i . ']" /></td>
                                    <td><input type="text" value="' . esc_attr( $account['cuil'] ) . '" name="bacs_cuil[' . $i . ']" /></td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7"><a href="#" class="add button"><?php _e( '+ Add account', 'woocommerce' ); ?></a> <a href="#" class="remove_rows button"><?php _e( 'Remove selected account(s)', 'woocommerce' ); ?></a></th>
                        </tr>
                    </tfoot>
                </table>
                <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#bacs_accounts').on( 'click', 'a.add', function(){

                            var size = jQuery('#bacs_accounts').find('tbody .account').length;
                            jQuery('<tr class="account">\
                                    <td class="sort"></td>\
                                    <td><input type="text" name="bacs_account_name[' + size + ']" /></td>\
                                    <td><input type="text" name="bacs_account_number[' + size + ']" /></td>\
                                    <td><input type="text" name="bacs_bank_name[' + size + ']" /></td>\
                                    <td><input type="text" name="bacs_cbu[' + size + ']" /></td>\
                                    <td><input type="text" name="bacs_account_type[' + size + ']" /></td>\
                                    <td><input type="text" name="bacs_cuil[' + size + ']" /></td>\
                                </tr>').appendTo('#bacs_accounts table tbody');

                            return false;
                        });
                    });
                </script>
            </td>
        </tr>
        <?php
        return ob_get_clean();
    }

    public function save_account_details() {

        $accounts = array();

        if ( isset( $_POST['bacs_account_name'] ) ) {

            $account_names   = array_map( 'wc_clean', $_POST['bacs_account_name'] );
            $account_numbers = array_map( 'wc_clean', $_POST['bacs_account_number'] );
            $bank_names      = array_map( 'wc_clean', $_POST['bacs_bank_name'] );
            $cbus            = array_map( 'wc_clean', $_POST['bacs_cbu'] );
            $account_types   = array_map( 'wc_clean', $_POST['bacs_account_type'] );
            $cuils           = array_map( 'wc_clean', $_POST['bacs_cuil'] );

            foreach ( $account_names as $i => $name ) {
                if ( ! isset( $account_names[ $i ] ) ) {
                    continue;
                }

                $accounts[] = array(
                    'account_name'   => $account_names[ $i ],
                    'account_number' => $account_numbers[ $i ],
                    'bank_name'      => $bank_names[ $i ],
                    'cbu'            => $cbus[ $i ],
                    'account_type'   => $account_types[ $i ],
                    'cuil'           => $cuils[ $i ],
                );
            }
        }

        update_option( 'woocommerce_bacs_accounts', $accounts );
    }

    /**
     * Output for the order received page.
     *
     * @param int $order_id
     */
    public function thankyou_page( $order_id ) {

        if ( $this->instructions ) {
            echo wpautop( wptexturize( wp_kses_post( $this->instructions ) ) );
        }
        $this->bank_details( $order_id );
    }

    /**
     * Get bank details and place into a list format.
     *
     * @param int $order_id
     */
    private function bank_details( $order_id = '' ) {

        if ( empty( $this->account_details ) ) {
            return;
        }

        // Get order and store in $order
        $order      = wc_get_order( $order_id );

        $bacs_accounts = apply_filters( 'woocommerce_bacs_accounts', $this->account_details );

        if ( ! empty( $bacs_accounts ) ) {
            $account_html = '';
            $has_details  = false;

            foreach ( $bacs_accounts as $bacs_account ) {
                $bacs_account = (object) $bacs_account;

                $account_html .= '<ul class="wc-bacs-bank-details order_details bacs_details">' . PHP_EOL;

                // BACS account fields shown on the thanks page and in emails
                $account_fields = apply_filters( 'woocommerce_bacs_account_fields', array(
                    'bank_name' => array(
                        'label' => __( 'Bank', 'woocommerce' ),
                        'value' => $bacs_account->bank_name,
                    ),
                    'account_type' => array(
                        'label' => 'Tipo de cuenta',
                        'value' => $bacs_account->account_type,
                    ),
                    'account_number' => array(
                        'label' => __( 'Account number', 'woocommerce' ),
                        'value' => $bacs_account->account_number,
                    ),
                    'cbu'       => array(
                        'label' => 'CBU',
                        'value' => $bacs_account->cbu,
                    ),
                    'cuil'      => array(
                        'label' => 'CUIL/CUIT',
                        'value' => $bacs_account->cuil,
                    ),
                    'name' => array(
                        'label' => 'Nombre',
                        'value' => $bacs_account->account_name,
                    ),
                ), $order_id );

                foreach ( $account_fields as $field_key => $field ) {
                    if ( ! empty( $field['value'] ) ) {
                        $account_html .= '<li class="' . esc_attr( $field_key ) . '">' . wp_kses_post( $field['label'] ) . ': <strong>' . wp_kses_post( wptexturize( $field['value'] ) ) . '</strong></li>' . PHP_EOL;
                        $has_details   = true;
                    }
                }

                $account_html .= '</ul>';
            }

            if ( $has_details ) {
                echo '<section class="woocommerce-bacs-bank-details"><h2 class="wc-bacs-bank-details-heading">' . __( 'Our bank details', 'woocommerce' ) . '</h2>' . PHP_EOL . $account_html . '</section>';
            }
        }
    }

    public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {

        if ( ! $sent_to_admin && 'bacs' === $order->get_payment_method() && $order->has_status( 'on-hold' ) ) {
            if ( $this->instructions ) {
                echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
            }
            $this->bank_details( $order->get_id() );
        }

    }
}
}

function reemplazarBACS($load_gateways) {
    if (!class_exists('WC_Gateway_BACS_ARGENTINA')) {
        cargarClaseCBU();
    }

    $k = array_search('WC_Gateway_BACS', $load_gateways);

    if ($k === false) {
        $load_gateways[] = 'WC_Gateway_BACS_ARGENTINA';
    } else {
        $load_gateways[$k] = 'WC_Gateway_BACS_ARGENTINA';
    }

    return $load_gateways;
}
add_filter('woocommerce_payment_gateways', 'reemplazarBACS');
