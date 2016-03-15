<script>
jQuery(function ($) {

	var id = "<?php echo esc_js( $popup_id ) ?>";

	var uniq_id = "<?php echo esc_js( $uniq_id ) ?>";

	var submit_url = "<?php echo wpp_email_manager_store_link() ?>";

	var options = <?php $this->echo_popup_options_in_json( $popup_id ) ?>;

	var rules = options.rules;
	
	if ( ! wpp_check_rules( rules, id ) )
		return false;

	var do_popup_function = function() {
		$.colorbox({
			inline: true,
			fixed: true,

			href: "#<?php echo $this->id . '-auto_popup-' . $popup_id ?>",
			className: 'cbox_wpp_theme_8',
			overlayClose: false,
			escKey: false,
			transition: options.transition,

			onOpen: function() {
				$(".colorbox").css("opacity", 0);
			},

			onComplete: function() {
				$('.cbox_wpp_theme_8.cboxOverlay').css( 'background', options.mask_color );
				$(".colorbox").css("opacity", 1);
			},

			onClosed: function() {

				if ( rules.use_cookies )
					wpp_place_popup_close_cookie( id, rules.cookie_expiration_time );
			}
		});

		$('#cboxOverlay.cbox_wpp_theme_8').css( 'background', options.mask_color );

		$('.cbox_wpp_theme_8 .cboxLoadedContent').css( 'border-color', options.border_color );
	
	};

	if ( rules.exit_popup ) {

		wpp_do_exit_popup( do_popup_function );

	} else if ( rules.when_post_end_rule ) {

		wpp_check_when_post_rule( do_popup_function );

	} else {

		setTimeout( do_popup_function, options.delay_time );
	
	}

	if ( rules.comment_autofill ) {
		
		wpp_do_comment_autofill( uniq_id, '<?php echo esc_js(COOKIEHASH) ?>' );
	
	}
	 
	$('.' + uniq_id + ' .d8_subscribeButton' ).click(function(e){
		e.preventDefault();

		wpp_handle_form_submit( id, uniq_id, submit_url, rules.cookie_expiration_time );
	});

});
</script>


<!-- This contains the hidden content for popup -->
<div style='display:none'>

	<div id='<?php echo $this->id . '-auto_popup-' . $popup_id ?>' style='padding:0px;' class="<?php echo $uniq_id ?> wpp_theme_8 bg_d8">

	
		<form>
		
		<div class="heading1_d8"><span><?php echo $settings['heading'] ?></span></div>
		<div class="heading2_d8"><span><?php echo $settings['sub-heading'] ?></span></div>

		<div class="heading3_d8"> <span><?php echo $settings['description'] ?></span></div>

		<div class="subscribe_d8">
			<p style="margin:0;padding:0;margin-bottom: 10px"><span class="span_d8"><?php echo $settings['teaser-text'] ?></span></p>
			<div class="d8_subscribeButton"><span class="d8_subscribeNowText"><?php echo $settings['button-text'] ?></span></div>
			<input type="text" name="name" class="d8_nameTf" placeholder="<?php echo $settings['enter-name-text'] ?>" />
			<input type="email" name="email" class="d8_emailTf" placeholder="<?php echo $settings['enter-email-text'] ?>"  />
		</div>
		<br style="clear: both" />
		<div class="privacy_d8"><?php echo $settings['privacy-text'] ?></div>

		<input type="hidden" name="wpp_email_manager_nonce" value="<?php echo wpp_email_manager_nonce() ?>" />
		
		</form>

	</div>

</div>

<style>

.cbox_wpp_theme_8 #cboxLoadedContent {
	border: 0;
	background: none;
	overflow: hidden !important;
}

.cbox_wpp_theme_8 #cboxClose {
	position: absolute;
	top: -20px;
    right: -10px;
}

.cbox_wpp_theme_8 #cboxLoadedContent #wpp_success_message {
	padding: 20px;
}

.bg_d8 input:focus, .bg_d8 input:hover, 
.bg_d8 input:focus, .bg_d8 input:hover {
	outline:0px !important;
    -webkit-appearance:none;
}

.bg_d8 {
	background-image: url('<?php echo plugins_url( "images/bg_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 600px;
	height: 360px;
}
.heading1_d8 {
	margin: 0 !important;
	padding: 0 !important;
	width: 600px;
	height: 70px;
	text-align: center;
	font-family: Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", sans-serif;
	font-size: 30px;
	padding-top: 20px !important;
	color: #207886;
}
.heading2_d8 {
	margin: 0 !important;
	padding: 0 !important;
	width: 600px;
	height: 70px;
	text-align: center;
	font-family: Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", sans-serif;
	font-size: 30px;
	padding-top: 10px !important;
	color: #126572;
}
.heading3_d8 {
	margin: 0 !important;
	padding: 0 !important;
	width: 600px;
	height: 62px;
	margin: 0;
	padding: 0;
	text-align: left;
	font-family: Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", sans-serif;
	font-size: 18px;
	color: #126572;
	margin-left: 20px !important;
	max-width: 590px;
	line-height: 1.2;
	
}
.subscribe_d8 {
	font-family: Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", sans-serif;
	margin: 0 !important;
	padding: 0 !important;
	padding-left: 20px !important;
	padding-right: 20px !important;
	font-size: 25px;
	color: #126572;
}

.subscribe_d8 .span_d8{
	margin: 0;
	padding: 0;
}

.d8_emailTf {
	margin: 0 !important;
	padding: 0 !important;
	background-color: transparent;
	background-image: url('<?php echo plugins_url( "images/email_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	height: 36px !important;
	border: none;
	padding-left: 30px !important;
	padding-top: 0px !important;
	margin-top: 10px !important;
	font-size: 14px;
	float:left;
	width:30% !important;
	margin-left: 10px !important;
}
.d8_nameTf {
	margin: 0 !important;
	padding: 0 !important;
	background-color: transparent;
	background-image: url('<?php echo plugins_url( "images/name_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	height: 36px !important;
	border: none;
	padding-left: 30px !important;
	margin-top: 10px !important;
	font-size: 14px;
	padding-top: 0px !important;
	float:left; 
	width:30% !important;
}
.d8_subscribeButton {
	background-image: url('<?php echo plugins_url( "images/button_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 145px;
	height: 36px;
	text-align: center;
	color: #0e323d;
	clear: both;
	float: right;
	margin-top: 10px;
}
.d8_subscribeNowText {
	font-size: 20px;
	display: block;
	cursor: pointer;
	height: 35px;
	line-height: 35px;
	color: black;
}
.privacy_d8 {
	background-image: url('<?php echo plugins_url( "images/lock.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	text-align: left;
	margin-left: 20px;
	height: 30px;
	padding-top: 20px;
	padding-left: 20px;
	background-position: 5px;
	line-height: 1.4em;
	font-size: 10px;
}

</style>