<?php
/*
 * Plugin Name: Staff
 * Description: Allows add/edit/delete of staff members
 * Version: 0.1
 * Author: Scott Warren
 */
include_once "class/class.staff.php";
/* This chunck until end comment is to create, redirect staff page to templated file */
function dld_staff_activation() {
	$PageExists = get_page_by_title( 'Staff' );
	if ( $PageExists == null ) {
		$a_Page = array(
				'post_title'    => 'Staff',
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
	$PageExists = get_page_by_title( 'Staff' );
	if ( $PageExists != null ) {
		wp_delete_post( $PageExists->ID, true );
	}
}
register_deactivation_hook( __FILE__, 'dld_staff_deactivation' );


// add_action( "template_redirect", 'dld_staff_redirect' );
// function dld_staff_redirect() {
// 	global $wp;
// 	$themedir = get_template_directory();
// 	//A Specific Custom Post Type
// 	if ($wp->query_vars["pagename"] == 'staff') {
// 		$templatefilename = 'template-staff.php';
// 		if ( file_exists( TEMPLATEPATH . '/' . $templatefilename ) ) {
// 			$return_template = TEMPLATEPATH . '/' . $templatefilename;
// 		} else {
// 			$return_template = $themedir . '/page-templates/' . $templatefilename;
// 		}
// 		dld_staff_do_redirect($return_template);

// 		echo $return_template;
// 	}
// }

// function dld_staff_do_redirect($url) {
// 	global $post, $wp_query;
// 	if (have_posts()) {
// 		include($url);
// 		die();
// 	} else {
// 		$wp_query->is_404 = true;
// 	}
// }
/* END OF STAFF REDIRECT */


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
	
/**
* Adds custom meta boxes to hold information about a Staff Post,
*/	
function add_meta_box_staff( ) {
	add_meta_box('staff_meta2', 'Job Position','populate_staff_job_meta_box','staff' );
	add_meta_box('staff_meta', 'Additional Information', 'populate_staff_additional_meta_box', 'staff' );
	add_meta_box('staff_image', 'Add Staff Image', 'populate_staff_image_meta_box', 'staff' );
	add_meta_box('staff_bio', 'Add Staff Bio', 'staff_bio_meta_box', 'staff' );
}
add_action('add_meta_boxes', 'add_meta_box_staff');

function staff_bio_meta_box( $o_Post ) {
	$s_Bio = get_post_meta( $o_Post->ID, 'StaffBio', true );
	wp_editor( $s_Bio, 'StaffBio', array( 'textarea_rows' => 20, 'media_buttons' => false ) );
}

function update_edit_form() {
	echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'update_edit_form');

/**
* Fills in meta boxes with Staff Post's saved job information
* @param Staff Post $post
*/
function populate_staff_job_meta_box( $post ) {
	$s_JobTitle = get_post_meta($post->ID, 'JobTitle', 1);
	$s_Phone = get_post_meta($post->ID, 'StaffPhone', 1);
	$s_Email = get_post_meta($post->ID, 'StaffEmail', 1);	
	?>
	<!-- Defines the meta boxes -->
	<table style="width: 100%;">
		<tr>
			<td><label for="JobTitle">Job Title:</label></td>
			<td><input type="text" id='JobTitle' name='JobTitle' value='<?php echo($s_JobTitle); ?>' style="width:100%;" /></td>
		</tr>
		<tr>
			<td><label for="StaffPhone">Phone:</label></td>
			<td><input type="text" id='StaffPhone' name='StaffPhone' value='<?php echo($s_Phone); ?>' style="width:100%;" /></td>
		</tr>
		<tr>
			<td><label for="StaffEmail">Email:</label></td>
			<td><input type="email" id='StaffEmail' name='StaffEmail' value='<?php echo($s_Email); ?>' style="width:100%;" /></td>
		</tr>
	</table>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('#StaffPhone').mask( '(999) 999-9999 x999' );
			//remove the "permalink box"
			$('#edit-slug-box').css( 'display', 'none');
		});
	</script>
<?php 		
	}

/**
 * Fills in additional information meta boxes
 * @param Staff Post $post
 */
