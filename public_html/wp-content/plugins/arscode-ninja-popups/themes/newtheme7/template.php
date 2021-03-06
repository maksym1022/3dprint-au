<div class="snp-fb snp-newtheme7">
    <div class="snp-steps snp-step-1 snp-step-show">
	<div class="snp-media">
	    <?php
	    if(!empty($POPUP_META['snp_s1img']))
	    {
	       echo '<div class="snp-media__img"><img src="'.$POPUP_META['snp_s1img'].'" alt=""></div>'; 
	    }
	    echo '<div class="snp-media__body">';
	    if(!empty($POPUP_META['snp_s1header']))
	    {
		echo '<div class="snp-h3 snp-delta">'.$POPUP_META['snp_s1header'].'</div>'; 
	    }
	    if(!empty($POPUP_META['snp_s1subheader']))
	    {
		echo '<div class="snp-h1 snp-beta  snp-uppercase  snp-color--primary">'.$POPUP_META['snp_s1subheader'].'</div>'; 
	    }
	    if(!empty($POPUP_META['snp_s1maintext']))
	    {
	      echo '<p>'.nl2br($POPUP_META['snp_s1maintext']).'</p>'; 
	    }
	    if(!empty($POPUP_META['snp_s1bulletlist']))
	    {
		    $POPUP_META['snp_s1bulletlist']=unserialize($POPUP_META['snp_s1bulletlist']);
		    foreach($POPUP_META['snp_s1bulletlist'] as $k => $v)
		    {
			    if(!trim($v))
			    {
				    unset($POPUP_META['snp_s1bulletlist'][$k]);
			    }
		    }
		    if(count($POPUP_META['snp_s1bulletlist'])>0)
		    {
			    echo '<ul class="snp-list">';
			    foreach((array)$POPUP_META['snp_s1bulletlist'] as $v)
			    {
				    echo '<li>'.$v.'</li>';
			    }
			    echo '</ul>';  
		    }
	    }
	    echo '</div>';
	    ?>
	</div>
        <footer class="snp-theme__footer snp-flush--top">
	    <div class="snp-theme__choice">
		<?php
		echo '<a href="'.($POPUP_META['snp_s1left_action']==2 ? $POPUP_META['snp_s1left_action_url'] : '#').'" data-nextstep="2" class="'.($POPUP_META['snp_s1left_action']==3 ? 'snp_nothanks' : '').''.($POPUP_META['snp_s1left_action']==1 ? 'snp_nextstep' : '').' snp-btn snp-btn--primary">';
		if(!empty($POPUP_META['snp_s1left_button']))
		{
		    echo ''.$POPUP_META['snp_s1left_button'].''; 
		}
		echo '</a>';
		if(!isset($POPUP_META['snp_s1disable_right']) || $POPUP_META['snp_s1disable_right']!=2)
		{
		    if(!empty($POPUP_META['snp_s1between_text']))
		    {
			echo '<span class="snp-theme__choice-or">'.$POPUP_META['snp_s1between_text'].'</span>'; 
		    }
		    echo '<a href="'.($POPUP_META['snp_s1right_action']==2 ? $POPUP_META['snp_s1right_action_url'] : '#').'" data-nextstep="2" class="'.($POPUP_META['snp_s1right_action']==3 ? 'snp_nothanks' : '').''.($POPUP_META['snp_s1right_action']==1 ? 'snp_nextstep' : '').' snp-btn snp-btn--secondary">';
		    if(!empty($POPUP_META['snp_s1right_button']))
		    {
			echo ''.$POPUP_META['snp_s1right_button'].''; 
		    }
		    echo '</a>';
		}
		?>
	    </div>
	    <?php
	    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	    {
		    echo '<a class="snp_nothanks snp-footer__link" href="#">'.$POPUP_META['snp_cb_text'].'</a>';
	    }
	    ?>
	</footer>
    </div>
    <div class="snp-steps snp-step-2">
        <?php
	if(!empty($POPUP_META['snp_s2header']))
	{
	    echo '<div class="snp-h3 snp-gamma">'.$POPUP_META['snp_s2header'].'</div>'; 
	}
	?>
	<form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-push--ends snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
	    <?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
	    <?php
	    if(!empty($POPUP_META['snp_s2maintext']))
	    {
	      echo '<p>'.nl2br($POPUP_META['snp_s2maintext']).'</p>'; 
	    }
	    ?>
            <ul class="snp-fields-list">
		<?php
		if(isset($POPUP_META['snp_cf']))
		{
		    $name_field =  '<li><input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp-name" placeholder="'.$POPUP_META['snp_name_placeholder'].'" class="snp-field snp-field-name" /></li>';
		    $email_field = '<li><input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email').'" id="snp_email" placeholder="'.$POPUP_META['snp_email_placeholder'].'"  class="snp-field snp-field-email" /></li>';
		    $tpl_field = '<li>%FIELD%</li>';
		     snp_custom_fields(unserialize($POPUP_META['snp_cf']),array(
			 'email_field' => $email_field,
			 'name_field' => $name_field,
			 'tpl_field' => $tpl_field,
			 'snp_name_disable' => $POPUP_META['snp_name_disable']
		     )); 
		}
		?>
            </ul>
	    <footer class="snp-theme__footer">
		<p>
		    <button class="snp-subscribe-button snp-submit snp-btn  snp-btn--primary  snp-btn--large" data-nextstep="3" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" type="submit"><?php echo $POPUP_META['snp_submit_button'];?></button>
		</p>
		<?php
		if ($POPUP_META['snp_show_cb_button'] == 'yes')
		{
			echo '<a class="snp_nothanks snp-footer__link" href="#">'.$POPUP_META['snp_cb_text'].'</a>';
		}
		?>
	    </footer>
	</form>
    </div>
    <div class="snp-steps snp-step-3">
	<?php
	if(!empty($POPUP_META['snp_s3header']))
	{
	    echo '<div class="snp-h2 snp-gamma">'.$POPUP_META['snp_s3header'].'</div>'; 
	}
	if(!empty($POPUP_META['snp_s3subheader']))
	{
	    echo '<div class="snp-h1 snp-alpha snp-uppercase  snp-color--primary">'.$POPUP_META['snp_s3subheader'].'</div>'; 
	}
	if(!empty($POPUP_META['snp_s3img']))
	{
	   echo '<p class="snp-islet"><img src="'.$POPUP_META['snp_s3img'].'" alt=""></p>'; 
	}
	?>
        <footer class="snp-theme__footer">
	    <?php
	    if(!empty($POPUP_META['snp_s3button']))
	    {
		echo '<p><a href="'.($POPUP_META['snp_s3button_action']==2 ? $POPUP_META['snp_s3button_action_url'] : '#').'" class="'.($POPUP_META['snp_s3button_action']==3 ? 'snp_nothanks' : '').''.($POPUP_META['snp_s3button_action']==1 ? 'snp_nextstep' : '').' snp-btn snp-btn--secondary">'.$POPUP_META['snp_s3button'].'</a></p>';
	    }
	    ?>
        </footer>
    </div>
	<?php
    if((snp_get_option('PROMO_ON') && snp_get_option('PROMO_REF')) && SNP_PROMO_LINK!='')
    {
	    $PROMO_LINK=SNP_PROMO_LINK.snp_get_option('PROMO_REF');
	    echo '<div class="snp-powered-b">';
	    echo '<a href="'.$PROMO_LINK.'" target="_blank">Powered by <strong>Ninja Popups</strong></a>';
	    echo '</div>';
    }
    ?>
