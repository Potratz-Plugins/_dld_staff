<?php
/**
 * Template Name: Staff
 *
 */
get_header(); ?>

<div class="page-content clearfix">
	<section class="headerBG pad-0">
		<div class="MaxWidth">
			<div class="ContactTitle white-txt">Meet Our Staff</div>
		</div>
	</section>
	
	<?php 
	$a_Departments = get_terms( 'department' );
	foreach( $a_Departments as $a_Department ) {
	?>
	
	<section class=" pad-0 Department">
		<div class="black-bg pad-top-bottom-10 DepartmentTitle" style="z-index:2">
			<div class="MaxWidth clearfix TextCenter pad-0">
				<h3 class="white-txt" style="margin:0 auto;"><i class="fa fa-signal" style="margin-right:10px;"></i><?php echo $a_Department->name; ?></h3>
			</div>
		</div>
	</section>

	<section>
		<div class="pad-0 staff">
			<div class="MaxWidth">
				<div class="clearfix TextCenter pad-0" style="margin-bottom:-20px;">
					<i class="fa fa-caret-down fa-5x black-txt" style="margin-top:-28px;z-index:1;"></i>
				</div>
				<div class="col-xs-12 pad-bottom-10">
				<?php 
				$a_DepartmentStaff = new WP_Query( 
					array(
						'post_type'	=> 'staff',
						'posts_per_page' => -1,
						'tax_query'	=> array(
							'relation'	=> 'AND',
							array(
								'taxonomy'	=> $a_Department->taxonomy,
								'field'		=> 'slug',
								'terms'		=> $a_Department->slug,
							)
						),
					)
				);
				$i_Counter = 1;
				foreach( $a_DepartmentStaff->posts as $o_Staff ) {
					$a_CurrentStaff = get_post_meta( $o_Staff->ID );
					$s_Name = apply_filters( 'the_title', $o_Staff->post_title );
					$s_ImageAltText = $s_Name . ", a " . ( $a_CurrentStaff['JobTitle'][0] == "" ? " member of the ": $a_CurrentStaff['JobTitle'][0]." in the " ) . $a_Department->name;
					$image_id = get_post_meta( $o_Staff->ID, '_listing_image_id', true );
					$image = wp_get_attachment_image_src( $image_id, 'staff-image', '' );

					if( isset( $image[0] ) && "" != $image[0] ) {
						$s_ImageURL = $image[0];
					} else {
						$s_ImageURL = plugin_dir_url( 'staff' )."staff/images/noStaffPic.png";
					}		
					?>

					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 pad-5 clearfix">
						<div class="white-bg TextCenter clearfix">
							<div class="StaffImage">
								<img src="<?php echo $s_ImageURL; ?>" alt="<?php echo $s_ImageAltText; ?>" />
							</div>
							<div class="pad-top-bottom-15">
								<div class="StaffName">
									<b><?php echo $s_Name; ?></b>
								</div>							
								
								<?php if ( !empty( $a_CurrentStaff['JobTitle'][0] ) ) { ?>
									<div class="StaffJobTitle">
										<?php echo $a_CurrentStaff['JobTitle'][0]; ?>
									</div>
								<?php } ?>
								
								<?php if ( !empty( $a_CurrentStaff['StaffPhone'][0] ) ) { ?>
									
									<div class="StaffPhoneNumber">
										<?php if ( true === wp_is_mobile() ) { ?>
											<a href="tel:<?php echo $a_CurrentStaff['StaffPhone'][0]; ?>"><i class="fa fa-phone-square"></i> <?php echo $a_CurrentStaff['StaffPhone'][0]; ?></a>
										<?php } else { ?>
											<i style="padding-right:7px;font-size:1.1em" class="fa fa-phone-square"></i><p style="display:inline;"><?php echo $a_CurrentStaff['StaffPhone'][0]; ?></p>
										<?php } ?>
									</div>
									
								<?php } ?>
								
								<?php if( !empty( $a_CurrentStaff['StaffEmail'][0] ) ) { ?>
								
									<div class="StaffEmail">
										<i style="padding-right:7px;font-size:1.1em" class="fa fa-envelope-square"></i><a href="mailto:<?php echo $a_CurrentStaff['StaffEmail'][0]; ?>" style="display:inline;"><?php echo $a_CurrentStaff['StaffEmail'][0]; ?></a>
									</div>
									
								<?php } ?>
								
								<?php if( !empty( $a_CurrentStaff['DealerRaterURL'][0] ) ) { ?>
									<?php if ( true === wp_is_mobile() ) { ?>
										<div class="DealerRaterURL">
											<a href="<?php echo $a_CurrentStaff['DealerRaterURL'][0]; ?>" style="display:inline;"><i style="padding-right:7px;font-size:2.3rem" class="fa fa-comments"></i></a>
										</div>
									<?php } else { ?>
										<div class="DealerRaterURL">
											<a href="<?php echo $a_CurrentStaff['DealerRaterURL'][0]; ?>" style="display:inline;"><i style="padding-right:7px;font-size:1.1em" class="fa fa-comments"></i>DealerRater Reviews</a>
										</div>
									<?php } ?>
								<?php } ?>
								
								<?php if( !empty( $a_CurrentStaff['StaffBio'][0] ) ) { ?>
								
									<div class="StaffBioLink">
										<a class="btn btn-ease btn-alt6 pad-5" style="text-decoration:none;font-size:.9em !important;" href="<?php echo get_permalink( $o_Staff->ID ); ?>">Read Full Bio <i class="fa fa-angle-double-right"></i></a>
									</div>
									
								<?php } ?>
								
							</div>
						</div>
					</div>
					<?php 
					if ( $i_Counter % 4 == 0 ) {
						?><div class="clearfix visible-lg-block visible-md-block"></div><?php
					} elseif ( $i_Counter % 3 == 0 ) {
						?><div class="clearfix visible-sm-block"></div><?php
					} elseif ( $i_Counter % 2 == 0 ) {
						?><div class="clearfix visible-xs-block "></div><?php
					}
					$i_Counter++;
				}
				?>
				</div> <!-- END Department Staff -->
			</div>
		</div><div class="clear"></div>
	</section> <!-- END Department -->
		<?php 
	}
	?>

</div> <!-- END Page -->
<script>
(function() {
    var checkReady = function(callback) {
        if (window.jQuery) {callback(jQuery); } else { window.setTimeout(function() { checkReady(callback); }, 20);}
    };
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$('.staff').slideUp('slow');
    }
    checkReady(function($) {
		setTimeout(function() {$('.staff:first').slideDown('slow');},1000);
		$('.DepartmentTitle').on('click', function() {

			if ($(this).next('.staff').is(':hidden')) {
				$(this).next('.staff').slideDown('slow');
				$(this).addClass('primary-bg');
				$(this).next('.staff').find('.fa-caret-down').addClass('primary-txt');
			} else {
				$(this).next('.staff').slideUp('slow');
				$(this).removeClass('primary-bg');
			}
		});
    });
})();
</script>

<?php get_footer();
