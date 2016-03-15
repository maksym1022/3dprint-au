<div class="snp-fb snp-bar1 <?php echo $POPUP_META['snp_position'].' '.$POPUP_META['snp_open_effect']; ?>">
    <div class="snp-top">
	<div class="snp-container">
	    <?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<h2>'.$POPUP_META['snp_header'].'</h2>'; 
	    }
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {  
		echo '<div class="snp-close snp-close-link">×</div>';
	    }
	    ?>
	</div>
    </div>
    <div class="snp-main">
	<div class="snp-container">
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
		<button type="submit" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-btn snp-submit snp-nomw"><?php echo $POPUP_META['snp_submit_button'];?></button>
	    </form>
	    <?php
	    if (!empty($POPUP_META['snp_security_note']))
	    {
		    echo '<div class="snp-policy"><p>'.$POPUP_META['snp_security_note'].'</p></div>';
	    }
	    ?>
	</div>
    </div>
</div>
<script>
var snp_bar1_open = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar1').not('.snp-pos-static').addClass('snp-showme');
}
var snp_bar1_close = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar1').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar1').removeClass('snp-showme').show(); });
}
</script>
<?php
if(isset($POPUP_META['snp_header_font']))
{
	$POPUP_META['snp_header_font']=unserialize($POPUP_META['snp_header_font']);
}
if(isset($POPUP_META['snp_maintext_font']))
{
	$POPUP_META['snp_maintext_font']=unserialize($POPUP_META['snp_maintext_font']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-container { width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-main { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-top h2 {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-close { background: '.$POPUP_META['snp_header_font']['color'].';;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-top h2 {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['font']))
{
    echo '.snp-pop-'.$ID.' .snp-bar1 .snp-main p {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
    echo '.snp-pop-'.$ID.' .snp-bar1 .snp-field input {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
    echo '.snp-pop-'.$ID.' .snp-bar1 button.snp-btn {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-main p {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-main p {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-submit { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-submit { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_border_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-submit:hover { background-color: '.$POPUP_META['snp_submit_button_border_color'].';}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-submit, .snp-pop-'.$ID.' .snp-bar1 .snp-field input { border-color: '.$POPUP_META['snp_submit_button_border_color'].';}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-field input { color: '.$POPUP_META['snp_submit_button_border_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-top { background-color: '.$POPUP_META['snp_bg_color1'].';}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-close { color: '.$POPUP_META['snp_bg_color1'].';}'."\n";

      echo '.snp-pop-'.$ID.' .snp-bar1 .snp-close:hover { background-color: '.$POPUP_META['snp_bg_color2'].'; color: '.$POPUP_META['snp_header_font']['color'].'; }'."\n";

}
if (!empty($POPUP_META['snp_bg_color2']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar1 .snp-main { background-color: '.$POPUP_META['snp_bg_color2'].';}'."\n";
}
echo '</style>';
