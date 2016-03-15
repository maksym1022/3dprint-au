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
			className: 'cbox_wpp_theme_2',
			overlayClose: false,
			escKey: false,
			transition: options.transition,

			onOpen: function() {
				$(".colorbox").css("opacity", 0);
			},

			onComplete: function() {
				$('.cbox_wpp_theme_2.cboxOverlay').css( 'background', options.mask_color );
				$(".colorbox").css("opacity", 1);
			},

			onClosed: function() {

				if ( rules.use_cookies )
					wpp_place_popup_close_cookie( id, rules.cookie_expiration_time );
			}
		});

		$('#cboxOverlay.cbox_wpp_theme_2').css( 'background', options.mask_color );

		$('.cbox_wpp_theme_1 .cboxLoadedContent').css( 'border-color', options.border_color );
	
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
	 
	$('.' + uniq_id + ' .wpp_d2_button_div' ).click(function(e){
		e.preventDefault();

		wpp_handle_form_submit( id, uniq_id, submit_url, rules.cookie_expiration_time );
	});

});
</script>

<!-- This contains the hidden content for popup -->
<div style='display:none'>
	
<div id='<?php echo $this->id . '-auto_popup-' . $popup_id ?>' style='padding:0px;' class="<?php echo $uniq_id ?> wpp_theme_2 wpp_d2_main">
  <form>
  <div class="wpp_d2_left">
    <table class="wpp_d2_tableLeft" border="0">
      <tr>
        <td><span class="wpp_d2_limeColor1"><?php echo $settings['heading'] ?></span></td>
      </tr>
      <tr>
        <td class="wpp_d2_limeColor"><span><?php echo $settings['sub-heading'] ?></span></td>
      </tr>
      <tr>
        <td class="wpp_d2_padding"><span class="wpp_d2_desc"><?php echo $settings['description'] ?></span></td>
      </tr>
      <tr>
        <td><table class="wpp_d2_innerTable" border="0">
            <tr>
              <td class="wpp_d2_center" rowspan="4"><img class="wpp_d2_left-column-image" src="<?php echo $settings['left-column-image'] ?>" /><br /></td>
              <td><table class="wpp_d2_pointsTable">
                  <tr>
                    <td><img class="wpp_d2_float"  src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span class="wpp_d2_points"><?php echo $settings['list-items'][0] ?></span></td>
                  </tr>
                  <tr>
                    <td><img class="wpp_d2_float" src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span class="wpp_d2_points"><?php echo $settings['list-items'][1] ?></span></td>
                  </tr>
                  <tr>
                    <td><img class="wpp_d2_float" src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span class="wpp_d2_points"><?php echo $settings['list-items'][2] ?></span></td>
                  </tr>
                  <tr>
                    <td><img class="wpp_d2_float" src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span class="wpp_d2_points"><?php echo $settings['list-items'][3] ?></span></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </div>
  <div class="wpp_d2_right">
    <table class="wpp_d2_table" border="0">
      <tr>
        <td><img class="wpp_d2_right-column-image" src="<?php echo $settings['right-column-image'] ?>" /></td>
      </tr>
      <tr>
        <td><input type="text" class="wpp_d2_name" name="name" style="background-color:transparent;" placeholder="<?php echo $settings['enter-name-text'] ?>" /></td>
      </tr>
      <tr>
        <td><input type="text" class="wpp_d2_email" name="email" style="background-color:transparent;" placeholder="<?php echo $settings['enter-email-text'] ?>" /></td>
      </tr>
      <tr>
        <td><div class="wpp_d2_button_div"><img class="wpp_d2_button" src="<?php echo plugins_url( "images/subscribeButtonwt.png", __FILE__ ) ?>" /><span class="wpp_d2_subscribeNowText"><?php echo $settings['button-text'] ?></span></div></td>
      </tr>
    </table>
    <div class="wpp_d2_oth">
      <div class="wpp_d2_auth"><?php echo $settings['privacy-text'] ?></div>
    </div>

	</div>
	<input type="hidden" name="wpp_email_manager_nonce" value="<?php echo wpp_email_manager_nonce() ?>" />
</form>
</div>
</div>

<style>

.cbox_wpp_theme_2 #cboxLoadedContent {
	border: 0;
	background: none;
	overflow: hidden !important;
}

.cbox_wpp_theme_2 #cboxClose {
	position: absolute;
	top: -3px;
    right: 3px;
}

.cbox_wpp_theme_2 #cboxLoadedContent #wpp_success_message {
	padding: 20px;
}

.wpp_d2_main {
	width:774px;
	height:377px;
	background-image: url('<?php echo plugins_url( "images/bg.png", __FILE__ ) ?>');
	background-repeat:no-repeat
}

.wpp_d2_main * {
	font-family: Perpetua, Baskerville, "Big Caslon", "Palatino Linotype", Palatino, "URW Palladio L", "Nimbus Roman No9 L", serif !important;
}

.wpp_d2_main img{
	border-radius: 0 !important;
	box-shadow: none !important;
	padding: 0;
	margin: 0;
}

