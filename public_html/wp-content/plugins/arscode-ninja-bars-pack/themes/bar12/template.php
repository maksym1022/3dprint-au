<div class="snp-fb snp-bar12 <?php echo $POPUP_META['snp_position'] . ' ' . $POPUP_META['snp_open_effect']; ?>">
    <div class="snp-top">
          <div class="snp-container">
	    <?php
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {  
		echo '<div class="snp-arrow snp-close-link"><img src="'.SNP_BAR_URL.'themes/bar12/gfx/close.png" alt=""></div>';
	    }
	    ?>
            <p><img src="<?php echo SNP_BAR_URL; ?>themes/bar12/gfx/envelope.png" alt=""> <?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo ''.$POPUP_META['snp_header'].''; 
	    }
	    ?></p>
          </div>
        </div>
        <div class="snp-container">
          <div class="snp-subscribe">
            <?php
	    if(!empty($POPUP_META['snp_header2']))
	    {
		echo ''.$POPUP_META['snp_header2'].''; 
	    }
	    ?>
          </div>
	    <?php
	    if (!empty($POPUP_META['snp_bulletlist']))
	    {
		    $POPUP_META['snp_bulletlist'] = unserialize($POPUP_META['snp_bulletlist']);
		    foreach ($POPUP_META['snp_bulletlist'] as $k => $v)
		    {
			    if (!trim($v))
			    {
				    unset($POPUP_META['snp_bulletlist'][$k]);
			    }
		    }
		    if (count($POPUP_META['snp_bulletlist']) > 0)
		    {
			    echo '<ul class="snp-features">';
			    foreach ((array) $POPUP_META['snp_bulletlist'] as $v)
			    {
				    echo '<li>' . $v . '</li>';
			    }
			    echo '</ul>';
		    }
	    }
	    ?>
	  <form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-form snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
	    <?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
            <input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field-email" />
	    <input data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-submit snp-nomw" type="submit" value="<?php echo $POPUP_META['snp_submit_button'];?>">
          </form>
        </div>
</div>
<script>
    var snp_bar12_open = function()
    {
	jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar12').not('.snp-pos-static').addClass('snp-showme');
    }
    var snp_bar12_close = function()
    {
	jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar12').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar12').removeClass('snp-showme').show(); });
    }
</script>
<?php
if(isset($POPUP_META['snp_header_font']))
{
	$POPUP_META['snp_header_font']=unserialize($POPUP_META['snp_header_font']);
}
if(isset($POPUP_META['snp_header2_font']))
{
	$POPUP_META['snp_header2_font']=unserialize($POPUP_META['snp_header2_font']);
}
if(isset($POPUP_META['snp_submit_button_text']))
{
	$POPUP_META['snp_submit_button_text']=unserialize($POPUP_META['snp_submit_button_text']);
}
echo '<style>';
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar12 .snp-container { min-height: '.$POPUP_META['snp_height'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar12 .snp-top { background-color: '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color2']))
{
	echo '.snp-pop-'.$ID.' .snp-bar12 { background-color: '.$POPUP_META['snp_bg_color2'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="submit"] { background:  '.$POPUP_META['snp_submit_button_color'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="submit"] { border-color:  '.$POPUP_META['snp_submit_button_color'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="text"] { border-color:  '.$POPUP_META['snp_submit_button_color'].'; }'."\n";
}

if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar12 .snp-top p { font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['font']))
{
	echo '.snp-pop-'.$ID.' .snp-bar12 .snp-top p {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar12 .snp-container .snp-subscribe {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="text"] {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="submit"] {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_header2_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar12 .snp-container .snp-subscribe { font-size: '.$POPUP_META['snp_header2_font']['size'].'px; color: '.$POPUP_META['snp_header2_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar12 .snp-container .snp-features li { color: '.$POPUP_META['snp_header2_font']['color'].';}'."\n";	
	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="text"] {color: '.$POPUP_META['snp_header2_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="submit"] { color: '.$POPUP_META['snp_submit_button_text']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['size']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="text"] {font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px;}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar12 form input[type="submit"] { font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px;}'."\n";
}

echo '</style>';