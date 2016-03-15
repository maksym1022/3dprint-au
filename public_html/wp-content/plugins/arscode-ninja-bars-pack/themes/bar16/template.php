<div class="snp-fb snp-bar16 <?php echo $POPUP_META['snp_position'] . ' ' . $POPUP_META['snp_open_effect']; ?>">
    <div class="snp-container">
	<div class="snp-clearfix">
	    <div class="snp-main">
	    <?php
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {  
		echo '<div class="snp-close snp-close-link"><img src="'.SNP_BAR_URL.'themes/bar16/gfx/close.png" alt=""></div>';
	    }
	    ?>
            <div class="snp-top"><?php
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<h2>'.$POPUP_META['snp_header'].'</h2>'; 
	    }
	    ?></div>
	    <?php
	    if(!empty($POPUP_META['snp_maintext']))
	    {
		echo '<p>'.$POPUP_META['snp_maintext'].'</p>'; 
	    }
	    ?>
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
			    echo '<ul>';
			    foreach ((array) $POPUP_META['snp_bulletlist'] as $v)
			    {
				    echo '<li>' . $v . '</li>';
			    }
			    echo '</ul>';
		    }
	    }
	    ?>
	  </div>
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
	    <div class="snp-btn-holder">
		<button data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-btn snp-submit snp-nomw" type="submit"><?php echo $POPUP_META['snp_submit_button'];?></button>
		<div class="snp-click-it-now"></div>
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
<script>
    var snp_bar16_open = function()
    {
	jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar16').not('.snp-pos-static').addClass('snp-showme');
    }
    var snp_bar16_close = function()
    {
        jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar16').not('.snp-pos-static').fadeOut('fast',function(){ jQuery('.snp-pop-<?php echo $ID; ?> .snp-bar16').removeClass('snp-showme').show(); });
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
if(isset($POPUP_META['snp_bg_color1']))
{
	$POPUP_META['snp_bg_color1']=unserialize($POPUP_META['snp_bg_color1']);
}
if(isset($POPUP_META['snp_submit_button_color']))
{
	$POPUP_META['snp_submit_button_color']=unserialize($POPUP_META['snp_submit_button_color']);
}
echo '<style>';
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-bar16 .snp-container { min-height: '.$POPUP_META['snp_height'].'px; }'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
	echo '.snp-pop-'.$ID.' .snp-bar16 { background: '.$POPUP_META['snp_bg_color1']['from'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar16 { background-image: -webkit-gradient(linear, 0, 0 100%, from('.$POPUP_META['snp_bg_color1']['from'].'), to('.$POPUP_META['snp_bg_color1']['to'].'));}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar16 { background-image: -webkit-linear-gradient('.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].');}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar16 { background-image: -moz-linear-gradient('.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].');}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar16 { background-image: -o-linear-gradient('.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].');}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar16 { background-image: linear-gradient('.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].');}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn {background: '.$POPUP_META['snp_submit_button_color']['from'].'; }'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn {border:1px solid '.$POPUP_META['snp_submit_button_color']['to'].';}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn {background-image: -webkit-gradient(linear, 0 0, 0 100%, from('.$POPUP_META['snp_submit_button_color']['from'].'), to('.$POPUP_META['snp_submit_button_color']['to'].'));}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn {background-image: -webkit-linear-gradient('.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn {background-image: -moz-linear-gradient('.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn {background-image: -o-linear-gradient('.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn {background-image: linear-gradient('.$POPUP_META['snp_submit_button_color']['from'].', '.$POPUP_META['snp_submit_button_color']['to'].');}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn:hover {background: '.$POPUP_META['snp_submit_button_color']['to'].'; }'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn:hover {border:1px solid '.$POPUP_META['snp_submit_button_color']['from'].';}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn:hover {background-image: -webkit-gradient(linear, 0 0, 0 100%, from('.$POPUP_META['snp_submit_button_color']['to'].'), to('.$POPUP_META['snp_submit_button_color']['from'].'));}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn:hover {background-image: -webkit-linear-gradient('.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn:hover {background-image: -moz-linear-gradient('.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn:hover {background-image: -o-linear-gradient('.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}'."\n";
  	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn:hover {background-image: linear-gradient('.$POPUP_META['snp_submit_button_color']['to'].', '.$POPUP_META['snp_submit_button_color']['from'].');}'."\n";
}

if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar16 .snp-top h2  { font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-bar16 .snp-main p, .snp-pop-'.$ID.' .snp-bar16 .snp-main ul { color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['font']))
{
    
	echo '.snp-pop-'.$ID.' .snp-bar16 .snp-top h2  {font-family: "'.$POPUP_META['snp_header_font']['font'].'";}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['color']))
{
    	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn { color: '.$POPUP_META['snp_submit_button_text']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn  {font-family: "'.$POPUP_META['snp_submit_button_text']['font'].'";}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-bar16 button.snp-btn  { font-size: '.$POPUP_META['snp_submit_button_text']['size'].'px;}'."\n";
}
if(!empty($POPUP_META['snp_click_img']))
{
	echo '.snp-pop-'.$ID.' .snp-bar16 .snp-click-it-now { background: url("'.$POPUP_META['snp_click_img'].'");}'."\n";
}
echo '</style>';

