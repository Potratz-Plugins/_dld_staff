<?php
// if ( ! class_exists( 'Staff' ) ) {
// 	class Staff {
// 		public function __construct( ) {
				
// 		}
// 		function getAllStaff() {
// 			return get_posts(array("post_type" => "staff", "numberposts" => '-1'));
// 		}
// 	}
// }

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
        'supports'            => array( 'title', 'revisions'),
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

// Ensure Featured Image Support for the Custom Post Type, without stepping on other plug-in toes
$currentPostThumbnails = get_theme_support('post-thumbnails');
if(is_array($currentPostThumbnails)) {
        add_theme_support( 'post-thumbnails', array_merge($currentPostThumbnails, array( 'staff' )) );
    } else {
        add_theme_support( 'post-thumbnails', 'staff');
}

add_image_size( 'staff-image', 300, 400, true );
function dld_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'staff-image' => __('Staff Image'),
        )
    );
}
add_filter( 'image_size_names_choose', 'dld_image_sizes' );
    
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
add_action( 'init', 'staff_pages' );

function dld_staff_sub_menu(){
   add_submenu_page('edit.php?post_type=staff', 'Staff Page Options', 'Options', 'manage_options', 'staff-options', 'dld_render_options_page');
}
add_action('admin_menu','dld_staff_sub_menu');


add_action( 'admin_init', 'dld_render_options_settings' );
function dld_render_options_settings() {
    register_setting( 'dld-options-settings-group', 'staff_custom_css' );
    register_setting( 'dld-options-settings-group', 'some_other_option' );
}

function dld_render_options_page() { ?>

   <div class='wrap'>
    <h2>Staff Page Options</h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'dld-options-settings-group' ); ?>
        <?php do_settings_sections( 'dld-options-settings-group' ); ?>
        <table class="form-table">
          <tr valign="top">
          <th scope="row">Custom CSS:</th>
          <td>
            <textarea name="staff_custom_css" width="100%" rows="10" cols="100%"><?php echo get_option( 'staff_custom_css' ); ?></textarea>
          </td>
          </tr>
          <tr valign="top">
          <th scope="row">New Option 2:</th>
          <td><input type="text" name="some_other_option" value="<?php echo get_option( 'some_other_option' ); ?>"/></td>
          </tr>
        </table>
    <?php submit_button(); ?>

    </form>
   </div>

   <?php
}

