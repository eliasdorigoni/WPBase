<?php
if (!defined('ABSPATH')) exit;

function personalizarGoogleAnalytics($wp_customize) {
    $wp_customize->add_section('section-google-analytics', array(
        'title' => 'Google Analytics',
        'priority' => 170,
        'capability' => 'edit_theme_options',
        ));

    $wp_customize->add_setting('google-analytics', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        ));
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'google-analytics-control',
            array(
                'label'       => 'Código UA de Google Analytics',
                'section'     => 'section-google-analytics',
                'settings'    => 'google-analytics',
                'type'        => 'text',
                'input_attrs' => array(
                    'placeholder' => 'UA-XXXXXXX-XX',
                    ),
                )
            )
        );

}
add_action('customize_register', 'personalizarGoogleAnalytics');

function mostrarScriptGoogleAnalytics() {
    $ua = get_option('google-analytics', '');
    if ($ua): ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
          ga('create', '<?php echo $ua ?>', 'auto');
          ga('send', 'pageview');
        </script>
    <?php endif;
}

add_action('post_body', 'mostrarScriptGoogleAnalytics');
