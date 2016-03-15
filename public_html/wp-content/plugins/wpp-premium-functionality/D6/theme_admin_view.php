<div id="wpp_d6_bg">

  <div id="wpp_d6_box_code">
  	<?php echo $settings['box-code'] ?>
  </div>
  <a href="#TB_inline?height=350&amp;width=450&amp;inlineId=wpp_d6_dialog_edit_box_code" id="wpp_d6_edit_box_code" class="thickbox">Edit Box Code</a>
  <div id="wpp_d6_banner"><div id="wpp_d6_banner_text" contenteditable><?php echo $settings['heading'] ?></div></div>
  <div>
    <input id="wpp_d6_name" value="<?php echo $settings['enter-name-text'] ?>" type="text" name="name" />
    <br />
    <input id="wpp_d6_email" value="<?php echo $settings['enter-email-text'] ?>" type="text" name="email" />
    <div id="wpp_d6_btn_cont">
    <span id="wpp_d6_subscribe_button" contenteditable><?php echo $settings['button-text'] ?></span>
	</div>
  </div>
  <div id="wpp_d6_oth" contenteditable>
  <?php echo $settings['privacy-text'] ?>
  </div>
</div>

<input type="hidden" name="d6_is_theme" value="yes" />

<input type="hidden" name="d6-heading" value="<?php echo $settings['heading'] ?>"/>
<textarea style="display: none" name="d6-box-code"><?php echo $settings['box-code'] ?></textarea>
<input type="hidden" name="d6-enter-name-text" value="<?php echo $settings['enter-name-text'] ?>" />
<input type="hidden" name="d6-enter-email-text" value="<?php echo $settings['enter-email-text'] ?>" />
<input type="hidden" name="d6-button-text" value="<?php echo $settings['button-text'] ?>" />
<input type="hidden" name="d6-privacy-text" value="<?php echo $settings['privacy-text'] ?>" />

<div id="wpp_d6_dialog_edit_box_code" style="display: none">
<textarea id="wpp_d6_dialog_edit_box_code_textarea">
<?php echo $settings['box-code'] ?>
</textarea>
<button id="wpp_d6_edit_dialog_save_btn">Save Code</button>
</div>

<script>

jQuery(function ($) {

	$( '#wpp_d6_banner_text' ).blur(function(e){
		$( 'input[name=d6-heading]' ).val( $(this).text() );
	});

	$( '#wpp_d6_edit_dialog_save_btn' ).click(function(e){

		var code = $('#wpp_d6_dialog_edit_box_code_textarea').val();
		
		$( '#wpp_d6_box_code' ).html(code);

		$( 'textarea[name=d6-box-code]' ).val( code );

	});

	$( '#wpp_d6_subscribe_button' ).blur(function(e){
		$( 'input[name=d6-button-text]' ).val( $(this).text() );
	});

	$( '#wpp_d6_name' ).blur(function(e){
		$( 'input[name=d6-enter-name-text]' ).val( $(this).val() );
	});

	$( '#wpp_d6_email' ).blur(function(e){
		$( 'input[name=d6-enter-email-text]' ).val( $(this).val() );
	});

	$( '#wpp_d6_oth' ).blur(function(e){
		$( 'input[name=d6-privacy-text]' ).val( $(this).text() );
	});
	
});

</script>
<style>
#wpp_d6_bg {
	background-image: url('<?php echo plugins_url( "images/bg_d6.png", __FILE__ ) ?>');
	width: 395px;
	height: 516px;
	background-repeat: no-repeat;
	margin: auto;
	margin-top: 5px;
	margin-bottom: 5px;
}
#wpp_d6_box_code {
	margin: 0;
	padding: 0;
	display: inline-block;
	width: 320px;
	height: 240px;
	margin-top: 25px;
	margin-left: 40px;
}

#wpp_d6_box_code video {
	background-color: #000;
}

#wpp_d6_banner {
	background-color: #232323;
	width: 395px;
	height: 53px;
	margin-left: 0px;
	/*margin-top: -46px;*/
}

#wpp_d6_banner_text {
	text-align: center;
	font-size: 34px;
	height: 53px;
	line-height: 53px;
	color: #afafaf;
	letter-spacing: 1px;
}

#wpp_d6_name {
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
#wpp_d6_email {
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
#wpp_d6_lock{
	margin-left: 81px;
	margin-top: 5px;
	position: absolute;
}
	
#wpp_d6_oth{
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
}

#wpp_d6_btn_cont {
	margin: 0;
	padding: 0;
	text-align: center;
	margin-top: 30px;
}
#wpp_d6_subscribe_button {
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

#wpp_d6_edit_box_code {
	font-weight: bold;
	position: absolute;
	top: 20px;
	margin-left: 40px;
}
#wpp_d6_dialog_edit_box_code {
	width: 450px;
	height: 350px;
}
#wpp_d6_dialog_edit_box_code_textarea {
	width: 450px;
    height: 320px;
    font-family: monospace;
    font-size: 14px;
}


</style>
