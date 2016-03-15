			<!-- Campaign Monitor Section start -->

			<div class="wpp_settings_section">

				<div class="wpp_settings_title">
					<h3>
						<img src="<?php echo plugins_url( "images/trans.png", POPUP_PLUGIN_MAIN_FILE ) ?>" class="inactive" alt="">
						Campaign Monitor</h3>
						<span class="submit">
							<input type="submit" name="saved" class="button button-primary" value="Save changes" />
						</span>
					<div class="clearfix"></div>
				</div>

				<div class="wpp_settings_options">

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="cm_api_key">API Key</label>
						<input type="text" id="cm_api_key" name="settings[cm][api_key]" value="<?php echo $settings['cm']['api_key'] ?>" />
							
						<small></small>

					</div>

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="cm_list_id">List ID</label>
						<input type="text" id="cm_list_id" name="settings[cm][list_id]" value="<?php echo $settings['cm']['list_id'] ?>" />
							
						<small></small>

					</div>

				</div>

			</div>

			<!-- Campaign Monitor Section end -->