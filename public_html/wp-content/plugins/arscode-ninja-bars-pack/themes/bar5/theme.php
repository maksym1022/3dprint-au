<?php

function snp_enqueue_bar5($POPUP_META)
{
    $POPUP_META['snp_header_font']	 = unserialize($POPUP_META['snp_header_font']);
    $POPUP_META['snp_maintext_font']	 = unserialize($POPUP_META['snp_maintext_font']);
    $GoogleFonts			 = snp_get_fonts('google');
    $Fonts				 = array($POPUP_META['snp_header_font']['font'], $POPUP_META['snp_maintext_font']['font']);
    foreach ($Fonts as $v)
    {
	if (in_array($v, $GoogleFonts))
	{
	    $protocol = is_ssl() ? 'https' : 'http';
	    $query_args = array(
		    'family' => urlencode($v).':400italic,700italic,400,700'
	    );
	    wp_enqueue_style( 'snp-f-' . urlencode($v), snp_add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
    }
}

$SNP_THEMES_bar5_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_bar5_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['bar5']		 = array(
    'NAME'	 => 'Bar 5',
    'STYLES' => 'style.css',
    'OPEN_FUNCTION' => 'snp_bar5_open',
    'CLOSE_FUNCION' => 'snp_bar5_close',
    'TYPES'	 => array(
	'optin' => array('NAME'	 => 'Opt-in')
    ),
    'COLORS' => array(
	'multicolors' => array('NAME'	 => 'Multicolors')
    ),
    'FIELDS' => array(
	array(
	    'id'	 => 'width',
	    'type'	 => 'text',
	    'title'	 => __('Content Width', 'nhp-opts'),
	    'desc'	 => __('px (default: 960)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '960'
	),
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
	    'std'	 => '#fff',
	    'desc'	 => __('(default: #fff)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'img',
	    'type'	 => 'upload',
	    'title'	 => __('Image', 'nhp-opts'),
	),
	array(
	    'id'	 => 'img_top',
	    'type'	 => 'text',
	    'title'	 => __('Image Position Top', 'nhp-opts'),
	    'desc'	 => __('px (default: -25px)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '-25'
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
	    'desc'	 => __('px (default: 23px, #32861E)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar5_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Open Sans','size'	 => '23', 'color'	 => '#32861E'),
	),
	array(
	    'id'	 => 'maintext',
	    'type'	 => 'textarea',
	    'title'	 => __('Main Text', 'nhp-opts'),
	),
	array(
	    'id'	 => 'maintext_font',
	    'type'	 => 'typo',
	    'title'	 => __('Main Text Font Size', 'nhp-opts'),
	    'desc'	 => __('px (default: 14px, #4D627F)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar5_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Open Sans','size'	 => '14', 'color'	 => '#4D627F'),
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
	    'id'	 => 'submit_button_color',
	    'type'	 => 'color_gradient',
	    'std'	 => array('from' => '#249d47', 'to' => '#32871f'),
	    'desc'	 => __('(default: from #249d47 to #32871f)', 'nhp-opts'),
	    'title'	 => __('Submit Button Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_border_color',
	    'type'	 => 'color',
	    'std'	 => '#006f00',
	    'desc'	 => __('(default: #006f00)', 'nhp-opts'),
	    'title'	 => __('Submit Button Border Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_text_color',
	    'type'	 => 'color',
	    'std'	 => '#fff',
	    'desc'	 => __('(default: #fff)', 'nhp-opts'),
	    'title'	 => __('Submit Button Text Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'security_note',
	    'type'	 => 'text',
	    'title'	 => __('Security Note', 'nhp-opts'),
	),
    )
);
?>