function populate_staff_additional_meta_box( $post ) {
	$s_FacebookURL = get_post_meta($post->ID, 'FacebookURL', 1);
	$s_LinkedInURL = get_post_meta($post->ID, 'LinkedInURL', 1);
	$s_Email = get_post_meta($post->ID, 'StaffEmail', 1);
	$s_Phone = get_post_meta($post->ID, 'StaffPhone', 1);
	$s_YouTubeURL = get_post_meta($post->ID, 'YouTubeURL', 1);
	$s_DealerRaterURL = get_post_meta($post->ID, 'DealerRaterURL', 1);
	?>	
<!-- Defines meta boxes -->	
<table style="width: 100%;">
	<tr>
		<td><label for="FacebookURL">Facebook:</label></td>
		<td><input type="text" id='FacebookURL' name='FacebookURL' value='<?php echo($s_FacebookURL); ?>' style="width:100%;" /></td>
	</tr>
	<tr>
		<td><label for="LinkedInURL">Linked In:</label></td>
		<td><input type="text" id='LinkedInURL' name='LinkedInURL' value='<?php echo($s_LinkedInURL); ?>' style="width:100%;" /></td>
	</tr>
	<tr>
		<td><label for="YouTubeURL">Youtube:</label></td>
		<td><input type="text" id='YouTubeURL' name='YouTubeURL' value='<?php echo($s_YouTubeURL); ?>' style="width:100%;" /></td>
	</tr>
	<tr>
		<td><label for="DealerRaterURL">Dealer Rater Link:</label></td>
		<td><input type="text" id='DealerRaterURL' name='DealerRaterURL' value='<?php echo($s_DealerRaterURL); ?>' style="width:100%;" /></td>
	</tr>
</table>
<?php 		
}

function populate_staff_image_meta_box( $post ){
	$s_StaffImageURL = get_post_meta( $post->ID, 'ImageURL', 1 );
// $s_StaffImageURL = get_post_meta( $post->ID );

	// var_dump($s_StaffImageURL);
	if(isset($s_StaffImageURL)) {$s_ImageURL = esc_attr($s_StaffImageURL);} else {$s_ImageURL = plugin_dir_url( __FILE__ )."/images/noStaffPic.png";}
?>
<table style="width:100%">
	<tr>
		<td style="max-width:50px;">
			<label>Current Picture: </label>
		</td>
		<td>
			<img id="CurrentImage" src="<?php echo $s_ImageURL; ?>" style="max-width:150px;width:100%;" />
		</td>
	</tr>
	<tr>
		<td style="max-width:50px;">
			<label for="StaffUpload">Add New Picture: </label>
		</td>
		<td>
			<div id="img"></div>
      		<input type="hidden" class="img" name="ImageURL" id="ImageURL" value="<?php echo $s_ImageURL; ?>" />
      		<input type="button" class="select-img" value="Select Image" />

<!-- 			<input id="StaffUpload" type="file" name="StaffImage" value="" autocomplete="off" accept="image/*" size="25" />
			<button id="StaffResetImage">Reset</button> -->
		</td>
	</tr>
</table>

<script type="text/javascript">
 // jQuery(document).ready(function($){

	//  $('#StaffResetImage').click(function( event ){
	// 	event.preventDefault();
	// 	$('#CurrentImage').attr('src', '<?php echo $s_ImageURL; ?>' );
	// 	$('#StaffUpload').val('');
	// });
		
	//  $('#StaffUpload').change(function(){
	// 	readURL( this );
	// });
	// function readURL(input) {
	// 	if (input.files && input.files[0]) {
	// 		var reader = new FileReader();
	// 		reader.onload = function (e) {
	// 			$('#CurrentImage').attr('src', e.target.result);
	// 		};
	// 		reader.readAsDataURL(input.files[0]);
	// 	}
	// }
 // });
</script>
<?php 
}

/**
 * Saves Custom Meta Content from job information and additional information meta boxes
 * Checks to make sure that content is "correct"
 * i.e. that a phone number has 7-10 numbers
 * @param unknown $post_id
 * @return unknown
 */
function staff_save_post( $post_id ) {

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}

if(isset($_POST['post_type'])) {
	if($_POST['post_type'] != 'staff') {
		return $post_id;
	}
}
	if( isset( $_POST['FacebookURL'] )  ){ 
		update_post_meta($post_id, 'FacebookURL', esc_url( $_POST['FacebookURL'] ) );
	}
	if( isset( $_POST['LinkedInURL'] )  ){
		update_post_meta($post_id, 'LinkedInURL', esc_url( $_POST['LinkedInURL'] ) );
	}
