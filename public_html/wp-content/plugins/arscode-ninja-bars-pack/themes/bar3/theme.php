<?php

function snp_enqueue_bar3($POPUP_META)
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

$SNP_THEMES_bar3_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_bar3_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['bar3']		 = array(
    'NAME'	 => 'Bar 3',
    'STYLES' => 'style.css',
    'OPEN_FUNCTION' => 'snp_bar3_open',
    'CLOSE_FUNCION' => 'snp_bar3_close',
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
	    'id'		 => 'bg_image',
	    'type'		 => 'radio_img',
	    'title'		 => __('Background Image', 'nhp-opts'),
	    'sub_desc'	 => '',
	    'desc'		 => '',
	    'options'	 => array(
		'disabled' => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bgdisabled.jpg'),
		'bg1'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg1m.png'),
		'bg2'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg2m.png'),
		'bg3'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg3m.png'),
		'bg4'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg4m.png'),
		'bg5'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg5m.png'),
		'bg6'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg6m.png'),
		'bg7'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg7m.png'),
		'bg8'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bg8m.png'),
		'uploaded'	 => array('title'	 => '', 'img'	 => SNP_BAR_URL . 'themes/bar3/gfx/bguploaded.jpg'),
	    ),
	    'std'	 => 'bg6'
	),
	array(
	    'id'	 => 'bg_image_upload',
	    'type'	 => 'upload',
	    'title'	 => __('Background Image - Upload', 'nhp-opts'),
	),
	array(
	    'id'	 => 'bg_gradient',
	    'type'	 => 'color_gradient',
	    'title'	 => __('Background Color - Gradient', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 24px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar3_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Open Sans','size'	 => '24', 'color'	 => '#fff'),
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
	    'desc'	 => __('px (default: 14px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_bar3_SIZES,
		'fonts'	 => snp_get_fonts(),
	    ),
	    'std'		 => array('font'	 => 'Open Sans','size'	 => '14', 'color'	 => '#fff'),
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
	    'std'	 => array('from' => '#51a8bb', 'to' => '#326e90'),
	    'desc'	 => __('(default: from #51a8bb to #326e90)', 'nhp-opts'),
	    'title'	 => __('Submit Button Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_border_color',
	    'type'	 => 'color',
	    'std'	 => '#265d72',
	    'desc'	 => __('(default: #265d72)', 'nhp-opts'),
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