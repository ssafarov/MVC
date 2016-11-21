<?php
/*
Plugin Name:  MVC
Plugin URI:   http://itransition.com
Description:  MVC plugin
Version:      1.0
Author:       Sergey Safarov
*/

require_once "autoloader.php";

add_action('wp_ajax_MVC_Post', 'MVCPost'); // is_user_logged_in()
function MVCPost()
{
    if (!isset($_POST['controller']) || !isset($_POST['controller_action'])) {
        throw new \Exception('Must be set controller & controller_action');
    }
    $controller = $_POST['controller'];
    $action = $_POST['controller_action'];
    echo \MVC\Controller::factory($controller)->render($action);
    exit;
}

add_action('wp_footer', 'MVCAddJS');
add_action('admin_footer', 'MVCAddJS');
function MVCAddJS()
{
    ?>
    <script>
        window.MVC_Post = function (controller, action, data, success) {
            jQuery.ajax({
                type: "POST",
                url: "/wp-admin/admin-ajax.php",
                data: {
                    action: "MVC_Post",
                    controller: controller,
                    controller_action: action,
                    data: data
                }
            }).success(success);
        };
    </script>
    <?php
}

require get_template_directory() . '/MVC/plugin_init.php';

add_action('setup_theme', 'mvc_init_theme');
function mvc_init_theme()
{
    require get_template_directory() . '/MVC/theme_init.php';
}

add_shortcode('MVC', 'getMvcShortCode');
function getMvcShortCode($args)
{
    return \MVC\Controller::factory($args['controller'])->render($args['action']);
}