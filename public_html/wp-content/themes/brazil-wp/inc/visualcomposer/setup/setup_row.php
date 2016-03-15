<?php


if ( class_exists( 'WPBakeryVisualComposerAbstract') ) {
	
	if(!function_exists('webnus_setup_vc_row')){
		
		function webnus_setup_vc_row(){
			
			vc_remove_param('vc_row', 'full_width');
			vc_remove_param('vc_row', 'font_color');
			vc_remove_param('vc_row', 'el_class');
			vc_remove_param('vc_row', 'css');
			
			
			
						
			
			$attributes = array(
							      "type" => "dropdown",
							      "heading" => __("Select Row Type", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "row_type",
							      "description" => __("Select row types available in theme, [row,blox,blox_dark,parallax,video background] are available", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>array("Default"=>'0',"FullWidth Row"=>"1", "Blox"=>"2" , "Parallax"=>"3", "ProcessBox"=>"4", "Video Background"=>'5' , "MaxSlider"=>'6')
   						 );			
			vc_add_param('vc_row',$attributes);
			
			$attributes = array(
							      "type" => "textfield",
							      "heading" => __("Row ID", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "row_id",
							      "description" => __("Enter the row ID", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>''
   						 );			
			vc_add_param('vc_row',$attributes);
			
			$attributes = array(
							      "type" => "textfield",
							      "heading" => __("Height", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_height",
							      "description" => __("Select blox Height in number format Example: 380", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>"",
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3','5'))
							   	);			
			vc_add_param('vc_row',$attributes);

			$attributes = array(
								"type"=>'dropdown',
								"heading"=>__('Full screen video', 'WEBNUS_TEXT_DOMAIN'),
								"param_name"=> "video_fullscreen",
								"value"=>array('Yes'=>'true','No'=>'false'),
								"description" => __( "Is video full screen?", 'WEBNUS_TEXT_DOMAIN'),
								"dependency"=>array('element'=>'row_type','value'=>array('5'))
							   	);			
			vc_add_param('vc_row',$attributes);

			
			$attributes = array(
							      "type" => "attach_image",
							      "heading" => __("Background Image", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_image",
							      "description" => __("Select background image URL", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>"",
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3'))
							   );			
			vc_add_param('vc_row',$attributes);
			
			$attributes = array(
							      "type" => "dropdown",
							      "heading" => __("Background Attachment", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_bg_attachment",
							      "description" => __("Select Background Attachment?", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>array( 'Scroll'=>'false','Fixed'=>'true'),
								  "dependency"=>array('element'=>'row_type','value'=>array('2'))
							   );			
			vc_add_param('vc_row',$attributes);
						
			$attributes = array(
							      "type" => "dropdown",
							      "heading" => __("Background Cover?", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_cover",
							      "description" => __("Blox has cover background?", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>array('True'=>'true', 'False'=>'false'),
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3'))
							   );			
			vc_add_param('vc_row',$attributes);
				
			$attributes = array(
							     "type" => "dropdown",
							      "heading" => __("Background Repeat?", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_repeat",
							      "description" => __("Is Background image repeated?", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>array( 'No Repeat'=>'no-repeat','Repeat'=>'repeat'),
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3'))
							   );			
			vc_add_param('vc_row',$attributes);
			
			$attributes = array(
							      "type" => "checkbox",
							      "heading" => __("Align Center?", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "align_center",
							      "description" => __("Align center content", "WEBNUS_TEXT_DOMAIN"),
								  'value' => array( __( 'Yes', 'js_composer' ) => 'aligncenter' ),
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3','5'))
							   );	
			vc_add_param('vc_row',$attributes);	
							   
			$attributes = array(
							      "type" => "checkbox",
							      "heading" => __("Used as Page Title?", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "page_title",
							      "description" => __("Remove gap between header and this section", "WEBNUS_TEXT_DOMAIN"),
								  'value' => array( __( 'Yes', 'js_composer' ) => 'page-title-x' ),
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3','5'))
							   );			
			vc_add_param('vc_row',$attributes);			
			
			
			
			$attributes = array(
							      "type" => "textfield",
							      "heading" => __("Padding Top", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_padding_top",
							      "description" => __("Blox Top Padding in px format", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>'',
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3','5'))
							   );			
			vc_add_param('vc_row',$attributes);
						
			$attributes = array(
							     "type" => "textfield",
							      "heading" => __("Padding Bottom", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_padding_bottom",
							      "description" => __("Blox Bottom Padding in px format", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>'',
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3','5'))
							   );			
			vc_add_param('vc_row',$attributes);
			
			
			
			$attributes = array(
							     "type" => "dropdown",
							      "heading" => __("Dark or Light?", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_dark",
							      "description" => __("If you choose Dark, Background Color goes dark and Text Color goes light<br/>If you choose Light, Background Color goes Light and Text Color goes dark", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>array( 'Light'=>'false','Dark'=>'true'),
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3','5'))
							   );			
			vc_add_param('vc_row',$attributes);
			
			$attributes = array(
							      "type" => "textfield",
							      "heading" => __("Extra Class", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_class",
							      "description" => __("Predefined colors are greenbox,redbox,bluebox,yellowbox,gray. To use custom color please use below Cutom Background Color", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>"",
								  "dependency"=>array('element'=>'row_type','value'=>array('2','3','5'))
							   );			
			vc_add_param('vc_row',$attributes);
			

			

			$attributes = array(
							     "type" => "colorpicker",
							      "heading" => __("Background Color", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "blox_bgcolor",
							      "description" => __("Select Custom Background color", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>'',
								  "dependency"=>array('element'=>'row_type','value'=>array('2'))
							   );			
			vc_add_param('vc_row',$attributes);			
			
			$attributes = array(
							     "type" => "textfield",
							      "heading" => __("Speed(Parallax)", "WEBNUS_TEXT_DOMAIN"),
							      "param_name" => "parallax_speed",
							      "description" => __("Select Parallax scroll speed in number format Example: 6", "WEBNUS_TEXT_DOMAIN"),
								  "value"=>"6",
								  "dependency"=>array('element'=>'row_type','value'=>array('3'))
							   );			
			vc_add_param('vc_row',$attributes);			
			
			$attributes = array(
									"type"=>'textfield',
									"heading"=>__('Title', 'WEBNUS_TEXT_DOMAIN'),
									"param_name"=> "process_title",
									"value"=>"",
									"description" => __( "ProcessBox Title", 'WEBNUS_TEXT_DOMAIN'),
									"dependency"=>array('element'=>'row_type','value'=>array('4'))
							   );			
			vc_add_param('vc_row',$attributes);			
							
			$attributes = array(
									"type"=>'textfield',
									"heading"=>__('Subtitle', 'WEBNUS_TEXT_DOMAIN'),
									"param_name"=> "process_subtitle",
									"value"=>"",
									"description" => __( "ProcessBox Subtitle", 'WEBNUS_TEXT_DOMAIN'),
									"dependency"=>array('element'=>'row_type','value'=>array('4'))
									   );			
			vc_add_param('vc_row',$attributes);			
			
			$attributes = array(
									"type"=>'dropdown',
									"heading"=>__('Process Count', 'WEBNUS_TEXT_DOMAIN'),
									"param_name"=> "process_count",
									"value"=>array("3"=>"3","4"=>"4", "5"=>"5"),
									"description" => __( "How many process items in process box?", 'WEBNUS_TEXT_DOMAIN'),
									"dependency"=>array('element'=>'row_type','value'=>array('4'))
									   );			
			vc_add_param('vc_row',$attributes);			
						
			$attributes = array(
							        "type" => "iconfonts",
							        "heading" => __( "Top Icon", 'WEBNUS_TEXT_DOMAIN' ),
							        "param_name" => "process_icon",
							        'value'=>'',
							        "description" => __( "Select ProcessBox Top Icon", 'WEBNUS_TEXT_DOMAIN'),
							        "dependency"=>array('element'=>'row_type','value'=>array('4'))
									   );			
			vc_add_param('vc_row',$attributes);			
						
			$attributes = array(
									"type"=>'textfield',
									"heading"=>__('Video URL', 'WEBNUS_TEXT_DOMAIN'),
									"param_name"=> "video_url",
									"value"=>'',
									"description" => __( "Background video URL (full path with http://)", 'WEBNUS_TEXT_DOMAIN'),
									"dependency"=>array('element'=>'row_type','value'=>array('5'))
									   );			
			vc_add_param('vc_row',$attributes);			
			
			$attributes = array(
									"type"=>'dropdown',
									"heading"=>__('Video Type', 'WEBNUS_TEXT_DOMAIN'),
									"param_name"=> "video_type",
									"value"=>array('Youtube'=>'video/youtube','Vimeo'=>'video/vimeo','MP4'=>'video/mp4','WebM'=>'video/webm','Ogg'=>'video/ogg'),
									"description" => __( "Background video URL (full path with http://)", 'WEBNUS_TEXT_DOMAIN'),
									"dependency"=>array('element'=>'row_type','value'=>array('5'))
									   );			
			vc_add_param('vc_row',$attributes);			
						
			$attributes = array(
									"type"=>'dropdown',
									"heading"=>__('Pattern', 'WEBNUS_TEXT_DOMAIN'),
									"param_name"=> "video_pattern",
									"value"=>array('Enable'=>'true','Disable'=>'false'),
									"description" => __( "Display Foreground dotted Pattern", 'WEBNUS_TEXT_DOMAIN'),
									"dependency"=>array('element'=>'row_type','value'=>array('5'))
										   );			
			vc_add_param('vc_row',$attributes);			
						
					

			
			
			$attributes = array(
				"type"=>'dropdown',
				"heading"=>__('Overlay pattern', 'WEBNUS_TEXT_DOMAIN'),
				"param_name"=> "row_pattern",
				"value"=>array('No Pattern'=>'','Pattern 1'=>'max-pat','Pattern 2'=> 'max-pat2'),
				"description" => __( "Overlay Pattern for [blox,parallax]", 'WEBNUS_TEXT_DOMAIN'),
				"dependency"=>array('element'=>'row_type','value'=>array('2','3'))
				
			);
			vc_add_param('vc_row',$attributes);		
			$attributes = array(
				"type"=>'colorpicker',
				"heading"=>__('Overlay color', 'WEBNUS_TEXT_DOMAIN'),
				"param_name"=> "row_color",
				"value"=>'',
				"description" => __( "Overlay Color  for [blox,parallax]", 'WEBNUS_TEXT_DOMAIN'),
				"dependency"=>array('element'=>'row_type','value'=>array('2','3'))
				
			);
			vc_add_param('vc_row',$attributes);				
			
			/*
			 * max slider
			 */			
			
			$attributes =	array(
				      "type" => "attach_image",
				      "heading" => __("Slide 1", "WEBNUS_TEXT_DOMAIN"),
				      "param_name" => "maxslider_image1",
				      "description" => __("Select Slide 1 Image", "WEBNUS_TEXT_DOMAIN"),
					  "value"=>"",
					  "dependency"=>array('element'=>'row_type','value'=>array('6'))
			    );
			vc_add_param('vc_row',$attributes);
			$attributes =	array(
		      "type" => "attach_image",
		      "heading" => __("Slide 2", "WEBNUS_TEXT_DOMAIN"),
		      "param_name" => "maxslider_image2",
		      "description" => __("Select Slide 2 Image", "WEBNUS_TEXT_DOMAIN"),
			  "value"=>"",
			  "dependency"=>array('element'=>'row_type','value'=>array('6'))
		    );
		    vc_add_param('vc_row',$attributes);
			$attributes =	array(
		      "type" => "attach_image",
		      "heading" => __("Slide 3", "WEBNUS_TEXT_DOMAIN"),
		      "param_name" => "maxslider_image3",
		      "description" => __("Select Slide 3 Image", "WEBNUS_TEXT_DOMAIN"),
			  "value"=>"",
			  "dependency"=>array('element'=>'row_type','value'=>array('6'))
		    );
		    vc_add_param('vc_row',$attributes);
			$attributes =	array(
		      "type" => "attach_image",
		      "heading" => __("Slide 4", "WEBNUS_TEXT_DOMAIN"),
		      "param_name" => "maxslider_image4",
		      "description" => __("Select Slide 4 Image", "WEBNUS_TEXT_DOMAIN"),
			  "value"=>"",
			  "dependency"=>array('element'=>'row_type','value'=>array('6'))
		    );
		    vc_add_param('vc_row',$attributes);
			$attributes =	array(
		      "type" => "attach_image",
		      "heading" => __("Slide 5", "WEBNUS_TEXT_DOMAIN"),
		      "param_name" => "maxslider_image5",
		      "description" => __("Select Slide 5 Image", "WEBNUS_TEXT_DOMAIN"),
			  "value"=>"",
			  "dependency"=>array('element'=>'row_type','value'=>array('6'))
		    );
			vc_add_param('vc_row',$attributes);
			$attributes =	array(
				"type"=>'dropdown',
				"heading"=>__('Parallax Images', 'WEBNUS_TEXT_DOMAIN'),
				"param_name"=> "maxslider_parallax",
				"value"=>array('Yes'=>'true','No'=>'false'),
				"description" => __( "Parallax images for maxslider", 'WEBNUS_TEXT_DOMAIN'),
				"dependency"=>array('element'=>'row_type','value'=>array('6'))
				
			);
			vc_add_param('vc_row',$attributes);
			$attributes =	array(
				"type"=>'dropdown',
				"heading"=>__('Pattern Images', 'WEBNUS_TEXT_DOMAIN'),
				"param_name"=> "maxslider_pattern",
				"value"=>array('Yes'=>'true','No'=>'false'),
				"description" => __( "Pattern images for maxslider", 'WEBNUS_TEXT_DOMAIN'),
				"dependency"=>array('element'=>'row_type','value'=>array('6'))
				
			);
			vc_add_param('vc_row',$attributes);			
						
		}// END OF FUNCTION
		
	}
	
	add_action('admin_init', 'webnus_setup_vc_row');
	
} // End of if statement


?>