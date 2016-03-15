<style>
#wpp_d1_main {
	width: 591px;
	height: 326px;
	background-image: url('<?php echo plugins_url( "bg.png", __FILE__ ) ?>'); 
	background-repeat: no-repeat;
	margin: auto;
	margin-top: 20px;
	margin-bottom: 20px;
}

#wpp_d1_bottom {
	position: absolute;
	margin-top: 150px;
	width: 584px;
	margin-left: 1px;
	height: 186px;
	background-image: url('<?php echo plugins_url( "footerbg.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
}
#wpp_d1_heading {
	position: absolute;
	width: 580px;
	padding-top: 40px;
	padding-left: 20px;
	font-family: Arial;
	font-size: 28px;
	line-height: 1;
	height: 50%;
	text-align: left;
}
#wpp_d1_table {
	width: 580px;
	height: 186px;
	padding-left: 30px;
	padding-right: 30px;
}
#wpp_d1_textField {
	background-image: url('<?php echo plugins_url( "tf.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 321px;
	height: 47px;
	border: none;
	font-size: 20px;
	padding-left: 10px;
	margin-top: -26px;
}
#wpp_d1_subscribe {
	background-image: url('<?php echo plugins_url( "subscribeButtonWT.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	width: 167px;
	height: 47px;
	text-align: center;
	position: absolute;
	float: left;
	margin-top: -48px;
	margin-left: 340px
}
#wpp_d1_confidentional {
	margin-top: -24px;
	width: 300px;
	font-size: 10px;
	color: #FFF;
	font-family: Arial;
}
#wpp_d1_subheading {
	margin-bottom: 0px;
	color: #FFF;
	font-size: 20px;
	font-family: Arial;
	line-height: 1;
}
#wpp_d1_info {
	margin-top: -10px;
}
#wpp_d1_img_style {
	margin-top: 15px;
}
#wpp_d1_span_style {
	color: #FFF;
	font-family: Arial;
	font-size: 10px;
	margin-top: -10px;
}
#wpp_d1_subscribeNowText {
	width: 167px;
	height: 47px;
	font-family: Myriad Pro;
	font-size: 21px;
	color: white;
	padding-top: 9px;
	display: block;
}
</style>

<div id="wpp_d1_main">
  <div id="wpp_d1_heading"><span contenteditable id="wpp_d1_heading_edit"><?php echo $settings['heading'] ?></span></div>
  <div id="wpp_d1_bottom">
    <table id="wpp_d1_table">
      <tr>
        <td><span id="wpp_d1_subheading" contenteditable><?php echo $settings['sub_heading'] ?></span></td>
      </tr>
      <tr>
        <td><input type="text" name="d1_enter_email_text" value="<?php echo $settings['enter_email_text'] ?>" id="wpp_d1_textField" />
          <div id="wpp_d1_subscribe"><span id="wpp_d1_subscribeNowText" contenteditable><?php echo $settings['button_txt'] ?></span></div>
          <br />
          <img id="wpp_d1_img_style" src='<?php echo plugins_url( "lockImg.png", __FILE__ ) ?>'/><span id="wpp_d1_span_style" contenteditable><?php echo $settings['privacy_notice'] ?></span></td>
      </tr>
      
        <td ></td>
    </table>
  </div>
</div>

<input type="hidden" name="d1_heading" value="<?php echo $settings['heading'] ?>" />
<input type="hidden" name="d1_sub_heading" value="<?php echo $settings['sub_heading'] ?>" />
<input type="hidden" name="d1_button_txt" value="<?php echo $settings['button_txt'] ?>" />
<input type="hidden" name="d1_privacy_notice" value="<?php echo $settings['privacy_notice'] ?>" />

<input type="hidden" name="d1_is_theme" value="yes" />
<script>
jQuery(function ($) {

	$( '#wpp_d1_heading_edit' ).blur(function(e){
		$( 'input[name=d1_heading]' ).val( $(this).text() );
	});

	$( '#wpp_d1_subheading' ).blur(function(e){
		$( 'input[name=d1_sub_heading]' ).val( $(this).text() );
	});

	$( '#wpp_d1_subscribeNowText' ).blur(function(e){
		$( 'input[name=d1_button_txt]' ).val( $(this).text() );
	});

	$( '#wpp_d1_span_style' ).blur(function(e){
		$( 'input[name=d1_privacy_notice]' ).val( $(this).text() );
	});

});
</script>