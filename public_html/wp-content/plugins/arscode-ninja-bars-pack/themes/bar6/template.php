<div class="snp-fb snp-bar6 <?php echo $POPUP_META['snp_position'].' '.$POPUP_META['snp_open_effect']; ?>">
    <div class="snp-top">
	<div class="snp-container-top">
	    <?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<h2>'.$POPUP_META['snp_header'].'</h2>'; 
	    }
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {  
		echo '<div class="snp-close snp-close-link '.(isset($POPUP_META['snp_close_button']) ? 'snp-close-'.$POPUP_META['snp_close_button'] : '').'"></div>';
	    }
	    ?>
	</div>
    </div>
    <div class="snp-container">
	<div class="snp-main">
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
	    <div class="snp-policy">
	    <?php
	    if (!empty($POPUP_META['snp_security_note']))
	    {
		    echo '<p class="snp-lock">'.$POPUP_META['snp_security_note'].'</p>';
	    }
	    ?>
	    </div>
	</div>
    </div>
</div>
<script>
var snp_bar6_open = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar6').not('.snp-pos-static').addClass('snp-showme');
}
var snp_bar6_close = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar6').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar6').removeClass('snp-showme').show(); });
}
</script>
<?php

if(isset($POPUP_META['snp_header_font']))
{
	$POPUP_META['snp_header_font']=unserialize($POPUP_META['snp_header_font']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-container { width: '.$POPUP_META['snp_width'].'px; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-container-top { width: '.$POPUP_META['snp_width'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-main { min-height: '.$POPUP_META['snp_height'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar6 { background-color: '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_line_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-top { border-bottom: 4px solid '.$POPUP_META['snp_line_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_img1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-top { background: url(\''.$POPUP_META['snp_bg_img1'].'\');}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-top h2 {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
 if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-top h2 {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-btnc { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-btnc { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar6 .snp-btnc { background:  '.$POPUP_META['snp_submit_button_color'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar6 button.snp-btnc:hover { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar6 button.snp-btnc:hover { background:  '.$POPUP_META['snp_submit_button_color'].'; }'."\n";

}
echo '</style>';
