<?php

function snp_enqueue_bar10($POPUP_META)
{
    $POPUP_META['snp_header_font']	 = unserialize($POPUP_META['snp_header_font']);
    $POPUP_META['snp_submit_button_text']	 = unserialize($POPUP_META['snp_submit_button_text']);
    $GoogleFonts			 = snp_get_fonts('google');
    $Fonts				 = array($POPUP_META['snp_header_font']['font'], $POPUP_META['snp_submit_button_text']['font']);
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

$SNP_THEMES_bar10_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_bar10_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['bar10']		 = array(
    'NAME'	 => 'Bar 10',
    'STYLES' => 'style.css',
    'OPEN_FUNCTION' => 'snp_bar10_open',
    'CLOSE_FUNCION' => 'snp_bar10_close',
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
	    'std'	 => '#252736',
	    'desc'	 => __('(default: #252736)', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 26px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar10_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Georgia', 'size'	 => '26', 'color'	 => '#fff'),
	),
	array(
	    'id'	 => 'subheader',
	    'type'	 => 'text',
	    'title'	 => __('Sub Header', 'nhp-opts'),
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
	    'id'	 => 'submit_button_text',
	    'type'	 => 'typo',
	    'title'	 => __('Submit Button Text', 'nhp-opts'),
	    'desc'	 => __('px (default: 11px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar10_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Open Sans','size'	 => '11', 'color'	 => '#fff'),
	),
	array(
	    'id'	 => 'submit_button_border_color',
	    'type'	 => 'color',
	    'std'	 => '#40414e',
	    'desc'	 => __('(default: #40414e)', 'nhp-opts'),
	    'title'	 => __('Submit Button Border Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'input_bg_color',
	    'type'	 => 'color',
	    'std'	 => '#1a1a26',
	    'desc'	 => __('(default: #1a1a26)', 'nhp-opts'),
	    'title'	 => __('Input Fields Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'input_text_color',
	    'type'	 => 'color',
	    'std'	 => '#818188',
	    'desc'	 => __('(default: #818188)', 'nhp-opts'),
	    'title'	 => __('Input Fields Text Color', 'nhp-opts'),
	)
    )
);
?>