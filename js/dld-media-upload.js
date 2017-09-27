jQuery(document).ready(function($) {

  // Uploading files
  var file_frame;

  jQuery.fn.upload_listing_image = function( button ) {
    var button_id = button.attr('id');
    var field_id = button_id.replace( '_button', '' );

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      var attachment = file_frame.state().get('selection').first().toJSON();
      jQuery("#"+field_id).val(attachment.id);
      jQuery("#listingimagediv img").attr('src',attachment.url);
      jQuery( '#listingimagediv img' ).show();
      jQuery( '#' + button_id ).attr( 'id', 'remove_listing_image_button' );
      jQuery( '#remove_listing_image_button' ).text( 'Remove staff image' );
    });

    // Finally, open the modal
    file_frame.open();
  };

  jQuery('#listingimagediv').on( 'click', '#upload_listing_image_button', function( event ) {
    event.preventDefault();
    jQuery.fn.upload_listing_image( jQuery(this) );
  });

  jQuery('#listingimagediv').on( 'click', '#remove_listing_image_button', function( event ) {
    event.preventDefault();
    jQuery( '#upload_listing_image' ).val( '' );
    jQuery( '#listingimagediv img' ).attr( 'src', '' );
    jQuery( '#listingimagediv img' ).hide();
    jQuery( this ).attr( 'id', 'upload_listing_image_button' );
    jQuery( '#upload_listing_image_button' ).text( 'Set staff image' );
  });

});


jQuery(function($){




  // Set all variables to be used in scope
  // var frame,
  //     addImgLink = $('.select-img'),
  //     imgIdInput = $('.img');
  //     imgDisplay = $('#img');
  //     imgContainer = $('#img');
  // // ADD IMAGE LINK
  // addImgLink.on( 'click', function( event ){
  //   event.preventDefault();
  //   if ( frame ) {
  //     frame.open();
  //     return;
  //   }

  //   frame = wp.media({
  //     frame: 'post',
  //     state: 'insert',
  //     title: 'Select or Upload Image',
  //     button: {
  //       text: 'Use this Image'
  //     },
  //     multiple: false,

  //   });
  //   // When an image is selected in the media frame...
  //   frame.on( 'select', function() {
  //     // Get media attachment details from the frame state
  //     var attachment = frame.state().get('selection').first().toJSON();
  //     // Send the attachment URL to our custom image input field.
  //     imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:150px;"/>' );
  //     // Send the attachment id to our input field
  //     imgIdInput.val( attachment.url );
  //     imgDisplay.src( attachment.url );
  //   });
  //   // Finally, open the modal on click
  //   frame.open();
  // });
});