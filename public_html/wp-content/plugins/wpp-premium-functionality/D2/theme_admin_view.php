<div id="wpp_d2_main">
  <div id="wpp_d2_left">
    <table id="wpp_d2_tableLeft" border="0">
      <tr>
        <td><span id="wpp_d2_limeColor1" contenteditable><?php echo $settings['heading'] ?></span></td>
      </tr>
      <tr>
        <td id="wpp_d2_limeColor"><span contenteditable id="wpp_d2_sub_heading" ><?php echo $settings['sub-heading'] ?></span></td>
      </tr>
      <tr>
        <td id="wpp_d2_padding"><span contenteditable id="wpp_d2_desc"><?php echo $settings['description'] ?></span></td>
      </tr>
      <tr>
        <td><table id="wpp_d2_innerTable" border="0">
            <tr>
              <td id="wpp_d2_center" rowspan="4"><img id="left-column-image" src="<?php echo $settings['left-column-image'] ?>" /><br /></td>
              <td><table class="wpp_d2_pointsTable">
                  <tr>
                    <td><img class="wpp_d2_float" src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span contenteditable id="wpp_d2_list_item_1" class="wpp_d2_points"><?php echo $settings['list-items'][0] ?></span></td>
                  </tr>
                  <tr>
                    <td><img class="wpp_d2_float" src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span contenteditable id="wpp_d2_list_item_2" class="wpp_d2_points"><?php echo $settings['list-items'][1] ?></span></td>
                  </tr>
                  <tr>
                    <td><img class="wpp_d2_float" src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span contenteditable id="wpp_d2_list_item_3" class="wpp_d2_points"><?php echo $settings['list-items'][2] ?></span></td>
                  </tr>
                  <tr>
                    <td><img class="wpp_d2_float" src="<?php echo plugins_url( "images/tick.png", __FILE__ ) ?>" /> <span contenteditable id="wpp_d2_list_item_4" class="wpp_d2_points"><?php echo $settings['list-items'][3] ?></span></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </div>
  <div id="wpp_d2_right">
    <table id="wpp_d2_table" border="0">
      <tr>
        <td><img id="right-column-image" src="<?php echo $settings['right-column-image'] ?>" /></td>
      </tr>
      <tr>
        <td><input type="text" id="wpp_d2_name" name="name" style="background-color:transparent;" value="<?php echo $settings['enter-name-text'] ?>"/></td>
      </tr>
      <tr>
        <td><input type="text" id="wpp_d2_email" name="email" style="background-color:transparent;" value="<?php echo $settings['enter-email-text'] ?>" /></td>
      </tr>
      <tr>
        <td><div><img id="wpp_d2_button" src="<?php echo plugins_url( "images/subscribeButtonwt.png", __FILE__ ) ?>" /><span id="wpp_d2_subscribeNowText" contenteditable><?php echo $settings['button-text'] ?></span></div></td>
      </tr>
    </table>
    <div id="wpp_d2_oth">
      <div id="wpp_d2_auth" contenteditable><?php echo $settings['privacy-text'] ?></div>
    </div>
  </div>
</div>
<input type="hidden" name="d2_is_theme" value="yes" />
<input type="hidden" name="d2-heading" value="<?php echo $settings['heading'] ?>" />
<input type="hidden" name="d2-sub-heading" value="<?php echo $settings['sub-heading'] ?>" />
<input type="hidden" name="d2-description" value="<?php echo $settings['description'] ?>" />
<input type="hidden" name="d2-left-column-image" value="<?php echo $settings['left-column-image'] ?>" />
<input type="hidden" name="d2-right-column-image" value="<?php echo $settings['right-column-image'] ?>" />
<input type="hidden" name="d2-enter-name-text" value="<?php echo $settings['enter-name-text'] ?>" />
<input type="hidden" name="d2-enter-email-text" value="<?php echo $settings['enter-email-text'] ?>" />
<input type="hidden" name="d2-button-text" value="<?php echo $settings['button-text'] ?>" />
<input type="hidden" name="d2-privacy-text" value="<?php echo $settings['privacy-text'] ?>" />
<input type="hidden" name="d2-list-item-1" value="<?php echo $settings['list-items'][0] ?>" />
<input type="hidden" name="d2-list-item-2" value="<?php echo $settings['list-items'][1] ?>" />
<input type="hidden" name="d2-list-item-3" value="<?php echo $settings['list-items'][2] ?>" />
<input type="hidden" name="d2-list-item-4" value="<?php echo $settings['list-items'][3] ?>" />

<script>

jQuery(function ($) {

	$( '#wpp_d2_limeColor1' ).blur(function(e){
		$( 'input[name=d2-heading]' ).val( $(this).text() );
	});
	$( '#wpp_d2_sub_heading' ).blur(function(e){
		$( 'input[name=d2-sub-heading]' ).val( $(this).text() );
	});
	$( '#wpp_d2_desc' ).blur(function(e){
		$( 'input[name=d2-description]' ).val( $(this).text() );
	});
	$( '#wpp_d2_list_item_1' ).blur(function(e){
		$( 'input[name=d2-list-item-1]' ).val( $(this).text() );
	});
	$( '#wpp_d2_list_item_2' ).blur(function(e){
		$( 'input[name=d2-list-item-2]' ).val( $(this).text() );
	});
	$( '#wpp_d2_list_item_3' ).blur(function(e){
		$( 'input[name=d2-list-item-3]' ).val( $(this).text() );
	});
	$( '#wpp_d2_list_item_4' ).blur(function(e){
		$( 'input[name=d2-list-item-4]' ).val( $(this).text() );
	});
	$( '#wpp_d2_name' ).blur(function(e){
		$( 'input[name=d2-enter-name-text]' ).val( $(this).val() );
	});
	$( '#wpp_d2_email' ).blur(function(e){
		$( 'input[name=d2-enter-email-text]' ).val( $(this).val() );
	});
	$( '#wpp_d2_subscribeNowText' ).blur(function(e){
		$( 'input[name=d2-button-text]' ).val( $(this).text() );
	});
	$( '#wpp_d2_auth' ).blur(function(e){
		$( 'input[name=d2-privacy-text]' ).val( $(this).text() );
	});

	$('#left-column-image').click(function(e) {
		e.preventDefault();

		var src = prompt( "Enter the valid url of the image in the textbox" );
		
		if ( ! src )
			return false;

		$(this).attr( 'src', src );

		$( 'input[name=d2-left-column-image]' ).val( $(this).attr('src') );

	});

	$('#right-column-image').click(function(e) {
		e.preventDefault();

		var src = prompt( "Enter the valid url of the image in the textbox" );

		if ( ! src )
			return false;

		$(this).attr( 'src', src );

		$( 'input[name=d2-right-column-image]' ).val( $(this).attr('src') );

	});

});

