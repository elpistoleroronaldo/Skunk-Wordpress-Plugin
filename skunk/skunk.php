<?php
/*
 * Plugin Name: !Skunk
 * Description: Custom Tasks.
 * Version: 0.1
 * Author: Ron Robinson/Oakland CTU
 * Author URI: http://TheGet.io
 * 
 */

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
///////////////////////////////////////////////////////////////////////////////////////////////////
// WP Admin Below /////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////

function SendMain($mylist) {
    // stuff
}

function SkunkMsgs_options() {
    //if ( !current_user_can( 'manage_options' ) )  {
    //    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    //}
    $version = get_option('skunk_db_version');
    echo '<div class="wrap">'. PHP_EOL;
    echo '<h1>SkunkMsgs Plugin</h1>'. PHP_EOL;
    echo '<p>Author: Ron Robinson 626.375.5472  <a href="mailto:ron@TheGet.io">ron@TheGet.io</a></p>'. PHP_EOL;
    echo '<p>Purpose: Totally Generic Plugin for SkunkMsgs Tasks.</p>'. PHP_EOL;
    echo '<p>Version ' . $version . '</p>';
    echo ' ';
    echo '<form method="post" action="options.php">' . PHP_EOL;
    settings_fields( 'myoption-group' );
    do_settings_sections( 'myoption-group' );
    echo '<p><input type="text" name="TwilioAPIKey" value="' . esc_attr( get_option('TwilioAPIKey')) . '"/> Twilio API Key</p>';
    echo '<input type="text" name="ListHolder" value="' . esc_attr( get_option('ListHolder')) . '"/> List Holder</p>';
    echo '<input type="text" name="PageHolder" value="' . esc_attr( get_option('PageHolder')) . '"/> Page Holder</p>';
    submit_button();
    echo ' ';
    echo ' ';
    echo ' ';
    echo ' ';
    echo ' ';
    echo ' ';
    echo '</form></div>' . PHP_EOL;
}

function txtregister(){
    echo 'Text Registration <br/>';
    echo ' ';
    echo ' ';
    echo ' ';
    echo ' ';
    echo ' ';
    //
}

function txtsend(){
    global $wpdb;
    $result = $GLOBALS['wpdb']->get_results( "SELECT textnumber FROM {$wpdb->prefix}livetext WHERE listname = 'TestList'", 'ARRAY_A' );
    $pageresult = $result[0][textnumber];
    echo 'Text Send <br />';
    //print_r ($result);
    echo '. ' . $pageresult . ' .';
    echo ' ';
    echo ' ';
    echo ' ';
    echo ' ';
    echo ' ';
    echo '<p>&nbsp;</p> ';
    //
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///// Admin, Install, Uninstall Stuff ///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function echo_err($what)    {
    echo '<script>alert("' . print_r( $what, true ) . '");</script>';
}

function SkunkMsgs_menu() {
    add_options_page( 'SkunkMsgs Options', 'SkunkMsgs Options', 'manage_options', '99Skunkskunk99', 'SkunkMsgs_options' );
}

function add_action_links ( $links ) {
    $mylinks = array(
        '<a href="' . admin_url( 'options-general.php?page=99Skunkskunk99') . '">SkunkMsgs Settings</a>',);
    return array_merge( $links, $mylinks);
}

function SkunkMsgs_options_page() {
    add_menu_page('SkunkMsgs','SkunkMsgs','manage_options',
        'SkunkMsgs','SkunkMsgs_options',plugin_dir_url(__FILE__) . 'images/txt.png', 2);
}

function skunk_install() {
    global $wpdb;
    $skunk_db_version = '0.1';
    add_option( 'skunk_db_version', $skunk_db_version );
    $table_name = $wpdb->prefix . "livetext";
    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    textnumber varchar(25),
    listname varchar (50), PRIMARY KEY  (id));";
    dbDelta( $sql );
    $wpdb->insert(
        $table_name,
        array(
            'textnumber' => '6263755472',
            'listname' => 'TestList',
        ));
    //update_option(  'skunk_db_version', $skunk_db_version );
    //$version = get_option('skunk_db_version');
}

function skunk_uninstall() {
    //add_option( 'skunk_db_version', $skunk_db_version );
    //update_option(  'skunk_db_version', $skunk_db_version );
    //$version = get_option('skunk_db_version');
    delete_option('skunk_db_version');
}

function register_mysettings() { // whitelist options
    register_setting( 'myoption-group', 'TwilioAPIKey' );
    register_setting( 'myoption-group', 'ListHolder' );
    register_setting( 'myoption-group', 'PageHolder' );
}

add_action( 'admin_init', 'register_mysettings' );
add_action('SendThoseTexts', 'SendMain',10,1);
add_action( 'admin_menu', 'SkunkMsgs_menu');
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links');
add_action('admin_menu', 'SkunkMsgs_options_page');
register_activation_hook( __FILE__, 'skunk_install' );
register_uninstall_hook(__FILE__, 'skunk_uninstall');
add_shortcode( 'txtregister', 'txtregister' );
add_shortcode( 'txtsend', 'txtsend' );