</div>
<?php
$POPUP_OPTS=array('s1header_font','s1subheader_font','s2header_font','s3header_font','s3subheader_font');
foreach($POPUP_OPTS as $v)
{
    if(isset($POPUP_META['snp_'.$v]))
    {
	    $POPUP_META['snp_'.$v]=unserialize($POPUP_META['snp_'.$v]);
    }
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-newtheme7 { width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-newtheme7 { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 { background: '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color2']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme__footer { background: '.$POPUP_META['snp_bg_color2'].';}'."\n";
}
if (!empty($POPUP_META['snp_footer_border_top']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme__footer { border-top: 1px solid '.$POPUP_META['snp_footer_border_top'].';}'."\n";
}
if (!empty($POPUP_META['snp_s1header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-newtheme7 {color: '.$POPUP_META['snp_s1header_font']['color'].';}';
	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-1 .snp-h3 {font-size: '.$POPUP_META['snp_s1header_font']['size'].'px; color: '.$POPUP_META['snp_s1header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s1subheader_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-1 .snp-h1{ font-size: '.$POPUP_META['snp_s1subheader_font']['size'].'px; color: '.$POPUP_META['snp_s1subheader_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-color--primary { color: '.$POPUP_META['snp_s1subheader_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s1left_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-1 .snp-btn--primary { background: '.$POPUP_META['snp_s1left_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s1left_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-1 .snp-btn--primary { color: '.$POPUP_META['snp_s1left_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s1right_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-1 .snp-btn--secondary { background: '.$POPUP_META['snp_s1right_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s1right_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-1 .snp-btn--secondary { color: '.$POPUP_META['snp_s1right_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s2header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-2 .snp-h3 {font-size: '.$POPUP_META['snp_s2header_font']['size'].'px; color: '.$POPUP_META['snp_s2header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-2 .snp-btn--primary { background: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-2 .snp-btn--primary { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s3button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-3 .snp-btn--secondary { background: '.$POPUP_META['snp_s3button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s3button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-3 .snp-btn--secondary { color: '.$POPUP_META['snp_s3button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s3header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-3 .snp-h2 {font-size: '.$POPUP_META['snp_s3header_font']['size'].'px; color: '.$POPUP_META['snp_s3header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_s3subheader_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-newtheme7 .snp-step-3 .snp-h1 { font-size: '.$POPUP_META['snp_s3subheader_font']['size'].'px; color: '.$POPUP_META['snp_s3subheader_font']['color'].';}'."\n";
}
echo '</style>';