</script>

<style>
#wpp_admin_theme_cont {
	/*overflow-x: scroll;*/
}
#wpp_d2_main {
	width:774px;
	height:377px;
	background-image: url('<?php echo plugins_url( "images/bg.png", __FILE__ ) ?>');
	background-repeat:no-repeat
}

#wpp_d2_main * {
	font-family: Perpetua, Baskerville, "Big Caslon", "Palatino Linotype", Palatino, "URW Palladio L", "Nimbus Roman No9 L", serif !important;
}

#wpp_d2_main img{
	border-radius: 0 !important;
	box-shadow: none !important;
	padding: 0;
	margin: 0;
}

#wpp_d2_main table {
	border: 0 !important;
	margin: 0 0 20px;
	line-height: 2;
	border-spacing: 0;
	font-size: 14px;
	margin-bottom: 0;
}

#wpp_d2_main table tr td {
	padding: 3px 10px 6px 0;
}



#wpp_d2_right {
	float:right;
	margin-top:14px;
	margin-right:14px;
	width:283px;
	height:349px;
	background-image: url('<?php echo plugins_url( "images/rightBg.png", __FILE__ ) ?>');
	background-repeat:no-repeat
}


#wpp_d2_right #wpp_d2_table {
	margin-top: 20px;
}

#wpp_d2_right #wpp_d2_table tr td{
	padding: 0;
	padding-top: 5px;
}


#wpp_d2_table {
	margin-top:30px;
	margin-top:0;
	width:100%;
	text-align:center;
}

#wpp_d2_table tr td {
	border:none;
	text-align:center
}

#wpp_d2_table tr td input {
	border:none
}

#wpp_d2_table tr td img {
	margin: 5px
}


#wpp_d2_name {
	padding: 0 !important;
	margin: 0 !important;
	padding-left:35px !important;
	width: 100%;
	height:38px;
	margin-left: 13px !important;
	border:none;
	background: none !important;
	background-image: url('<?php echo plugins_url( "images/tfwn.png", __FILE__ ) ?>') !important; 
	background-repeat:no-repeat !important;
}

#wpp_d2_email {
	padding: 0 !important;
	margin: 0 !important;
	padding-left:35px !important;
	width: 100%;
	height:38px;
	margin-left: 13px !important;
	border:none;
	background: none !important;
	background-image: url('<?php echo plugins_url( "images/tfwe.png", __FILE__ ) ?>') !important; 
	background-repeat:no-repeat !important;
}

#wpp_d2_subscribeButton {
	width:205px;
	height:39px;
	background-image: url('<?php echo plugins_url( "images/subscribeButtonwt.png", __FILE__ ) ?>');
	background-repeat:no-repeat
}

#wpp_d2_auth {
	padding-left: 20px;
	background-position: 5px;
	background-image: url('<?php echo plugins_url( "images/lockImg.png", __FILE__ ) ?>');
	background-repeat: no-repeat;
	color:#fff;
	font-size:11px;
}

#wpp_d2_oth {
	margin: 0;
	margin-top: 20px;
	margin-left:20px
}

#wpp_d2_left {
	float:left;
	margin-top:14px;
	margin-left:13px;
	width:462px;
	height:349px
}

#wpp_d2_tableLeft {
	margin-top:20px;
	width:100%;
	text-align:center
}

#wpp_d2_tableLeft tr td {
	margin-top:0;
	margin-bottom:0;
	padding-top:0;
	padding-bottom:0;
	border:none;
	text-align:center
}

#wpp_d2_leftBar {
	width:100px;
	text-align:center
}

#wpp_d2_innerTable {
	margin-top:30px;
	width:100%;
	text-align:left
}

#wpp_d2_innerTable tr td {
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

#wpp_d2_center {
	text-align:center ! important;
}

.wpp_d2_pointsTable tr td{
	padding: 0 !important;
	margin: 0 !important;
	padding-top: 2px !important;
}

#wpp_d2_padding {
	padding-right:10px;
	padding-left:10px
}

#wpp_d2_limeColor1 {
	margin-top:0;
	margin-bottom:0;
	color:#99b927;
	font-weight:400;
	font-size:35px;
	font-weight: bold;
	
}

#wpp_d2_limeColor {
	padding: 0 !important;
}

#wpp_d2_limeColor span{
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

#wpp_d2_subscribeNowText {
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

#wpp_d2_desc {
	margin-top:0;
	margin-bottom:0;
	color:#666;
	font-weight:400;
	
}

#left-column-image {
	width: 128px !important;
	height: 126px !important;
	cursor: pointer;
}

#right-column-image {
	width: 236px !important;
	height: 103px !important;
	cursor: pointer;
}

</style>