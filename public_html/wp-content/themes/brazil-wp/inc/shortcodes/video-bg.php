<?php 
function  webnus_videorow_shortcode($attributes, $content)
{


    extract(
            shortcode_atts(
                    array(  
                        "img" => '',
                        "height" => '',
                        'padding_top'  => 0,
                        'padding_bottom'  => 0,
						'dark'=>'false',
						'class'=>'',
						'video_url'=>'',
						'video_fullscreen'=>'false',
						'video_pattern'=>'true',
						'video_type'=>'video/webm',			
						'id'=>''
                         )
            , $attributes));
			
	$bg_height = !empty($height)?$height:'380';
	
	$height_style = " min-height:{$bg_height}px !important ";
	
	$padding_style= " padding-top:{$padding_top}; padding-bottom:{$padding_bottom}; ";
    
	$is_dark = ( 'true' == $dark )? ' dark ' : '';
	


	if(!empty($id))
    $out = '</div></section><section id="'.$id.'"  class="video-sec ';
	else
	$out = '</div></section><section  class="video-sec ';
	if( 'true' == $video_fullscreen )
	$out .= 'max-hero ';
	$out .= $class .'" style="'.$padding_style.$height_style.'"><div class="wpb_row vc_row-fluid full-row"><div class="';
	if( 'true' == $video_pattern )
	$out .= 'spattern ';
	if( 'true' == $video_fullscreen )
	$out .= 'max-video';
	$out .= '"><video ';
	if( 'false' == $video_fullscreen )
	$out .= 'class="video-item" ';
	if( 'true' == $video_fullscreen )
	$out .= 'width="100%" height="100%" ';
 	$out .= 'loop autoplay >';
	$out .= '<source type="'.$video_type.'" src="'.$video_url;
	if( 'video/vimeo' == $video_type )
	$out .= '?api=1&title=0&byline=0&portrait=0&playbar=0&loop=1&autoplay=1';
	$out .= '"></source>';
	$out .= 'Your browser does not support the video tag. I suggest you upgrade your browser.</video>';

    $out .= '<article class="';
	if( 'true' == $video_fullscreen )
		$out .= 'slides-content ';
	elseif( 'true' == $dark )
		$out .= 'dark-content ';
	elseif( 'true' == $light )
		$out .= 'light-content ';
    $out .= '"><div class="container">';	
    $out .= do_shortcode($content);
    $out .= '</div></article>'; 
    $out .= '</div></div></section><section class="container"><div class="row-wrapper-x">';
	
    return $out;
}
add_shortcode("videorow", 'webnus_videorow_shortcode');
?>