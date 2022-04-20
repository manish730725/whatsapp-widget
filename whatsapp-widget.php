<?php

    /* 
        Plugin Name: Whatsapp Widget
        Plugin URI: https://techskymedia.com
        Description: Whatsapp widget
        Version: 1.0.0
        Author: Manish Jaiswal
        Author URI: https://techskymedia.com
        Text Domain: whatsapp-widget
    */
    function dbConnect(){
        $db = new mysqli("localhost",DB_USER,DB_PASSWORD,DB_NAME);
        return $db;
    }
    function wpmj_init_session() {
        if (!session_id()) {
            session_start();
        }
    }
    function getVisIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    function getDataIp(){
        $ip = getVisIPAddr();
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        $phonecode = file_get_contents("https://ipapi.co/".$ip."/country_calling_code/");
        $phonecode = str_replace('+', '', $phonecode);
        $counrty_code = $ipdat->geoplugin_countryCode;
        $counrty_code = strtolower($counrty_code);
        $timezone =  $ipdat->geoplugin_timezone;
        return array($counrty_code, $phonecode,$timezone);
    }
 
    function link_page()
    {
        //wp_enqueue_script("jqueryCdn","https://code.jquery.com/jquery-3.6.0.min.js");
       // wp_enqueue_script("js",plugins_url()."/whatsapp-widget/js/main.js");
       // wp_enqueue_style("custom",plugins_url()."/whatsapp-widget/css/custom.css");
    }

    function add_menu(){
        add_menu_page("Whatsapp Widget","Whatsapp Widget","manage_options","whatsapp_widget","control","dashicons-whatsapp",100);
    }

    function table_prefix(){
        global $wpdb;
        return  $wpdb->prefix;
    }

    function control(){
        include_once("content/index.php");
      
    }


    function create_table(){
        $table_prefix = table_prefix();
        $db = dbConnect();
        $table_name = $table_prefix."whatsapp_widget";
        $sql = "SELECT * FROM $table_name";
        $response = $db->query($sql);
        if(!$response)
        {
            $create_table = "CREATE TABLE $table_name(
                id INT(5) NOT NULL AUTO_INCREMENT,
                company_name VARCHAR(100),
                phone_number VARCHAR(100),
                phone_code VARCHAR(100),
                logo_path VARCHAR(255),
                whatsapp_status VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )";

            $response = $db->query($create_table);
        }
        
    }

    function delete_table(){
        $table_prefix = table_prefix();
        $db = dbConnect();
        $table_name = $table_prefix."whatsapp_widget";
        $delete_table = "DROP TABLE $table_name";
        $response = $db->query($delete_table);
    }

    
    function add_plugin_entire_website(){
        include_once("template/widget.php");
    }

    add_action("wp_enqueue_scripts","link_page");
    add_action("admin_menu","add_menu");
    add_action('wp_footer', 'add_plugin_entire_website');
    add_action( 'init', 'wpmj_init_session' );
    register_activation_hook(__FILE__,"create_table");
    register_deactivation_hook(__FILE__,"delete_table");

?>