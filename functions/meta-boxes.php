<?php
/**
* Adds custom meta boxes to hold information about a Staff Post,
*/	
function add_meta_box_staff( ) {
	add_meta_box('staff_meta2', 'Job Position','populate_staff_job_meta_box','staff' );
	add_meta_box('staff_meta', 'Additional Information', 'populate_staff_additional_meta_box', 'staff' );
	//  add_meta_box('staff_image', 'Add Staff Image', 'populate_staff_image_meta_box', 'staff' );
	
	add_meta_box('listingimagediv', __( 'Staff Image', 'text-domain' ), 'listing_image_metabox', 'staff');
	add_meta_box('staff_bio', 'Add Staff Bio', 'staff_bio_meta_box', 'staff' );
}
add_action('add_meta_boxes', 'add_meta_box_staff');

/**
* Fills in meta boxes with Staff Post's saved job information
* @param Staff Post $post
*/
function populate_staff_job_meta_box( $post ) {
	$s_JobTitle = get_post_meta($post->ID, 'JobTitle', 1);
	$s_Phone = get_post_meta($post->ID, 'StaffPhone', 1);
	$s_Email = get_post_meta($post->ID, 'StaffEmail', 1);	
	?>
	<style>
#post-body #normal-sortables {min-height:0 !important;}
	</style>
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


function listing_image_metabox ( $post ) {
	global $content_width, $_wp_additional_image_sizes;
	$image_id = get_post_meta( $post->ID, '_listing_image_id', true );
	$old_content_width = $content_width;
	$content_width = 254;
	if ( $image_id && get_post( $image_id ) ) {
		if ( ! isset( $_wp_additional_image_sizes['staff-image'] ) ) {
			$thumbnail_html = wp_get_attachment_image( $image_id, array( $content_width, $content_width ) );
		} else {
			$thumbnail_html = wp_get_attachment_image( $image_id, 'staff-image' );
		}
		if ( ! empty( $thumbnail_html ) ) {
			$content = $thumbnail_html;
			$content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_listing_image_button" >' . esc_html__( 'Remove listing image', 'text-domain' ) . '</a></p>';
			$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="' . esc_attr( $image_id ) . '" />';
		}
		$content_width = $old_content_width;
	} else {
		$content = '<img src="" style="width:' . esc_attr( $content_width ) . 'px;height:auto;border:0;display:none;" />';
		$content .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set staff image', 'text-domain' ) . '" href="javascript:;" id="upload_listing_image_button" id="set-listing-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'text-domain' ) . '" data-uploader_button_text="' . esc_attr__( 'Set staff image', 'text-domain' ) . '">' . esc_html__( 'Set staff image', 'text-domain' ) . '</a></p>';
		$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="" />';
	}
	echo $content;
}

// function populate_staff_image_meta_box( $post ){
// 	global $_wp_additional_image_sizes;
// 	$image_id = get_post_meta( $post->ID, '_listing_image_id', true );

// 	if ( $image_id && get_post( $image_id ) ) {
// 		if ( ! isset( $_wp_additional_image_sizes['staff-image'] ) ) {
// 			$thumbnail_html = wp_get_attachment_image( $image_id, array( $content_width, $content_width ) );
// 		} else {
// 			$thumbnail_html = wp_get_attachment_image( $image_id, 'staff-image' );
// 		}
// 		if ( ! empty( $thumbnail_html ) ) {
// 			$content = $thumbnail_html;
// 			$content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_listing_image_button" >' . esc_html__( 'Remove listing image', 'text-domain' ) . '</a></p>';
// 			$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="' . esc_attr( $image_id ) . '" />';
// 		}
// 		$content_width = $old_content_width;
// 	} else {
// 		$content = '<img src="" style="width:150px;height:auto;border:0;display:none;" />';
// 		$content .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set staff image', 'text-domain' ) . '" href="javascript:;" id="upload_listing_image_button" id="set-listing-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'text-domain' ) . '" data-uploader_button_text="' . esc_attr__( 'Set staff image', 'text-domain' ) . '">' . esc_html__( 'Set staff image', 'text-domain' ) . '</a></p>';
// 		$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="" />';
// 	}
// 	echo $content;
// }


function staff_bio_meta_box( $o_Post ) {
	$s_Bio = get_post_meta( $o_Post->ID, 'StaffBio', true );
	wp_editor( $s_Bio, 'StaffBio', array( 'textarea_rows' => 20, 'media_buttons' => false ) );
}

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