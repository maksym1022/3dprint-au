<div class="snp-fb snp-bar3 <?php echo $POPUP_META['snp_position'].' '.$POPUP_META['snp_open_effect']; ?>">
    <div class="snp-top">
	<div class="snp-container snp-line">
	    <?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<h2>'.$POPUP_META['snp_header'].'</h2>'; 
	    }
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {  
		echo '<div class="snp-close snp-btnc snp-close-link">×</div>';
	    }
	    ?>
	</div>
    </div>
    <div class="snp-main">
	<div class="snp-container">
	    <?php
	    if(!empty($POPUP_META['snp_maintext']))
	    {
		echo '<div class="snp-column-left"><p>'.$POPUP_META['snp_maintext'].'</p></div>'; 
	    }
	    ?>
	    <div class="snp-column-right">
		<form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-form snp-clearfix snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
		    <?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
		    <?php
		    if(!$POPUP_META['snp_name_disable'])
		    {
			echo '<div class="snp-field snp-name">';
			echo '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp_name" placeholder="'.$POPUP_META['snp_name_placeholder'].'" class="snp-field snp-field-name" />';
			echo '</div>';
		    }
		    ?>
		    <div class="snp-field snp-mail">
			<input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field snp-field-email" />
			<button type="submit" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-btn snp-btnc snp-submit snp-nomw"><?php echo $POPUP_META['snp_submit_button'];?></button>
		    </div>		
		</form>
	    </div>
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
var snp_bar3_open = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar3').not('.snp-pos-static').addClass('snp-showme');
}
var snp_bar3_close = function()
{
    jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar3').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar3').removeClass('snp-showme').show(); });
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
if(isset($POPUP_META['snp_submit_button_color']))
{
	$POPUP_META['snp_submit_button_color']=unserialize($POPUP_META['snp_submit_button_color']);
}
if(isset($POPUP_META['snp_bg_gradient']))
{
	$POPUP_META['snp_bg_gradient']=unserialize($POPUP_META['snp_bg_gradient']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-container { width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-main { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-top h2 {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-main p {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-main p {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
}
 if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-top h2 {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['font']))
{
    echo '.snp-pop-'.$ID.' .snp-bar3 .snp-main p {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
    echo '.snp-pop-'.$ID.' .snp-bar3 .snp-field input {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
    echo '.snp-pop-'.$ID.' .snp-bar3 button.snp-btn {font-family: "'.$POPUP_META['snp_maintext_font']['font'].'";}'."\n";
}
if ($POPUP_META['snp_bg_gradient']['from'])
{
    if(!$POPUP_META['snp_bg_gradient']['to'])
	{
		$POPUP_META['snp_bg_gradient']['to']=$POPUP_META['snp_bg_gradient']['from'];
	}
	?>
		.snp-pop-<?php echo $ID; ?> .snp-bar3 {
		  background: <?php echo $POPUP_META['snp_bg_gradient']['to'];?>;
		  background-image: -moz-radial-gradient(50% 50%, circle contain, <?php echo $POPUP_META['snp_bg_gradient']['from'];?>, <?php echo $POPUP_META['snp_bg_gradient']['to'];?> 120%);
		  background-image: -webkit-radial-gradient(50% 50%, circle contain, <?php echo $POPUP_META['snp_bg_gradient']['from'];?>, <?php echo $POPUP_META['snp_bg_gradient']['to'];?> 120%);
		  background-image: -o-radial-gradient(50% 50%, circle contain, <?php echo $POPUP_META['snp_bg_gradient']['from'];?>, <?php echo $POPUP_META['snp_bg_gradient']['to'];?> 120%);
		  background-image: -ms-radial-gradient(50% 50%, circle contain, <?php echo $POPUP_META['snp_bg_gradient']['from'];?>, <?php echo $POPUP_META['snp_bg_gradient']['to'];?> 120%);
		  background-image: radial-gradient(50% 50%, circle contain, <?php echo $POPUP_META['snp_bg_gradient']['from'];?>, <?php echo $POPUP_META['snp_bg_gradient']['to'];?> 120%);
		}
		.snp-pop-<?php echo $ID; ?> .snp-bar3 .snp-powered {
		  background: <?php echo $POPUP_META['snp_bg_gradient']['to'];?>;
		  color: <?php if ($POPUP_META['snp_header_font']['color']) {echo $POPUP_META['snp_header_font']['color'];}else{echo '#fff';}?>;
		}
	<?php
}
if ($POPUP_META['snp_bg_image'] && $POPUP_META['snp_bg_image']=='uploaded')
{
	echo '.snp-pop-'.$ID.' .snp-bar3 { background-image: url('.$POPUP_META['snp_bg_image_upload'].'); background-position: center center; background-repeat: no-repeat;}';
}
elseif($POPUP_META['snp_bg_image']!='uploaded' && $POPUP_META['snp_bg_image']!='disabled' && $POPUP_META['snp_bg_image'])
{
	echo '.snp-pop-'.$ID.' .snp-bar3 { background-image: url('.SNP_BAR_URL . 'themes/bar3/gfx/'.$POPUP_META['snp_bg_image'].'.png'.'); background-position: center center; background-repeat: no-repeat;}';
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']['from']))
{
  echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover { background-color: '.$POPUP_META['snp_submit_button_color']['to'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {background:  '.$POPUP_META['snp_submit_button_color']['to'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {background: -moz-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%, '.$POPUP_META['snp_submit_button_color']['from'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, '.$POPUP_META['snp_submit_button_color']['to'].'), color-stop(100%,'.$POPUP_META['snp_submit_button_color']['from'].')); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {background: -webkit-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {background: -o-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {background: -ms-linear-gradient(top,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%);}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {background: linear-gradient(to bottom,  '.$POPUP_META['snp_submit_button_color']['to'].' 0%,'.$POPUP_META['snp_submit_button_color']['from'].' 100%); }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc, .snp-pop-'.$ID.' .snp-bar3 button.snp-btnc:hover {filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\' '.$POPUP_META['snp_submit_button_color']['to'].'\', endColorstr=\''.$POPUP_META['snp_submit_button_color']['from'].'\',GradientType=0 );}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_border_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc:hover { border-color: '.$POPUP_META['snp_submit_button_border_color'].';}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar3 .snp-btnc { border-color: '.$POPUP_META['snp_submit_button_border_color'].';}'."\n";
}
echo '</style>';
