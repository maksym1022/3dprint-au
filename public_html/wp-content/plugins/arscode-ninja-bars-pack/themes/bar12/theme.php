<?php

function snp_enqueue_bar12($POPUP_META)
{
    $POPUP_META['snp_header_font']	 = unserialize($POPUP_META['snp_header_font']);
    $GoogleFonts			 = snp_get_fonts('google');
    $Fonts				 = array($POPUP_META['snp_header_font']['font']);
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

$SNP_THEMES_bar12_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_bar12_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['bar12']		 = array(
    'NAME'	 => 'Bar 12',
    'STYLES' => 'style.css',
    'OPEN_FUNCTION' => 'snp_bar12_open',
    'CLOSE_FUNCION' => 'snp_bar12_close',
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
	    'type'	 => 'color',
	    'std'	 => '#3C4ED3',
	    'desc'	 => __('(default: #3C4ED3)', 'nhp-opts'),
	    'title'	 => __('Top Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'bg_color2',
	    'type'	 => 'color',
	    'std'	 => '#1D2124',
	    'desc'	 => __('(default: #1D2124)', 'nhp-opts'),
	    'title'	 => __('Footer Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header',
	    'type'	 => 'text',
	    'title'	 => __('Header (Top)', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header_font',
	    'type'	 => 'typo',
	    'title'	 => __('Header Font', 'nhp-opts'),
	    'desc'	 => __('px (default: 18px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar12_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Open Sans','size'	 => '18', 'color'	 => '#fff'),
	),
	array(
	    'id'	 => 'header2',
	    'type'	 => 'text',
	    'title'	 => __('Header 2 (Left)', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header2_font',
	    'type'	 => 'typo',
	    'title'	 => __('Header 2 (Left) Font', 'nhp-opts'),
	    'desc'	 => __('px (default: 40x, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar12_SIZES,
		'fonts'	 => snp_get_fonts(),
		'disable_fonts'	=>  1
	    ),
	    'std'		 => array('size'	 => '40', 'color'	 => '#fff'),
	),
	array(
	    'id'	 => 'bulletlist',
	    'type'	 => 'multi_text',
	    'title'	 => __('Bullet List', 'nhp-opts'),
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
	    'id'	 => 'submit_button_color',
	    'type'	 => 'color',
	    'std'	 => '#121416',
	    'desc'	 => __('(default: #121416)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_text',
	    'type'	 => 'typo',
	    'title'	 => __('Submit Button Text', 'nhp-opts'),
	    'desc'	 => __('px (default: 11px, #8c8e8f)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar12_SIZES,
		'fonts'	 => snp_get_fonts(),
		'disable_fonts'	=>  1
	    ),
	    'std'		 => array('size'	 => '11', 'color'	 => '#8c8e8f'),
	),
    )
);
?>