<div class="snp-fb snp-bar4 <?php echo $POPUP_META['snp_position'].' '.$POPUP_META['snp_open_effect']; ?>">
    <div class="snp-container">
	<div class="snp-top">
	    <div class="snp-image">
		<?php
		if(!empty($POPUP_META['snp_img']))
		{
		    echo '<img src="'.$POPUP_META['snp_img'].'" alt="" />'; 
		}
		?> 
	    </div>
	    <div class="snp-main">
		<?php
		if(!empty($POPUP_META['snp_maintext']))
		{
		    echo '<p>'.$POPUP_META['snp_maintext'].'</p>'; 
		}
		?> 
		<form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-form snp-clearfix snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
		    <?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
		    <?php
		    if(!$POPUP_META['snp_name_disable'])
		    {
			echo '<div class="snp-field snp-name">';
			echo '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp_name" placeholder="'.$POPUP_META['snp_name_placeholder'].'" class="snp-field-name" />';
			echo '</div>';
		    }
		    ?>
		    <div class="snp-field snp-mail">
			<input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field-email" />
		    </div>		
		    <button type="submit" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-btn snp-btnc snp-submit"><?php echo $POPUP_META['snp_submit_button'];?></button>
		</form>
	    </div>
	</div>
	<div class="snp-policy">
	<?php
	if (!empty($POPUP_META['snp_security_note']))
	{
		echo '<p class="snp-lock">'.$POPUP_META['snp_security_note'].'</p>';
	}
	if ($POPUP_META['snp_show_cb_button'] == 'yes')
	{  
	    echo '<p class="snp-nope"><a href="#" class="snp-close-link">' . $POPUP_META['snp_cb_text'] . '</a>';
	}
	?>
	</div>
    </div>
</div>
<script>
var snp_bar4_open = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar4').not('.snp-pos-static').addClass('snp-showme');
}
var snp_bar4_close = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar4').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar4').removeClass('snp-showme').show(); });
}
</script>
<?php
if(isset($POPUP_META['snp_maintext_font']))
{
	$POPUP_META['snp_maintext_font']=unserialize($POPUP_META['snp_maintext_font']);
}
if(isset($POPUP_META['snp_submit_button_color']))
{
	$POPUP_META['snp_submit_button_color']=unserialize($POPUP_META['snp_submit_button_color']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-container { width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-main { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-main p {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-main p {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['font']))
{
    echo '.snp-pop-'.$ID.' .snp-bar4 .snp-main p {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
    echo '.snp-pop-'.$ID.' .snp-bar4 .snp-field input {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
    echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btn {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar4 { background-color: '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_img_top']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-image  { margin-top: '.$POPUP_META['snp_img_top'].'px;}'."\n";
}

if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']['from']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc { background-color: '.$POPUP_META['snp_submit_button_color']['from'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {background:  '.$POPUP_META['snp_submit_button_color']['from'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {background: -moz-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['from'].' 0%, '.$POPUP_META['snp_submit_button_color']['to'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, '.$POPUP_META['snp_submit_button_color']['from'].'), color-stop(100%,'.$POPUP_META['snp_submit_button_color']['to'].')); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {background: -webkit-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['from'].' 0%,'.$POPUP_META['snp_submit_button_color']['to'].' 100%);}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {background: -o-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['from'].' 0%,'.$POPUP_META['snp_submit_button_color']['to'].' 100%);}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {background: -ms-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['from'].' 0%,'.$POPUP_META['snp_submit_button_color']['to'].' 100%);}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {background: linear-gradient(to bottom,  '.$POPUP_META['snp_submit_button_color']['from'].' 0%,'.$POPUP_META['snp_submit_button_color']['to'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 .snp-btnc {filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\' '.$POPUP_META['snp_submit_button_color']['from'].'\', endColorstr=\''.$POPUP_META['snp_submit_button_color']['to'].'\',GradientType=0 ); }'."\n";

	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover { background-color: '.$POPUP_META['snp_submit_button_color']['to'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {background:  '.$POPUP_META['snp_submit_button_color']['to'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {background: -moz-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%, '.$POPUP_META['snp_submit_button_color']['from'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, '.$POPUP_META['snp_submit_button_color']['to'].'), color-stop(100%,'.$POPUP_META['snp_submit_button_color']['from'].')); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {background: -webkit-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%);}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {background: -o-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%);}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {background: -ms-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%);}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {background: linear-gradient(to bottom,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar4 button.snp-btnc:hover {filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\' '.$POPUP_META['snp_submit_button_color']['to'].'\', endColorstr=\''.$POPUP_META['snp_submit_button_color']['from'].'\',GradientType=0 ); }'."\n";
	
}
echo '</style>';
