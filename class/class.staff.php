<?php
if ( ! class_exists( 'Staff' ) ) {
	class Staff {
		public function __construct( ) {
				
		}
		function getAllStaff() {
			return get_posts(array("post_type" => "staff", "numberposts" => '-1'));
		}
	}
}

function staff_pages() {

    $labels = array(
        'name'                => _x( 'Staff', 'Post Type General Name', 'dld' ),
        'singular_name'       => _x( 'Staff', 'Post Type Singular Name', 'dld' ),
        'menu_name'           => __( 'Staff', 'dld' ),
        'parent_item_colon'   => __( 'Base URL', 'dld' ),
        'all_items'           => __( 'All Staff', 'dld' ),
        'view_item'           => __( 'View Staff', 'dld' ),
        'add_new_item'        => __( 'Add New Staff', 'dld' ),
        'add_new'             => __( 'Add New', 'dld' ),
        'edit_item'           => __( 'Edit Staff', 'dld' ),
        'update_item'         => __( 'Update Staff', 'dld' ),
        'search_items'        => __( 'Search Staff', 'dld' ),
        'not_found'           => __( 'Not Found', 'dld' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'dld' ),
    );
     
    $args = array(
        'label'               => __( 'staff', 'dld' ),
        'description'         => __( 'Custom Staff', 'dld' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'revisions', ),
        'taxonomies'          => array( '' ),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon'			  => 'dashicons-businessman',
    );

    register_post_type( 'staff', $args );
			
			if( !( taxonomy_exists( 'department' ) ) ){
				register_taxonomy('department', 'staff', array(
					'label'			=>  __('Department') ,
					'rewrite'		=> array( 'slug' => 'department' ),
					'hierarchical'	=> true,
				));
				if( !( term_exists( 'Parts Department','department' ) ) ){
					wp_insert_term( 'Parts Department','department' );
				}
				if( !( term_exists( 'Sales Department','department' ) ) ){
					wp_insert_term( 'Sales Department','department' );
				}
				if( !( term_exists( 'Service Department','department' ) ) ){
					wp_insert_term( 'Service Department','department' );
				}
				if( !( term_exists( 'Management Department','department' ) ) ){
					wp_insert_term( 'Management Department','department' );
				}
				if( !( term_exists( 'Administative Department','department' ) ) ){
					wp_insert_term( 'Administrative Department','department' );
				}
			}
 
}
add_action( 'init', 'staff_pages', 0 );
