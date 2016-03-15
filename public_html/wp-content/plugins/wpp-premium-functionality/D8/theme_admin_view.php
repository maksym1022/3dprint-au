<div id="bg_d8">

<div id="heading1_d8"><span contenteditable id="d8-heading"><?php echo $settings['heading'] ?></span></div>
<div id="heading2_d8"><span contenteditable id="d8-sub-heading"><?php echo $settings['sub-heading'] ?></span></div>

<div id="heading3_d8"><span contenteditable id="d8-description"><?php echo $settings['description'] ?></span></div>

<div id="subscribe_d8">
	<p style="margin:0;padding:0;margin-bottom: 10px"><span contenteditable id="span_d8"><?php echo $settings['teaser-text'] ?></span></p>
	<div id="subscribeButton"><span contenteditable id="d8_subscribeNowText"><?php echo $settings['button-text'] ?></span></div>
	<input type="text" name="name" id="d8_nameTf" value="<?php echo $settings['enter-name-text'] ?>" />
	<input type="text" name="email" id="d8_emailTf" value="<?php echo $settings['enter-email-text'] ?>"  />
</div>

<div id="privacy_d8" contenteditable><?php echo $settings['privacy-text'] ?></div>

</div>

<input type="hidden" name="d8_is_theme" value="yes" />

<input type="hidden" name="d8-heading" value="<?php echo $settings['heading'] ?>" />
<input type="hidden" name="d8-sub-heading" value="<?php echo $settings['sub-heading'] ?>" />
<input type="hidden" name="d8-description" value="<?php echo $settings['description'] ?>" />
<input type="hidden" name="d8-teaser-text" value="<?php echo $settings['teaser-text'] ?>" />
<input type="hidden" name="d8-enter-name-text" value="<?php echo $settings['enter-name-text'] ?>" />
<input type="hidden" name="d8-enter-email-text" value="<?php echo $settings['enter-email-text'] ?>" />
<input type="hidden" name="d8-button-text" value="<?php echo $settings['button-text'] ?>" />
<input type="hidden" name="d8-privacy-text" value="<?php echo $settings['privacy-text'] ?>" />

<script>

jQuery(function ($) {

	$( '#d8-heading' ).blur(function(e){
		$( 'input[name=d8-heading]' ).val( $(this).text() );
	});

	$( '#d8-sub-heading' ).blur(function(e){
		$( 'input[name=d8-sub-heading]' ).val( $(this).text() );
	});

	$( '#d8-description' ).blur(function(e){
		$( 'input[name=d8-description]' ).val( $(this).text() );
	});

	$( '#span_d8' ).blur(function(e){
		$( 'input[name=d8-teaser-text]' ).val( $(this).text() );
	});

	$( '#d8_subscribeNowText' ).blur(function(e){
		$( 'input[name=d8-button-text]' ).val( $(this).text() );
	});

	$( '#d8_nameTf' ).blur(function(e){
		$( 'input[name=d8-enter-name-text]' ).val( $(this).val() );
	});

	$( '#d8_emailTf' ).blur(function(e){
		$( 'input[name=d8-enter-email-text]' ).val( $(this).val() );
	});

	$( '#privacy_d8' ).blur(function(e){
		$( 'input[name=d8-privacy-text]' ).val( $(this).text() );
	});
	
});

</script>

<style>

#bg_d8 {
	background-image: url('<?php echo plugins_url( "images/bg_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 600px;
	height: 360px;
	margin: auto;
	margin-top: 20px;
	margin-bottom: 20px;
}
#heading1_d8 {
	width: 600px;
	height: 70px;
	text-align: center;
	font-family: MyFont;
	font-size: 30px;
	padding-top: 20px;
	color: #207886;
}
#heading2_d8 {
	width: 600px;
	height: 70px;
	text-align: center;
	font-family: MyFont;
	font-size: 30px;
	padding-top: 10px;
	color: #126572;
}
#heading3_d8 {
	width: 600px;
	height: 62px;
	margin: 0;
	padding: 0;
	text-align: left;
	font-family: MyFont;
	font-size: 18px;
	color: #126572;
	margin-left: 20px;
	max-width: 590px;
	line-height: 1.2;
	
}
#subscribe_d8 {
	font-family: MyFont;
	padding-left: 20px;
	padding-right: 20px;
	font-size: 25px;
	color: #126572;
}
#d8_emailTf {
	background-color: transparent;
	background-image: url('<?php echo plugins_url( "images/email_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 199px;
	height: 36px;
	border: none;
	padding-left: 30px;
	padding-right: 10px;
	margin-top: 10px;
	font-size: 14px;
}
#d8_nameTf {
	background-color: transparent;
	background-image: url('<?php echo plugins_url( "images/name_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 199px;
	height: 36px;
	border: none;
	padding-left: 30px;
	font-size: 14px;
}
#subscribeButton {
	background-image: url('<?php echo plugins_url( "images/button_d8.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 145px;
	height: 36px;
	text-align: center;
	color: #0e323d;
	clear: both;
	float: right;
	margin-top: 10px;
	padding-top: 1px;
}
#d8_subscribeNowText {
	font-size: 20px;
	display: block;
	cursor: pointer;
	height: 35px;
	line-height: 35px;
}
#privacy_d8 {
	background-image: url('<?php echo plugins_url( "images/lock.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	text-align: left;
	margin-left: 20px;
	margin-top: 10px;
	height: 30px;
	padding-top: 20px;
	padding-left: 20px;
	background-position: 5px;
}

</style>