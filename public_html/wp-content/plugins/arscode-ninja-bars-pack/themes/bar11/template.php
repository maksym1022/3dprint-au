<div class="snp-fb snp-bar11 <?php echo $POPUP_META['snp_position'].' '.$POPUP_META['snp_open_effect']; ?>">
    <div class="snp-top">
	<div class="snp-container">
	    <?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<h3>'.$POPUP_META['snp_header'].'</h3>'; 
	    }
	    ?> 
	    <div class="snp-line">
		<span>&</span>
	    </div>
	    <?php
	    if(!empty($POPUP_META['snp_subheader']))
	    {
		echo '<p>'.$POPUP_META['snp_subheader'].'</p>'; 
	    }
	    ?> 
	    <?php
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {  
		echo '<div class="snp-close snp-close-link"></div>';
	    }
	    ?>
	</div>
    </div>
    <form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-form snp-clearfix snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
	<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
	<div class="snp-container">
	    <?php
	    if(!$POPUP_META['snp_name_disable'])
	    {
		echo '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp_name" placeholder="'.$POPUP_META['snp_name_placeholder'].'" class="snp-field-name" />';
	    }
	    ?>
	    <input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field-email" />
	    <input class="snp-nomw" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" type="submit" value="<?php echo $POPUP_META['snp_submit_button'];?>">
	    <?php
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {  
		echo '<div class="snp-close snp-close-link"></div>';
	    }
	    ?>
	</div>
    </form>
</div>
<script>
var snp_bar11_open = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar11').not('.snp-pos-static').addClass('snp-showme');
}
var snp_bar11_close = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar11').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar11').removeClass('snp-showme').show(); });
}
</script>
<?php

if(isset($POPUP_META['snp_header_font']))
{
	$POPUP_META['snp_header_font']=unserialize($POPUP_META['snp_header_font']);
}
if(isset($POPUP_META['snp_subheader_font']))
{
	$POPUP_META['snp_subheader_font']=unserialize($POPUP_META['snp_subheader_font']);
}
if(isset($POPUP_META['snp_submit_button_color']))
{
	$POPUP_META['snp_submit_button_color']=unserialize($POPUP_META['snp_submit_button_color']);
}
echo '<style>';
if (!empty($POPUP_META['snp_bg_color1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top { background-color: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="text"] { background-color: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top .snp-line span { background-color: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"] { color: '.$POPUP_META['snp_bg_color1'].';}'."\n";	
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top:before { border-color: transparent transparent '.$POPUP_META['snp_bg_color1'].' transparent;}'."\n";	
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="text"] { border-bottom:1px solid '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color2']))
{
	echo '.snp-pop-'.$ID.' .snp-bar11 form { background-color: '.$POPUP_META['snp_bg_color2'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar11 form:before { border-top: 30px solid '.$POPUP_META['snp_bg_color2'].';}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top h3 {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top .snp-line { background-color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top .snp-line span { color: '.$POPUP_META['snp_header_font']['color'].'; }'."\n";
}
 if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top h3 {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_subheader_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top p {font-size: '.$POPUP_META['snp_subheader_font']['size'].'px; color: '.$POPUP_META['snp_subheader_font']['color'].';}'."\n";
}
 if (!empty($POPUP_META['snp_subheader_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar11 .snp-top p {font-family: "'.$POPUP_META['snp_subheader_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']['from']))
{
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"] {background-color: '.$POPUP_META['snp_submit_button_color']['from'].';}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"] {background-image:-webkit-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"] {background-image:-moz-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"] {background-image:-o-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"] {background-image:-ms-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"] {background-image:linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"]:hover {background-color: '.$POPUP_META['snp_submit_button_color']['to'].';}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"]:hover {background-image:-webkit-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"]:hover {background-image:-moz-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"]:hover {background-image:-o-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"]:hover {background-image:-ms-linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}';
	echo '.snp-pop-'.$ID.' .snp-bar11 form input[type="submit"]:hover {background-image:linear-gradient(top, '.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}';
	
}
echo '</style>';