<?php
/**
 * @package hello_leslie
 * @version 1.0
 */
/*
Plugin Name: Hello Leslie
Plugin URI: https://wordpress.org/plugins/hello-leslie/
Description: Hello Dolly, but it's Leslie Knope giving you compliments.
Author: Ryder Damen
Version: 1.0
Author URI: https://ryderdamen.com
Text Domain: ryder-damen

Adapted with love from Hello Dolly by Matt Mullenweg
*/

function hello_leslie_get_username() {
	
	// Get user's name
	$current_user = wp_get_current_user();
	
	if ( $current_user->user_firstname !== "" ) {
		$lk_user = $current_user->user_firstname;
	} else if ( $current_user->display_name !== "" ) {
		$lk_user = ucwords($current_user->display_name);
	} else {
		$lk_user = ucwords($current_user->user_login);
	}

	// Return the name
	return wptexturize( $lk_user );
}

// Echo the main tag and the hidden username tag
function hello_leslie() {
	$user = hello_leslie_get_username();
	echo "<p id='leslie'></p>";
	echo "<p id='leslieHidden' style='display: none;'>$user</p>";
}

// Enqueue it up
function hello_leslie_enqueue_script() {
	wp_enqueue_script( "leslie-knope", plugin_dir_url( __FILE__ ). 'get_compliment.js');
}

// We need some CSS to position the paragraph
function leslie_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#leslie {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}

add_action( 'admin_notices', 'hello_leslie' );
add_action( 'admin_enqueue_scripts', 'hello_leslie_enqueue_script');
add_action( 'admin_head', 'leslie_css' );