if(isset($_POST['YouTubeURL'])) {
	$youTubeURL =  $_POST['YouTubeURL'];
}
	if( isset( $youTubeURL)  ){
		
		$s_IsEmbedAlready = preg_match( '/<iframe.*<\/iframe>/i', $youTubeURL  );
		if (  $s_IsEmbedAlready ) { // if inserted data wasnt properly formatted iframe, make an instance of the wordpress embeder (is that a word?)

			preg_match( '/(?:src=")(.*?)(?:")/i',  stripslashes($youTubeURL) , $s_TrimVideoLink ); //Gets src url and saves in array
			$escapedURL = esc_url($s_TrimVideoLink[1]); //checks to see if url is valid

			if(!empty($escapedURL)){
				update_post_meta($post_id, 'YouTubeURL', $youTubeURL);
			}

		}else{

			$escapedURL = esc_url($youTubeURL);
			if(!empty($escapedURL)){
				update_post_meta($post_id, 'YouTubeURL',  wp_oembed_get($escapedURL));
			}

		}

	}
	if( isset( $_POST['DealerRaterURL'] )  ){

		if( ( stripos( $_POST['DealerRaterURL'], 'http' ) === false ) && ( $_POST['DealerRaterURL'] != '' ) ) {
		
			$_POST['DealerRaterURL'] = 'http://' . $_POST['DealerRaterURL'];

		}
		
		update_post_meta($post_id, 'DealerRaterURL', sanitize_text_field( $_POST['DealerRaterURL'] ) );
		
	}
	if( isset( $_POST['JobTitle'] )  ){
		update_post_meta($post_id, 'JobTitle', sanitize_text_field( $_POST['JobTitle'] ) );
	}
	if( isset( $_POST['StaffEmail'] )  ){
		update_post_meta($post_id, 'StaffEmail', sanitize_text_field( $_POST['StaffEmail'] ) );
	}
	if( isset( $_POST['StaffPhone'] ) ){
		//will not save if a non-phone number is provided, but does not send error message yet
		update_post_meta($post_id, 'StaffPhone', sanitize_text_field( $_POST['StaffPhone'] ) );
	} 
	if( isset( $_POST['StaffBio'] ) ){
		$s_Bio = apply_filters( 'the_content', $_POST['StaffBio'] );
		update_post_meta( $post_id, 'StaffBio', $s_Bio );
	}
	//handle the image upload
	if( isset( $_POST['ImageURL'] ) ){
		update_post_meta( $post_id, 'ImageURL', $_POST['ImageURL'] );
	}
			
		// // Setup the array of supported file types. In this case, it's just PDF.
		// $supported_types = array('image/jpeg', 'image/jpg', 'image/png');
			
		// // Get the file type of the upload
		// $arr_file_type = wp_check_filetype( basename( $_FILES['StaffImage']['name'] ) );
		// $uploaded_type = $arr_file_type['type'];

		// // Check if the type is supported. If not, throw an error.
		// if( in_array( $uploaded_type, $supported_types ) ) {
	
		// 	// Use the WordPress API to upload the file
		// 	$upload = wp_upload_bits($_FILES['StaffImage']['name'], null, file_get_contents($_FILES['StaffImage']['tmp_name']));
	
		// 	if ( isset( $upload['error'] ) && $upload['error'] != 0 ) {
		// 		wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
		// 	} else {
		// 		update_post_meta( $post_id, 'ImageURL', $upload['url'] );
		// 	} 
		// }	
	// } 
}
add_action('save_post', 'staff_save_post');

/**
* functions to make taxonomy meta box into radio buttons to limit users to one department
* will turn any check box into a radio button, regardless of position within editor
*/
 function mysite_add_meta_boxes($post_type, $post) {
	ob_start();
}
add_action('add_meta_boxes','mysite_add_meta_boxes',10,2);

function mysite_dbx_post_sidebar( $o_Post ) {
	if ( preg_match( '/staff/i', $o_Post->guid ) ) {
		$html = ob_get_clean();
		$html = str_replace('"checkbox"','"radio"',$html);
		$html = str_replace('"maketype"','"checkbox"',$html);//qucik fix to stio Add Bio from being turned into radio btn
		echo $html;
	}
}
add_action('dbx_post_sidebar','mysite_dbx_post_sidebar');