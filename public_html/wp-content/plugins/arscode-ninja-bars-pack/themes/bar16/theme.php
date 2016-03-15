<?php

function snp_enqueue_bar16($POPUP_META)
{
    $POPUP_META['snp_header_font']	 = unserialize($POPUP_META['snp_header_font']);
    $POPUP_META['snp_submit_button_text']	 = unserialize($POPUP_META['snp_submit_button_text']);
    $GoogleFonts			 = snp_get_fonts('google');
    $Fonts				 = array($POPUP_META['snp_header_font']['font'],$POPUP_META['snp_submit_button_text']['font']);
    foreach ($Fonts as $v)
    {
	if (in_array($v, $GoogleFonts))
	{
	    $protocol = is_ssl() ? 'https' : 'http';
	    $query_args = array(
		    'family' => urlencode($v).':400italic,700italic,400,600,700,800'
	    );
	    wp_enqueue_style( 'snp-f-' . urlencode($v), snp_add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
    }
}

$SNP_THEMES_bar16_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_bar16_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['bar16']		 = array(
    'NAME'	 => 'Bar 16',
    'STYLES' => 'style.css',
    'OPEN_FUNCTION' => 'snp_bar16_open',
    'CLOSE_FUNCION' => 'snp_bar16_close',
    'TYPES'	 => array(
	'optin' => array('NAME'	 => 'Opt-in')
    ),
    'COLORS' => array(
	'multicolors' => array('NAME'	 => 'Multicolors')
    ),
    'FIELDS' => array(
	array(
	    'id'	 => 'height',
	    'type'	 => 'text',
	    'title'	 => __('Height', 'nhp-opts'),
	    'desc'	 => __('px (optional, leave empty for auto-height)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => ''
	),
	array(
	    'id'		 => 'position',
	    'type'		 => 'radio',
	    'title'		 => __('Position', 'nhp-opts'),
	    'options'	 => array('snp-pos-top'	 => 'Top', 'snp-pos-bottom'	 => 'Bottom'),
	    'std'	 => 'snp-pos-bottom'
	),
	array(
	    'id'		 => 'open_effect',
	    'type'		 => 'radio',
	    'title'		 => __('Open Effect', 'nhp-opts'),
	    'options'	 => array('snp-ani-slide'	 => 'Slide In', 'snp-ani-fade'	 => 'Fade In'),
	    'std'	 => 'snp-ani-slide'
	),
	array(
	    'id'	 => 'bg_color1',
	    'type'	 => 'color_gradient',
	    'std'	 => array('from' => '#ffffff','to' => '#c9c9c9'),
	    'desc'	 => __('(default from: #ffffff to #c9c9c9)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header',
	    'type'	 => 'text',
	    'title'	 => __('Header', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header_font',
	    'type'	 => 'typo',
	    'title'	 => __('Header Font', 'nhp-opts'),
	    'desc'	 => __('px (default: 26px, #1b2a7f)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar16_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Arial','size'	 => '26', 'color'	 => '#1b2a7f'),
	),
	array(
	    'id'	 => 'bulletlist',
	    'type'	 => 'multi_text',
	    'title'	 => __('Bullet List', 'nhp-opts'),
	),
	array(
	    'id'	 => 'maintext',
	    'type'	 => 'textarea',
	    'title'	 => __('Main Text', 'nhp-opts'),
	),
	array(
	    'id'	 => 'name_placeholder',
	    'type'	 => 'text',
	    'std'	 => 'Your Name...',
	    'title'	 => __('Name Placeholder', 'nhp-opts'),
	),
	array(
	    'id'		 => 'name_disable',
	    'type'		 => 'radio',
	    'title'		 => __('Disable Name Field', 'nhp-opts'),
	    'options'	 => array(0	 => 'No', 1	 => 'Yes'),
	    'std'	 => 0
	),
	array(
	    'id'	 => 'email_placeholder',
	    'type'	 => 'text',
	    'std'	 => 'Your E-mail...',
	    'title'	 => __('E-mail Placeholder', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button',
	    'type'	 => 'text',
	    'std'	 => 'Subscribe Now!',
	    'title'	 => __('Submit Button', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_loading',
	    'type'	 => 'text',
	    'std'	 => '',
	    'title'	 => __('Submit Button Loading Text', 'nhp-opts'),
	    'desc'	 => __('(ex: Please wait...)', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_success',
	    'type'	 => 'text',
	    'std'	 => '',
	    'title'	 => __('Submit Button Success Text', 'nhp-opts'),
	    'desc'	 => __('(ex: Thank You!)', 'nhp-opts'),
	),
	array(
	    'id'	 => 'security_note',
	    'type'	 => 'text',
	    'title'	 => __('Security Note', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_color',
	    'type'	 => 'color_gradient',
	    'std'	 => array('from' => '#fef030','to' => '#fdbe01'),
	    'desc'	 => __('(default: #fef030 to #fdbe01)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_text',
	    'type'	 => 'typo',
	    'title'	 => __('Submit Button Text', 'nhp-opts'),
	    'desc'	 => __('px (default: 24px, #1b2a7f)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar16_SIZES,
		'fonts'	 => snp_get_fonts()	    ),
	    'std'		 => array('font' => 'Lato','size'	 => '24', 'color'	 => '#8c8e8f'),
	),
	array(
	    'id'	 => 'click_img',
	    'type'	 => 'upload',
	    'title'	 => __('Overwrite "Click it Now!"Image', 'nhp-opts'),
	),
    )
);
?>