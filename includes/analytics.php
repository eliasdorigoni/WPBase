<?php
if (!defined('ABSPATH')) exit;

function agregarSeccionAnaliticas($wp_customize) {
    $wp_customize->add_section('section-analytics', array(
        'title' => 'Analytics / Estadísticas de terceros',
        'priority' => 170,
        'capability' => 'edit_theme_options',
    ));
}
add_action('customize_register', 'agregarSeccionAnaliticas', 5);

function personalizarGoogleAnalytics($wp_customize) {
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
                'description' => 'ID de analytics.js',
                'section'     => 'section-analytics',
                'settings'    => 'google-analytics',
                'type'        => 'text',
                'input_attrs' => array(
                    'placeholder' => 'UA-XXXXXXX-XX',
                ),
            )
        )
    );
}
add_action('customize_register', 'personalizarGoogleAnalytics', 15);

function mostrarScriptGoogleAnalytics() {
    $ua = get_option('google-analytics', '');
    if ($ua): ?>
        <!-- Google Analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
          ga('create', '<?php echo $ua ?>', 'auto');
          ga('send', 'pageview');
        </script>
        <!-- END Google Analytics -->
    <?php endif;
}
add_action('wp_head', 'mostrarScriptGoogleAnalytics', 5);

function personalizarGoogleSiteTag($wp_customize) {
    $wp_customize->add_setting('google-site-tag', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'google-site-tag-control',
            array(
                'label'       => 'Código UA de Google Site Tag',
                'section'     => 'section-analytics',
                'settings'    => 'google-site-tag',
                'type'        => 'text',
                'input_attrs' => array(
                    'placeholder' => 'UA-XXXXXXXXX-X',
                ),
                'description' => 'ID de gtag.js',
            )
        )
    );
}
add_action('customize_register', 'personalizarGoogleSiteTag', 10);

function mostrarScriptGoogleSiteTag() {
    $ua = get_option('google-site-tag', '');
    if ($ua): ?>
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ua ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments)};
      gtag('js', new Date());
      gtag('config', '<?php echo $ua ?>');
    </script>
    <?php endif;
}
add_action('post_body', 'mostrarScriptGoogleSiteTag');

function personalizarPixelFacebook($wp_customize) {
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
add_action('customize_register', 'personalizarPixelFacebook', 15);

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
