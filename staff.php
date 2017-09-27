<?php
/*
 * Plugin Name: Staff
 * Description: Add/Edit/Delete staff members
 * Version: 0.8
 * Author: Scott Warren
 */
include_once "class/class.staff.php";
require_once 'functions/meta-boxes.php';
require_once 'functions/staff-save.php';
/* This chunck until end comment is to create, redirect staff page to templated file */
function dld_staff_activation() {
	$PageExists = get_page_by_title( 'Meet The Staff' );
	if ( $PageExists == null ) {
		$a_Page = array(
				'post_title'    => 'Meet The Staff',
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => 0,
				'post_type'		=> 'page'
		);
		// Insert the post into the database
		$i_PagePostID = wp_insert_post( $a_Page );
	}
}
register_activation_hook( __FILE__, 'dld_staff_activation' );

function dld_staff_deactivation() {
	$PageExists = get_page_by_title( 'Meet The Staff' );
	if ( $PageExists != null ) {
		wp_delete_post( $PageExists->ID, true );
	}
}
register_deactivation_hook( __FILE__, 'dld_staff_deactivation' );

function dld_staff_enque_js( $hook ) {
	wp_enqueue_script( 'jquery.maskedinput', plugin_dir_url( __FILE__ ) . 'js/jquery.maskedinput.js' );
	wp_enqueue_media();
	wp_enqueue_script('dld-media-upload', plugin_dir_url( __FILE__ ) . 'js/dld-media-upload.js', null, null, true) ;
}
add_action( 'admin_enqueue_scripts', 'dld_staff_enque_js' );

/**
 * Change Title for new staff Memebers to Staff Name,
 * if post is not type staff the default  "Enter title here" will display
 */
function change_title_display( $title ){
	global $post;
	$s_PostType = get_post_type($post);
	if ( $s_PostType == 'staff' ){
		echo "Staff Name";
	}else{
		echo $title;
	}	
}
add_filter('enter_title_here','change_title_display');
	
function update_edit_form() {
	echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'update_edit_form');

function dld_staff_page_template( $page_template ){
    if ( is_page( 'meet-the-staff' ) ) {
        $page_template = dirname( __FILE__ ) . '/templates/template-staff.php';
    }
    return $page_template;
}
add_filter( 'page_template', 'dld_staff_page_template' );

function dld_staff_single_template( $single_template ) {
    global $post;
    if ( $post->post_type == 'staff' ) {
    	$single_template = dirname( __FILE__ ) . '/templates/single-staff.php';
    }
    return $single_template;
}
add_filter( 'single_template', 'dld_staff_single_template' );

