jQuery(function($){
  // Set all variables to be used in scope
  var frame,
      addImgLink = $('.select-img'),
      imgIdInput = $('.img');
      imgDisplay = $('#img');
      imgContainer = $('#img');
  // ADD IMAGE LINK
  addImgLink.on( 'click', function( event ){
    event.preventDefault();
    if ( frame ) {
      frame.open();
      return;
    }
    frame = wp.media({
      title: 'Select or Upload Image',
      button: {
        text: 'Use this Image'
      },
      multiple: false 
    });
    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();
      // Send the attachment URL to our custom image input field.
      imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:150px;"/>' );
      // Send the attachment id to our input field
      imgIdInput.val( attachment.url );
      imgDisplay.src( attachment.url );
    });
    // Finally, open the modal on click
    frame.open();
  });
});