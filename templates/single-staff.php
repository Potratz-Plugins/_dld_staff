<?php
/**
 * The template for displaying all single posts.
 *
 * @package alpha
 */
get_header();
$a_CurrentStaff = get_post_meta( get_the_ID() );
$a_Department = reset( get_the_terms( get_the_ID(), 'department' ) );
$s_Name = get_the_title();
$s_FirstName = explode( ' ', $s_Name );
$s_FirstName = $s_FirstName[0];
$s_ImageAltText = $s_Name . ", a " . ( $a_CurrentStaff['JobTitle'][0] == "" ? " member of the ": $a_CurrentStaff['JobTitle'][0]." in the " ) . $a_Department->name;
if( isset( $a_CurrentStaff['ImageURL'][0] ) && "" != $a_CurrentStaff['ImageURL'][0] ) {
	$s_ImageURL = $a_CurrentStaff['ImageURL'][0];
	} else {
	$s_ImageURL = plugin_dir_url( 'staff' )."staff/images/noStaffPic.png";
}

if ( !empty( $a_CurrentStaff['YouTubeURL'][0] ) ) {
	preg_match( '/width=["|\'](.*?)["|\']/', $a_CurrentStaff['YouTubeURL'][0], $s_VideoWidth );
	preg_match( '/height=["|\'](.*?)["|\']/', $a_CurrentStaff['YouTubeURL'][0], $s_VideoHeight );
	preg_match( '/src=["|\'](.*?)["|\']/', $a_CurrentStaff['YouTubeURL'][0], $s_VideoSource);
}

$o_StaffPage = get_page_by_title( 'Meet Our Staff' );
$s_BackLink = get_permalink( $o_StaffPage );
?>

<div class="page-content clearfix">
	<div class="StaffHeader">
		<div class="PageTitle StaffHeaderText primary-txt">
				<span class="black-txt">Meet:</span> <?php the_title(); ?>
		</div>
		<section class="col-xs-12 pad-0">
			<div class="col-xs-12 black-bg">
				<div class="MaxWidth clearfix TextCenter pad-10">
					<div class="BackLink TextLeft">
		<a href="<?php echo $s_BackLink; ?>" class="white-txt" style="font-size:.9em; text-decoration:none !important;"><i class="fa fa-angle-double-left pad-5"></i>Back To All Staff</a>
	</div>
				</div>
			</div>

			<div class="col-xs-12 pad-0 staff">
					<div class="MaxWidth">
						<div class="clearfix TextCenter pad-0" style="margin-bottom:-20px;">
							<i class="fa fa-caret-down fa-5x black-txt" style="margin-top: -28px;z-index:1;"></i>
						</div>
						<div class="col-xs-12 pad-top-10">
							<div class="pad-20 clearfix" style="border-radius:10px;border:1px solid #ccc;background-color:rgba(255,255,255,.8);">
								<div class="col-sm-4 col-xs-12 clearfix">
									<div class="StaffImage CenterMobile">
										<img class="ease" src="<?php echo $s_ImageURL; ?>" alt="<?php echo $s_ImageAltText; ?>" />
									</div>
								</div>
								<div class="col-sm-4 col-xs-12 clearfix pad-top-bottom-10">
									<div class="StaffName CenterTextMobile" style="font-size:2em;">
										<?php echo $s_Name; ?>
									</div>

	<?php if ( !empty( $a_CurrentStaff['JobTitle'][0] ) ) { ?>
		<div class="StaffJobTitle CenterTextMobile pad-bottom-10" style="font-size:1.6em; font-weight:100;">
			<i><?php echo $a_CurrentStaff['JobTitle'][0]; ?></i>
		</div>
	<?php } ?>

									<div class="CenterTextMobile pad-bottom-10" style="font-size:1.6em;">
										<i class="fa primary-txt fa-clipboard pad-right-10"></i><?php echo $a_Department->name; ?>
									</div>

						<?php  if ( !empty( $a_CurrentStaff['StaffBio'][0] ) ) { ?>
									<div class="StaffBio TextJustify" style="clear:left;">
										<span>

											<span style="font-weight:700;"><?php echo $s_FirstName; ?>'s Bio - </span><?php echo $a_CurrentStaff['StaffBio'][0]; ?>
										</span>
									</div>
						<?php  } ?>

								</div>
								<div class="col-sm-4 col-xs-12 clearfix">

		<?php if ( !empty( $a_CurrentStaff['StaffPhone'][0] ) ) { ?>
									<div class="StaffPhoneNumber CenterMobile pad-top-bottom-10" style="font-size:1.5em; text-align:center;">
				<?php if ( true === wp_is_mobile() ) { ?>
										<a href="tel:<?php echo $a_CurrentStaff['StaffPhone'][0]; ?>"><span class="fa-stack pad-right-10"><i class="fa fa-circle fa-stack-2x green-txt"></i><i class="fa fa-phone fa-stack-1x fa-inverse"></i></span> <span style="font-size:1.2em"><?php echo $a_CurrentStaff['StaffPhone'][0]; ?></span></a>
				<?php } else { ?>
										<span class="fa-stack pad-right-10"><i class="fa fa-circle fa-stack-2x green-txt"></i><i class="fa fa-phone fa-stack-1x fa-inverse"></i></span> <span style="font-size:1.2em"><?php echo $a_CurrentStaff['StaffPhone'][0]; ?></span>
				<?php } ?>
									</div>

		<?php } ?>

									<div class="CenterTextMobile pad-top-bottom-10">
										<div class="CenterBio">

			<?php if ( !empty( $a_CurrentStaff['StaffEmail'][0] ) ) { ?>
				<div class="col-lg-12 col-med-12 col-sm-12 col-xs-12 StaffEmail pad-bottom-10">
					<a class="btn btn-alt6 btn-block btn-ease" href="mailto:<?php echo $a_CurrentStaff['StaffEmail'][0]; ?>"><i class="fa fa-envelope pad-right-10"></i>Email <?php echo $s_FirstName; ?></a>
				</div>
			<?php } ?>

			<?php if ( !empty( $a_CurrentStaff['FacebookURL'][0] ) ) { ?>
				<div class="col-lg-6 col-med-6 col-sm-6 col-xs-6 StaffFacebook TextRight">
					<a href="<?php echo $a_CurrentStaff['FacebookURL'][0]; ?>"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x black-txt"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span></a>
				</div>
			<?php } ?>

			<?php if ( !empty( $a_CurrentStaff['LinkedInURL'][0] ) ) { ?>
				<div class="col-lg-6 col-med-6 col-sm-6 col-xs-6 StaffLinkedin">
					<a href="<?php echo $a_CurrentStaff['LinkedInURL'][0]; ?>"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x black-txt"></i><i class="fa fa-linkedin fa-stack-1x fa-inverse"></i></span></a>
				</div>
			<?php } ?>

										</div>
									</div>
							 	</div>
							</div>
						</div>
						<div>
							<div style="height:1px; background-color:#fff; margin:40px 0;">&nbsp;</div>
						</div>