.wpp_d2_main table {
	border: 0 !important;
	margin: 0 0 20px;
	line-height: 2;
	border-spacing: 0;
	font-size: 14px;
	margin-bottom: 0;
}

.wpp_d2_main table tr td {
	padding: 3px 10px 6px 0;
}



.wpp_d2_right {
	float:right;
	margin-top:14px;
	margin-right:14px;
	width:283px;
	height:349px;
	background-image: url('<?php echo plugins_url( "images/rightBg.png", __FILE__ ) ?>');
	background-repeat:no-repeat
}


.wpp_d2_right .wpp_d2_table {
	margin-top: 20px;
}

.wpp_d2_right .wpp_d2_table tr td{
	padding: 0;
	padding-top: 5px;
}


.wpp_d2_table {
	margin-top:30px;
	margin-top:0;
	width:100%;
	text-align:center;
}

.wpp_d2_table tr td {
	border:none;
	text-align:center
}

.wpp_d2_table tr td input {
	border:none
}

.wpp_d2_table tr td img {
	margin: 5px
}


.wpp_d2_name {
	padding: 0 !important;
	margin: 0 !important;
	padding-left:35px !important;
	width: 100%;
	height:38px !important;
	margin-left: 13px !important;
	border:none;
	background: none !important;
	background-image: url('<?php echo plugins_url( "images/tfwn.png", __FILE__ ) ?>') !important; 
	background-repeat:no-repeat !important;
}

.wpp_d2_name:focus, .wpp_d2_name:hover, 
.wpp_d2_email:focus, .wpp_d2_email:hover {
	outline:0px !important;
    -webkit-appearance:none;
}

.wpp_d2_email {
	padding: 0 !important;
	margin: 0 !important;
	padding-left:35px !important;
	width: 100%;
	height:38px !important;
	margin-left: 13px !important;
	border:none;
	background: none !important;
	background-image: url('<?php echo plugins_url( "images/tfwe.png", __FILE__ ) ?>') !important; 
	background-repeat:no-repeat !important;
}

.wpp_d2_subscribeButton {
	width:205px;
	height:39px;
	background-image: url('<?php echo plugins_url( "images/subscribeButtonwt.png", __FILE__ ) ?>');
	background-repeat:no-repeat
}

.wpp_d2_auth {
	padding-left: 20px;
	background-position: 5px;
	background-image: url('<?php echo plugins_url( "images/lockImg.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	color:#fff;
	font-size:11px;
}

.wpp_d2_oth {
	margin: 0;
	margin-top: 20px;
	margin-left:20px
}

.wpp_d2_left {
	float:left;
	margin-top:14px;
	margin-left:13px;
	width:462px;
	height:349px
}

.wpp_d2_tableLeft {
	margin-top:20px;
	width:100%;
	text-align:center
}

.wpp_d2_tableLeft tr td {
	margin-top:0;
	margin-bottom:0;
	padding-top:0;
	padding-bottom:0;
	border:none;
	text-align:center
}

.wpp_d2_leftBar {
	width:100px;
	text-align:center
}

.wpp_d2_innerTable {
	margin-top:30px;
	width:100%;
	text-align:left
}

.wpp_d2_innerTable tr td {
	vertical-align:top;
	text-align: left;
}


.wpp_d2_float {
	float:left;
	margin-right:7px;
}

.wpp_d2_points {
	margin-top:0;
	margin-bottom:0;
	margin-left:10px;
	color:#666;
	font-weight:400;
}

.wpp_d2_center {
	text-align:center ! important;
}

.wpp_d2_pointsTable tr td{
	padding: 0 !important;
	margin: 0 !important;
	padding-top: 2px !important;
}

.wpp_d2_padding {
	padding-right:10px;
	padding-left:10px
}

.wpp_d2_limeColor1 {
	margin-top:0;
	margin-bottom:0;
	color:#99b927;
	font-weight:400;
	font-size:35px;
	font-weight: bold;
}

.wpp_d2_limeColor {
	padding: 0 !important;
}

.wpp_d2_limeColor span{
	margin-top:0;
	margin-bottom:0;
	color:#99b927;
	font-weight:400;
	font-size:20px;
}


.wpp_d2_point {
	margin-top:0;
	margin-bottom:0;
	color:#666;
	font-weight:400;
	cursor:pointer;
}

.wpp_d2_subscribeNowText {
	position:absolute;
	width:203px;
	height:37px;
	color:#fff;
	padding: 0;
	margin: 0;
	margin-left: -208px;
	margin-top: 8px;
	font-weight: bold;
	font-size: 16px;
	font-family: Arial !important;
	cursor: pointer;
}

.wpp_d2_desc {
	margin-top:0;
	margin-bottom:0;
	color:#666;
	font-weight:400;
}

.wpp_d2_left-column-image {
	width: 128px !important;
	height: 126px !important;
}

.wpp_d2_right-column-image {
	width: 236px !important;
	height: 103px !important;
}

</style>