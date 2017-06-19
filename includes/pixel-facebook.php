<?php
if (!defined('ABSPATH')) exit;

function agregarPixelFacebook($wp_customize) {
    $wp_customize->add_setting('pixel-facebook', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'pixel-facebook-control',
            array(
                'label'       => 'ID de píxel de Facebook',
                'section'     => 'section-analytics',
                'settings'    => 'pixel-facebook',
                'type'        => 'text',
                'input_attrs' => array(
                    'placeholder' => '000000000000000',
                ),
            )
        )
    );
}
add_action('customize_register', 'agregarPixelFacebook');

function mostrarScriptPixelFacebook() {
    $pixel = get_option('pixel-facebook', '');
    if ($pixel): ?>
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo $pixel; ?>');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $pixel; ?>&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
    <?php endif;
}
add_action('post_body', 'mostrarScriptPixelFacebook');