<?php if ( !empty( $a_CurrentStaff['YouTubeURL'][0] ) ) { ?>

						<div class="col-xs-12" style="margin-bottom:50px;">
							<div class="col-sm-7 col-xs-12">
								<div class="StaffVideo" style="max-width:<?php echo $s_VideoWidth[1]; ?>px;max-height:<?php echo $s_VideoHeight[1]; ?>px;">

									<div class="embed-responsive embed-responsive-16by9" style="border:5px solid #fff;border-radius:5px; margin-bottom:15px;">
				    					<iframe  class="embed-responsive-item" src="<?php echo $s_VideoSource[1]; ?>"></iframe>
									</div>
								</div>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
								<a href="<?php echo get_permalink( get_page_by_title( 'Contact Us' ) ); ?>" class="btn btn-primary btn-block btn-ease margin-bottom-10"><i class="fa fa-map-marker pad-right-10"></i>Come See Us</a>
								<a href="<?php echo get_permalink( get_page_by_title( 'Testimonials' ) ); ?>" class="btn btn-primary btn-block btn-ease margin-bottom-10"><i class="fa fa-quote-left pad-right-10"></i>What People Say</a>
								<a href="<?php echo get_permalink( get_page_by_title( 'Career Opportunities' ) ); ?>" class="btn btn-primary btn-block btn-ease margin-bottom-10"><i class="fa fa-comments pad-right-10"></i>Start A Career With Us</a>
							</div>
						</div>
	<?php } else { ?>
						<div class="col-xs-12">
							<div class="col-sm-4 col-xs-12">
								<a href="<?php echo get_permalink( get_page_by_title( 'Contact Us' ) ); ?>" class="btn btn-primary btn-block btn-ease margin-bottom-10"><i class="fa fa-map-marker pad-right-10"></i>Come See Us</a>
							</div>
							<div class="col-sm-4 col-xs-12">
								<a href="<?php echo get_permalink( get_page_by_title( 'Testimonials' ) ); ?>" class="btn btn-primary btn-block btn-ease margin-bottom-10"><i class="fa fa-quote-left pad-right-10"></i>What People Say</a>
							</div>
							<div class="col-sm-4 col-xs-12">
								<a href="<?php echo get_permalink( get_page_by_title( 'Career Opportunities' ) ); ?>" class="btn btn-primary btn-block btn-ease margin-bottom-10"><i class="fa fa-comments pad-right-10"></i>Start A Career With Us</a>
							</div>
						</div>
	<?php }?>

					</div>
			</div>
		</section>
	</div>
</div>

<?php get_footer(); ?>