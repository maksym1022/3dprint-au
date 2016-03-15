<script>
jQuery(function ($) {

	var id = "<?php echo esc_js( $popup_id ) ?>";
	
	var options = <?php $this->echo_popup_options_in_json( $popup_id ) ?>;

	var uniq_id = "<?php echo esc_js( $uniq_id ) ?>";

	var submit_url = "<?php echo wpp_email_manager_store_link() ?>";

	var options = <?php $this->echo_popup_options_in_json( $popup_id ) ?>;

	var rules = options.rules;

	$('.link_<?php echo $this->id . '-' . $popup_id ?>').colorbox({
		inline: true,
		fixed: true,

		className: 'cbox_wpp_theme_1',
		transition: options.transition,
		overlayClose: false,
		escKey: false,
		speed: 200,

		onOpen: function() {

				$("#colorbox").css("opacity", 0);
		
		},

		onComplete: function() {

			$("#colorbox").css("opacity", 1);

			$('#cboxOverlay.cbox_wpp_theme_1').css( 'background', options.mask_color );

			$('.cbox_wpp_theme_1 #cboxLoadedContent').css( 'border-color', options.border_color );
		}
	});

	if ( rules.comment_autofill ) {
		
		wpp_do_comment_autofill( uniq_id, '<?php echo esc_js(COOKIEHASH) ?>' );
	
	}

	$('.' + uniq_id + ' .wpp_d1_subscribe' ).click(function(e){
		e.preventDefault();
		
		wpp_handle_form_submit( id, uniq_id, submit_url, rules.cookie_expiration_time );
	});
	
});
</script>

<a class='link_<?php echo $this->id . '-' . $popup_id ?>' href='#<?php echo $this->id . '-' . $popup_id ?>'><?php echo $link_text ?></a>

<!-- This contains the hidden content for popup -->
<div style='display:none'>
	
	<div id='<?php echo $this->id . '-' . $popup_id ?>' style='padding:0px;' class="<?php echo $uniq_id ?> wpp_theme_1 wpp_d1_main">
		<form>
			  <div class="wpp_d1_heading"><?php echo $settings['heading'] ?></div>
			  <div class="wpp_d1_bottom">
			    <table class="wpp_d1_table">
			      <tr>
			        <td><span class="wpp_d1_subheading" ><?php echo $settings['sub_heading'] ?></span></td>
			      </tr>
			      <tr>
			        <td><input type="email" name="email" placeholder="<?php echo $settings['enter_email_text'] ?>" class="wpp_d1_textField" />
			          <div class="wpp_d1_subscribe"><span class="wpp_d1_subscribeNowText" ><?php echo $settings['button_txt'] ?></span></div>
			          <br />
			          <div class="wpp_d1_span_style">
			          <img class="wpp_d1_img_style" src='<?php echo plugins_url( "lockImg.png", __FILE__ ) ?>'/><span class=""><?php echo $settings['privacy_notice'] ?></span></td></div>
			      </tr>
			      
			        <td></td>
			    </table>
			  </div>
				<input type="hidden" name="wpp_email_manager_nonce" value="<?php echo wpp_email_manager_nonce() ?>" />
			</form>
	</div>
</div>

<style>

.cbox_wpp_theme_1 #cboxLoadedContent {
	border: 0;
	background: none;
}

.cbox_wpp_theme_1 #cboxClose {
	top: -19px;
    right: -6px;
}

.cbox_wpp_theme_1 #cboxLoadedContent #wpp_success_message {
	padding: 20px;
}

.wpp_d1_main table {
	border: 0;
	border-collapse: separate;
}

.wpp_d1_main table td{
	border: 0px;
}

.wpp_d1_main table tr {
	border: 0px;
}

.wpp_d1_main img {
	border-radius: 0;
	box-shadow: none;
}


.wpp_d1_main {
	width: 591px;
	height: 326px;
	background-image: url('<?php echo plugins_url( "bg.png", __FILE__ ) ?>'); 
	background-repeat: no-repeat;
}

.wpp_d1_bottom {
	position: absolute;
	margin-top: 150px;
	width: 584px;
	margin-left: 1px;
	height: 186px;
	background-image: url('<?php echo plugins_url( "footerbg.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
}
.wpp_d1_heading {
	position: absolute;
	width: 580px;
	padding-top: 40px;
	padding-left: 20px;
	font-family: Arial;
	font-size: 26px;
	line-height: 1.3;
	height: 50%;
	text-align: left;
	color: #000;
	font-weight: bold;
}
.wpp_d1_table {
	width: 580px;
	height: 186px;
	padding-left: 30px;
	padding-right: 30px;
}
.wpp_d1_textField {
	background-image: url('<?php echo plugins_url( "tf.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 321px;
	height: 47px;
	border: none;
	font-size: 20px;
	padding: 0 !important;
	padding-left: 10px;
	margin-top: -26px;
}
.wpp_d1_subscribe {
	background-image: url('<?php echo plugins_url( "subscribeButtonWT.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 167px;
	height: 47px;
	text-align: center;
	position: absolute;
	float: left;
	margin-top: -48px;
	margin-left: 340px;
	cursor: pointer;
}
.wpp_d1_confidentional {
	margin-top: -24px;
	width: 300px;
	font-size: 10px;
	color: #FFF;
	font-family: Arial;
}
.wpp_d1_subheading {
	color: #FFF;
	font-size: 20px;
	font-family: Arial;
	line-height: 1.3;
	font-weight: normal;
}

.wpp_d1_img_style {
	
}

.wpp_d1_span_style {
	color: #FFF;
	font-family: Arial;
	font-size: 10px;
	margin-top: 15px;
}
.wpp_d1_subscribeNowText {
	width: 167px;
	height: 47px;
	font-family: Myriad Pro, Arial;
	font-size: 21px;
	color: white;
	padding: 0;
	padding-top: 9px;
	display: block;
}
</style>