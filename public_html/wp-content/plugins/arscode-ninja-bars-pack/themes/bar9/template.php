<div class="snp-fb snp-bar9 <?php echo $POPUP_META['snp_position'] . ' ' . $POPUP_META['snp_open_effect']; ?>">
    <div class="snp-container">
    <?php
	if ($POPUP_META['snp_show_cb_button'] == 'yes')
	{  
	    echo '<div class="snp-close snp-close-link"></div>';
	}
	?>
	<div class="snp-inner">
	    <img src="<?php echo SNP_BAR_URL; ?>themes/bar9/gfx/envelope.png" alt="">
	    <?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<h3>'.$POPUP_META['snp_header'].'</h3>'; 
	    }
	    ?> 
	    <form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-form snp-clearfix snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
		<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
		<input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field-email" />
		<input data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-submit snp-nomw" type="submit" value="<?php echo $POPUP_META['snp_submit_button'];?>">
	    </form>
	    <?php
	    if(!empty($POPUP_META['snp_bottom_text']))
	    {
		echo '<p><img src="'.SNP_BAR_URL.'themes/bar9/gfx/tick.png" alt="">'.$POPUP_META['snp_bottom_text'].'</p>'; 
	    }
	    ?> 
	</div>
    </div>
</div>
<script>
    var snp_bar9_open = function()
    {
	jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar9').not('.snp-pos-static').addClass('snp-showme');
    }
    var snp_bar9_close = function()
    {
	jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar9').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar9').removeClass('snp-showme').show(); });
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
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar9 .snp-container { min-height: '.$POPUP_META['snp_height'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar9 { background-color: '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar9 h3 { font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar9 p { color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar9 h3 {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar9 form input[type="text"] {font-family: "'.$POPUP_META['snp_submit_button_text']['font'].'";}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar9 form input[type="submit"] {font-family: "'.$POPUP_META['snp_submit_button_text']['font'].'";}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar9 p {font-family: "'.$POPUP_META['snp_submit_button_text']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar9 form input[type="submit"] { color: '.$POPUP_META['snp_submit_button_text']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['size']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar9 form input[type="text"] {font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px;}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar9 form input[type="submit"] { font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar9 form input[type="submit"] { background:  '.$POPUP_META['snp_submit_button_color'].'; }'."\n";
}
echo '</style>';
