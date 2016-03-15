<?php

function snp_enqueue_bar11($POPUP_META)
{
    $POPUP_META['snp_header_font']	 = unserialize($POPUP_META['snp_header_font']);
    $POPUP_META['snp_subheader_font']	 = unserialize($POPUP_META['snp_subheader_font']);
    $GoogleFonts			 = snp_get_fonts('google');
    $Fonts				 = array($POPUP_META['snp_header_font']['font'], $POPUP_META['snp_subheader_font']['font']);
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

$SNP_THEMES_bar11_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_bar11_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['bar11']		 = array(
    'NAME'	 => 'Bar 11',
    'STYLES' => 'style.css',
    'OPEN_FUNCTION' => 'snp_bar11_open',
    'CLOSE_FUNCION' => 'snp_bar11_close',
    'TYPES'	 => array(
	'optin' => array('NAME'	 => 'Opt-in')
    ),
    'COLORS' => array(
	'multicolors' => array('NAME'	 => 'Multicolors')
    ),
    'FIELDS' => array(
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
	    'std'	 => '#081B33',
	    'desc'	 => __('(default: #081B33)', 'nhp-opts'),
	    'title'	 => __('Header Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'bg_color2',
	    'type'	 => 'color',
	    'std'	 => '#062855',
	    'desc'	 => __('(default: #062855)', 'nhp-opts'),
	    'title'	 => __('Footer Background Color', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 28px, #dadde1)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar11_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Marcellus', 'size'	 => '28', 'color'	 => '#dadde1'),
	),
	array(
	    'id'	 => 'subheader',
	    'type'	 => 'text',
	    'title'	 => __('Sub Header', 'nhp-opts'),
	),
	array(
	    'id'	 => 'subheader_font',
	    'type'	 => 'typo',
	    'title'	 => __('Sub Header Font', 'nhp-opts'),
	    'desc'	 => __('px (default: 10px, #636f7e)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar11_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Open Sans', 'size'	 => '10', 'color'	 => '#636f7e'),
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
	    'std'	 => array('from' => '#eaebee', 'to' => '#babec7'),
	    'desc'	 => __('(default: from #eaebee to #babec7)', 'nhp-opts'),
	    'title'	 => __('Submit Button Background Color', 'nhp-opts'),
	),
    )
);
?>