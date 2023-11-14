<?php

// WordPress Admin CSS
function admin_style()
{
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/adminstyles.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

add_action('wp_enqueue_scripts', 'Divi_child_style');
function Divi_child_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}

// smacss
function es_assets()
{
    wp_register_style('es-stylesheet', get_theme_file_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all');
    wp_enqueue_style('es-stylesheet');
    wp_enqueue_script('es_js', get_theme_file_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('custom_js', get_stylesheet_directory_uri() . '/discoverelaine.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'es_assets');

// Add HubSpot script to page head
function hubspot_javascript() {
    ?>
        <!-- Start of HubSpot Embed Code -->
        <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/21985033.js"></script>
        <!-- End of HubSpot Embed Code -->
    <?php
}
add_action('wp_head', 'hubspot_javascript');

// Add Google Analytics script to page head
function ganalytics_javascript()
{
?>
    <!-- Global site tag - Google Analytics Start -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157942511-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-157942511-1');
    </script>
    <!-- Global site tag - Google Analytics End -->
<?php
}
add_action('wp_head', 'ganalytics_javascript');

// Add HotJar script to page head
function hotjar_javascript()
{
?>
    <!-- Hotjar Tracking Code for https://discoverelaine.com/ -->
    <script>
        (function(h, o, t, j, a, r) {
            h.hj = h.hj || function() {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {
                hjid: 2799615,
                hjsv: 6
            };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script>
    <!-- Hotjar Tracking Code for discoverelaine.com End -->
    <?php
}
add_action('wp_head', 'hotjar_javascript');

function marker_io()
{
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
        "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if ($current_url == 'https://dev-elaine-study.pantheonsite.io/' || 'https://elaine-study.localdev') {
    ?>
        <script>
            window.markerConfig = {
                project: '65526afda84403da6009b11d',
                source: 'snippet'
            };

            ! function(e, r, a) {
                if (!e.__Marker) {
                    e.__Marker = {};
                    var t = [],
                        n = {
                            __cs: t
                        };
                    ["show", "hide", "isVisible", "capture", "cancelCapture", "unload", "reload", "isExtensionInstalled", "setReporter", "setCustomData", "on", "off"].forEach(function(e) {
                        n[e] = function() {
                            var r = Array.prototype.slice.call(arguments);
                            r.unshift(e), t.push(r)
                        }
                    }), e.Marker = n;
                    var s = r.createElement("script");
                    s.async = 1, s.src = "https://edge.marker.io/latest/shim.js";
                    var i = r.getElementsByTagName("script")[0];
                    i.parentNode.insertBefore(s, i)
                }
            }(window, document);
        </script>
<?php
    }
}
add_action('wp_head', 'marker_io');
