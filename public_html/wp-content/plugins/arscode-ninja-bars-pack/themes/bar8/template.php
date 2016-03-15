<div class="snp-fb snp-bar8 <?php echo $POPUP_META['snp_position'] . ' ' . $POPUP_META['snp_open_effect']; ?>">
    <div class="snp-container">
	<?php
	if ($POPUP_META['snp_show_cb_button'] == 'yes')
	{  
	    echo '<div class="snp-close snp-close-link"></div>';
	}
	?>
	<div class="snp-left">
	    <img src="<?php echo SNP_BAR_URL; ?>themes/bar8/gfx/envelope.png" alt="">
	</div>
	<div class="snp-right">
	    <form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-form snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
		<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
		<input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field-email" />
		<input data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-submit snp-nomw" type="submit" value="<?php echo $POPUP_META['snp_submit_button'];?>">
	    </form>
	   <?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<p>'.$POPUP_META['snp_header'].'</p>'; 
	    }
	    ?> 
	</div>
    </div>
</div>
<script>
    var snp_bar8_open = function()
    {
	jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar8').not('.snp-pos-static').addClass('snp-showme');
    }
    var snp_bar8_close = function()
    {
	jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar8').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar8').removeClass('snp-showme').show(); });
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
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-container { width: '.$POPUP_META['snp_width'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-container { min-height: '.$POPUP_META['snp_height'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right { background-color: '.$POPUP_META['snp_bg_color1'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-left:before { border-right:15px solid '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right p {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-container {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right form input[type="text"] {font-family: "'.$POPUP_META['snp_submit_button_text']['font'].'";}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right form input[type="submit"] {font-family: "'.$POPUP_META['snp_submit_button_text']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right form input[type="submit"] { color: '.$POPUP_META['snp_submit_button_text']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['size']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right form input[type="text"] {font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px;}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right form input[type="submit"] { font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right form input[type="submit"] { background:  '.$POPUP_META['snp_submit_button_color'].'; }'."\n";
}
if (!empty($POPUP_META['snp_submit_button_hover_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar8 .snp-right form input[type="submit"]:hover { background:  '.$POPUP_META['snp_submit_button_hover_color'].'; }'."\n";
}
echo '</style>';
