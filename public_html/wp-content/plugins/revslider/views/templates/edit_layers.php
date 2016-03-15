
	<div class="edit_slide_wrapper<?php echo ($slide->isStaticSlide()) ? ' rev_static_layers' : ''; ?>">
		<?php
		if(!$slide->isStaticSlide()){
			?>
			<div class="editor_buttons_wrapper  postbox unite-postbox" style="max-width:100% !important;">
				<h3 class="box-closed tp-accordion">
					<span class="postbox-arrow2">-</span><span><?php _e("Slider Main Image / Background",REVSLIDER_TEXTDOMAIN) ?></span>
				</h3>
				<div class="toggled-content">
					<div class="inner_wrapper p10 pb0 pt0 boxsized">
						<div class="editor_buttons_wrapper_top">
							<h3 style="cursor:default !important; background:none !important;border:none;box-shadow:none !important;font-size:12px;padding:0px;margin:10px 0px 0px;"><?php _e("Background Source:",REVSLIDER_TEXTDOMAIN)?></h3>


							<!-- IMAGE FROM MEDIAGALLERY -->
							<input style="float:left" type="radio" name="radio_bgtype" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="image" id="radio_back_image" <?php if($bgType == "image") echo 'checked="checked"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"  for="radio_back_image"><?php _e("Image BG",REVSLIDER_TEXTDOMAIN)?></label>
							<!-- THE BG IMAGE CHANGED DIV -->
							<div id="tp-bgimagewpsrc" class="bgsrcchanger-div" style="display:none;float:left;margin-top:-7px;">
								<a href="javascript:void(0)" id="button_change_image" class="button-primary revblue <?php if($bgType != "image") echo "button-disabled" ?>" style="margin-bottom:5px"><?php _e("Change Image",REVSLIDER_TEXTDOMAIN)?></a>
							</div>


							<!-- IMAGE FROM EXTERNAL -->
							<input type="radio" name="radio_bgtype" style="float:left;margin-left:15px;" data-callid="tp-bgimageextsrc" data-imgsettings="on" class="bgsrcchanger" data-bgtype="external" id="radio_back_external" <?php if($bgType == "external") echo 'checked="solid"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"for="radio_back_external"><?php _e("External URL",REVSLIDER_TEXTDOMAIN)?></label>
							<!-- THE BG IMAGE FROM EXTERNAL SOURCE -->
							<div id="tp-bgimageextsrc" class="bgsrcchanger-div" style="display:none;float:left;margin-top:-7px;">
								<input type="text" name="bg_external" id="slide_bg_external" value="<?php echo $slideBGExternal?>" <?php echo ($bgType != 'external') ? ' class="disabled"' : ''; ?>>
								<a href="javascript:void(0)" id="button_change_external" class="button-primary revblue <?php if($bgType != "external") echo "button-disabled" ?>" style="margin-bottom:5px"><?php _e("Get External",REVSLIDER_TEXTDOMAIN)?></a>
							</div>


							<!-- TRANSPARENT BACKGROUND -->
							<input type="radio" name="radio_bgtype" style="float:left;margin-left:15px;" data-callid="" class="bgsrcchanger" data-bgtype="trans" id="radio_back_trans" <?php if($bgType == "trans") echo 'checked="checked"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"for="radio_back_trans"><?php _e("Transparent",REVSLIDER_TEXTDOMAIN)?></label>


							<!-- COLORED BACKGROUND -->
							<input type="radio" name="radio_bgtype" style="float:left;margin-left:15px;" data-callid="tp-bgcolorsrc" class="bgsrcchanger" data-bgtype="solid" id="radio_back_solid" <?php if($bgType == "solid") echo 'checked="solid"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"for="radio_back_solid"><?php _e("Solid Colored",REVSLIDER_TEXTDOMAIN)?></label>

							<!-- THE COLOR SELECTOR -->
							<div id="tp-bgcolorsrc"  class="bgsrcchanger-div"  style="display:none;float:left;margin-top:-5px;">
								<input type="text" name="bg_color" id="slide_bg_color" <?php echo $bgSolidPickerProps?> value="<?php echo $slideBGColor?>">
							</div>

							<!--<a href="javascript:void(0)" id="button_preview_slide" class="button-primary revbluedark" style="float:right;margin-top:-9px !important;" title="Preview Slide"><i class="revicon-search-1"></i><?php _e("Preview Slide",REVSLIDER_TEXTDOMAIN)?></a>
	-->
							<div style="clear:both"></div>

							<!-- PREVIEW BUTTON -->

							<!-- THE BG IMAGE SETTINGS -->
							<div id="tp-bgimagesettings" class="bgsrcchanger-div" style="margin-top:10px;display:none">
								<div id="bg-setting-wrap">
									<h3 style="cursor:default !important; background:none !important;border:none;box-shadow:none !important;font-size:12px;padding:0px;margin:17px 0px 0px;"><?php _e("Background Settings:",REVSLIDER_TEXTDOMAIN)?></h3>
									<label for="slide_bg_fit"><?php _e("Background Fit:",REVSLIDER_TEXTDOMAIN)?></label>
									<select name="bg_fit" id="slide_bg_fit" style="margin-right:20px">
										<option value="cover"<?php if($bgFit == 'cover') echo ' selected="selected"'; ?>>cover</option>
										<option value="contain"<?php if($bgFit == 'contain') echo ' selected="selected"'; ?>>contain</option>
										<option value="percentage"<?php if($bgFit == 'percentage') echo ' selected="selected"'; ?>>(%, %)</option>
										<option value="normal"<?php if($bgFit == 'normal') echo ' selected="selected"'; ?>>normal</option>
									</select>
									<input type="text" name="bg_fit_x" style="<?php if($bgFit != 'percentage') echo 'display: none; '; ?> width:60px;margin-right:10px" value="<?php echo $bgFitX; ?>" />
									<input type="text" name="bg_fit_y" style="<?php if($bgFit != 'percentage') echo 'display: none; '; ?> width:60px;margin-right:10px"  value="<?php echo $bgFitY; ?>" />

									<label for="slide_bg_repeat"><?php _e("Background Repeat:",REVSLIDER_TEXTDOMAIN)?></label>
									<select name="bg_repeat" id="slide_bg_repeat" style="margin-right:20px">
										<option value="no-repeat"<?php if($bgRepeat == 'no-repeat') echo ' selected="selected"'; ?>>no-repeat</option>
										<option value="repea