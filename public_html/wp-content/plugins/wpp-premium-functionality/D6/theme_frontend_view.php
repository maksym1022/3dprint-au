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
			className: 'cbox_wpp_theme_6',
			overlayClose: false,
			escKey: false,
			transition: options.transition,

			onOpen: function() {
				$(".colorbox").css("opacity", 0);
			},

			onComplete: function() {
				$('.cbox_wpp_theme_6.cboxOverlay').css( 'background', options.mask_color );
				$(".colorbox").css("opacity", 1);
			},

			onClosed: function() {

				if ( rules.use_cookies )
					wpp_place_popup_close_cookie( id, rules.cookie_expiration_time );
			}
		});

		$('#cboxOverlay.cbox_wpp_theme_6').css( 'background', options.mask_color );

		$('.cbox_wpp_theme_6 .cboxLoadedContent').css( 'border-color', options.border_color );
	
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
	 
	$('.' + uniq_id + ' .wpp_d6_subscribe_button' ).click(function(e){
		e.preventDefault();

		wpp_handle_form_submit( id, uniq_id, submit_url, rules.cookie_expiration_time );
	});

});
</script>


<!-- This contains the hidden content for popup -->
<div style='display:none'>

<div id='<?php echo $this->id . '-auto_popup-' . $popup_id ?>' style='padding:0px;' class="<?php echo $uniq_id ?> wpp_theme_6 wpp_d6_bg">
	<form>
  <div class="wpp_d6_box_code">
  	<?php echo $settings['box-code'] ?>
  </div>
  <div class="wpp_d6_banner"><div class="wpp_d6_banner_text"><?php echo $settings['heading'] ?></div></div>
  <div>
    <input class="wpp_d6_name" placeholder="<?php echo $settings['enter-name-text'] ?>" type="text" name="name" />
    <br />
    <input class="wpp_d6_email" placeholder="<?php echo $settings['enter-email-text'] ?>" type="email" name="email" />
    <div class="wpp_d6_btn_cont">
    <button type="button" class="wpp_d6_subscribe_button"><?php echo $settings['button-text'] ?></button>
	</div>
  </div>
  <div class="wpp_d6_oth">
  <?php echo $settings['privacy-text'] ?>
  </div>
  <input type="hidden" name="wpp_email_manager_nonce" value="<?php echo wpp_email_manager_nonce() ?>" />
</form>
</div>

</div>

<style>

.cbox_wpp_theme_6 #cboxLoadedContent {
	background: none;
	overflow: hidden !important;
}

.cbox_wpp_theme_6 #cboxLoadedContent #wpp_success_message {
	padding: 20px;
	color: #fff;
}

.wpp_d6_bg {
	background-image: url('<?php echo plugins_url( "images/bg_d6.png", __FILE__ ) ?>');
	width: 395px;
	height: 516px;
	background-repeat: no-repeat;
	margin: auto;
}
.wpp_d6_box_code {
	margin: 0;
	padding: 0;
	display: inline-block;
	width: 320px;
	height: 240px;
	margin-top: 10px;
	margin-left: 40px;
}

.wpp_d6_box_code video {
	background-color: #000;
}

.wpp_d6_banner {
	background-color: #232323;
	width: 395px;
	height: 53px;
	margin-left: 0px;
	/*margin-top: -46px;*/
}

.wpp_d6_banner_text {
	text-align: center;
	font-size: 34px;
	height: 53px;
	line-height: 53px;
	color: #afafaf;
	letter-spacing: 1px;
}

.wpp_d6_name {
	padding: 0;
	margin: 0;
	background-image: url('<?php echo plugins_url( "images/name_d6.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 317px;
	height: 43px;
	background-color: transparent;
	border: none;
	padding-left: 40px;
	margin-left: 50px;
	margin-top: 10px;
	color: #FFF;
	font-family: Arial;
}
.wpp_d6_email {
	padding: 0;
	margin: 0;
	background-image: url('<?php echo plugins_url( "images/email_d6.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 317px;
	height: 43px;
	background-color: transparent;
	border: none;
	padding-left: 40px;
	margin-left: 50px;
	margin-top: 5px;
	color: #FFF;
	font-family: Arial;
}

.wpp_d6_lock{
	margin-left: 81px;
	margin-top: 5px;
	position: absolute;
}
	
.wpp_d6_oth{
	background-image: url('<?php echo plugins_url( "images/lock_d6.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	text-align: left;
	margin-left: 20px;
	height: 30px;
	padding-top: 20px;
	padding-left: 20px;
	background-position: 5px;
	font-family: Arial;
	color: #fff;
	font-size: 10px;
	margin-top: 0px;
}

.wpp_d6_btn_cont {
	margin: 0;
	padding: 0;
	text-align: center;
}
.wpp_d6_subscribe_button {
	cursor: pointer;
	padding: 0;
	margin: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 26px;
	color: #ffffff;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#f0f0f0 0%,
		#b8b8b8 25%,
		#6b6b6b 75%,
		#424242);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#f0f0f0),
		color-stop(0.25, #b8b8b8),
		color-stop(0.75, #6b6b6b),
		to(#424242));
	-moz-border-radius: 15px;
	-webkit-border-radius: 15px;
	border-radius: 15px;
	border: 3px solid #171717;
	-moz-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 10px rgba(087,087,087,0.7);
	-webkit-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 10px rgba(087,087,087,0.7);
	box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 10px rgba(087,087,087,0.7);
	text-shadow:
		0px -1px 0px rgba(000,000,000,0.4),
		0px 1px 0px rgba(255,255,255,0.3);

	margin-top: 10px;
}

.wpp_d6_bg input:focus, .wpp_d6_bg input:hover, 
.wpp_d6_bg input:focus, .wpp_d6_bg input:hover {
	outline:0px !important;
    -webkit-appearance:none;
}

</style>
