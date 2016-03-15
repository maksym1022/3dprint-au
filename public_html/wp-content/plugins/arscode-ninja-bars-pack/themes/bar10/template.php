<div class="snp-fb snp-bar10 <?php echo $POPUP_META['snp_position'].' '.$POPUP_META['snp_open_effect']; ?>">
    <div class="snp-top"></div>
    <div class="snp-container">
	<div class="snp-left">
            <div class="snp-subscribe">
		<img src="<?php echo SNP_BAR_URL; ?>themes/bar10/gfx/envelope.png" alt="">
            </div>
            <div class="snp-features">
		<?php
		if(!empty($POPUP_META['snp_header']))
		{
		    echo '<h3>'.$POPUP_META['snp_header'].'</h3>'; 
		}
		?> 
		<?php
		if(!empty($POPUP_META['snp_subheader']))
		{
		    echo '<ul><li>'.$POPUP_META['snp_subheader'].'</li></ul>'; 
		}
		?> 
            </div>
	</div>
	<?php
	if ($POPUP_META['snp_show_cb_button'] == 'yes')
	{  
	    echo '<div class="snp-close snp-close-link"></div>';
	}
	?>
	<form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-form snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
	    <?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
            <?php
	    if(!$POPUP_META['snp_name_disable'])
	    {
		echo '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp_name" placeholder="'.$POPUP_META['snp_name_placeholder'].'" class="snp-field-name" />';
	    }
	    ?>
	    <input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field-email" />
	    <input class="snp-submit" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" type="submit" value="<?php echo $POPUP_META['snp_submit_button'];?>">
	</form>
    </div>
</div>
<script>
var snp_bar10_open = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar10').not('.snp-pos-static').addClass('snp-showme');
}
var snp_bar10_close = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar10').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar10').removeClass('snp-showme').show(); });
}
</script>
<?php
if(isset($POPUP_META['snp_header_font']))
{
	$POPUP_META['snp_header_font']=unserialize($POPUP_META['snp_header_font']);
}
if(isset($POPUP_META['snp_submit_button_text']))
{
	$POPUP_META['snp_submit_button_text']=unserialize($POPUP_META['snp_submit_button_text']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container { width: '.$POPUP_META['snp_width'].'px; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container-top { width: '.$POPUP_META['snp_width'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar10 { min-height: '.$POPUP_META['snp_height'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar10 { background-color: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="submit"] { background-color: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container .snp-left .snp-features h3 {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
 if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container .snp-left .snp-features h3 {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}

if (!empty($POPUP_META['snp_submit_button_text']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="submit"] {font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px; color: '.$POPUP_META['snp_submit_button_text']['color'].';}'."\n";
}
 if (!empty($POPUP_META['snp_submit_button_text']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="submit"] {font-family: "'.$POPUP_META['snp_submit_button_text']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_border_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="submit"] { border-color: '.$POPUP_META['snp_submit_button_border_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_input_bg_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="text"] { background-color: '.$POPUP_META['snp_input_bg_color'].';}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container .snp-close { background-color: '.$POPUP_META['snp_input_bg_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_input_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="text"] { color: '.$POPUP_META['snp_input_text_color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="text"]::-webkit-input-placeholder { color: '.$POPUP_META['snp_input_text_color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar10 .snp-container form input[type="text"]:-moz-placeholder { color: '.$POPUP_META['snp_input_text_color'].';}'."\n";
}
echo '</style>';