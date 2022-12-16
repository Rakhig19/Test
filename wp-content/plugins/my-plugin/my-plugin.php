<?php
/*
* Plugin Name:My Plugin
*Description: WordPress Backend 
*Version:6.2
*Author:Rakhi Gupta 
*Plugin URI:http://localhost/Bootstrap/
*
*
*/

// Don't access this file directly.
defined('ABSPATH') or die();
if(!defined('ABSPATH')){
    header("Location://http://localhost/bootstrap/");
    die(); 
}

function my_plugin_activation(){
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix.'emp';

    $my_query = "CREATE TABLE IF NOT EXISTS .`$wp_emp` ( `Id` INT NULL AUTO_INCREMENT , `name` VARCHAR(250) NOT NULL , `email` VARCHAR(250) NOT NULL , `status` BOOLEAN NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB;";
    $wpdb->query($my_query);

    //$insert_query ="INSERT INTO `$wp_emp` (`name`, `email`, `status`) VALUES ('Test', 'test123@test.com', 1)";
    
    $data = array(
        'name' => 'Test',
        'email' => 'Test1234@test.com',
        'status' => 1
    );
    $wpdb->insert($wp_emp,$data);

}
register_activation_hook(__FILE__,'my_plugin_activation');


function my_plugin_deactivation(){

    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix.'emp';
    $q = "TRUNCATE.`$wp_emp`";
    $wpdb->query($q);

}
register_deactivation_hook(__FILE__,'my_plugin_deactivation');


function my_shortcode($atts){
    $atts = array_change_key_case($atts,CASE_LOWER );
    $atts = shortcode_atts(array(
    'msg'=> 'Add shortcode from frontend',
    'note'=> 'default'
   ),$atts);
  
  // return 'result '.$atts['msg'].' ' .$atts['note'];
  include "img_gallery.php";
}
add_shortcode('my-sc','my_shortcode');

function fun_my_plugin_page(){
    include 'admin/main-page.php';
}

function fun_my_plugin_subpage(){
    echo "Sub menu";
}

function my_plugin_menu(){

    add_menu_page('My plugin Page','My plugin page','manage_options','my-plugin-page','fun_my_plugin_page','',7);

    add_submenu_page('my-plugin-page','All Emp','All Emp',
    'manage_options','my-plugin-page','fun_my_plugin_page');

    add_submenu_page('my-plugin-page','My Plugin sub page','My Plugin sub page',
    'manage_options','my-plugin-subpage','fun_my_plugin_subpage');
}

add_action('admin_menu','my_plugin_menu');

//custom post type

function register_my_cpt(){

    $labels =   array(
        'name' =>'Cars',
        'singular_name' =>'Car',

    );
    $supports = array('title','editor','thumbnail','comments','excerpts');
    $options =  array(

        'labels' =>$labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' =>    array('slug' =>'cars'),
        'show_in-rest' =>true,
        'supports'  =>$supports,
        'taxonomies' => array('car_types'),
        'publicaly_queryable' =>true,
    );
    register_post_type('cars',$options);

}
add_action('init','register_my_cpt');

function register_car_types(){

    $labels =   array(
        'name' =>'Car Type',
        'singular_name' =>'Car Types',

    );
    $options =  array(

        'labels' =>$labels,
        'hierarchical' =>true,
        'rewrite' =>    array('slug' =>'car-type'),
        'show_in-rest' =>true,
    ); 

    register_taxonomy('car-type',array('cars'),$options);
}
add_action('init','register_car_types');

// custom register form

function my_register_form(){
    ob_start();
    include "public/register_form.php";
    return ob_get_clean();
}
add_shortcode('my-register-form','my_register_form');



// login form functionality

function my_login_form(){
    ob_start();
    include "public/login_form.php";
    return ob_get_clean();
}
add_shortcode('my-login-form','my_login_form');

function my_login(){
    if(isset($_POST['user_login'])){

        $username = esc_sql($_POST['username']);
        $pass = esc_sql($_POST['pass']);
        $credentials = array(
            'user_login' => $username,
            'user_password' => $pass,
        );
        $user = wp_signon($credentials);

        if(!is_wp_error($user)){
      
          //  echo "Login Success";
            if($user->roles[0] == 'administrator'){
                wp_redirect(admin_url());
                exit;
            }else{
                wp_redirect(site_url('profile'));
                exit;
            }

        }else{
            echo  $user->get_error_message();
        }

    }
}

add_action('template_redirect','my_login');

// user profile

function my_profile(){

    ob_start();
    include "public/profile.php";
    return ob_get_clean();
}

add_shortcode('my-profile','my_profile');


function my_check_redirect(){

    $is_user_logged_in = is_user_logged_in();

    if($is_user_logged_in && (is_page('login') || is_page('register'))){

        wp_redirect(site_url('profile'));
        exit;
    }elseif(!$is_user_logged_in &&  is_page('profile')){
        wp_redirect(site_url('login'));
        exit;

    }
}
add_action('template_redirect','my_check_redirect');

function redirect_after_logout(){
    wp_redirect(site_url('login'));
    exit;
}

add_action('wp_logout','redirect_after_logout');

?>