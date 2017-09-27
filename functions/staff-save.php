<?php
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
		} else {
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
}
add_action('save_post', 'staff_save_post');
