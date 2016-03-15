		<!-- Aweber Section start -->

			<div class="wpp_settings_section">

				<div class="wpp_settings_title">
					<h3>
						<img src="<?php echo plugins_url( "images/trans.png", POPUP_PLUGIN_MAIN_FILE ) ?>" class="inactive" alt="">
						Aweber</h3>
						<span class="submit">
							<input type="submit" name="saved" class="button button-primary" value="Save changes" />
						</span>
					<div class="clearfix"></div>
				</div>

				<div class="wpp_settings_options">

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="aweber_auth_code">Authorization code</label>
						<input type="text" id="aweber_auth
						_code" name="settings[aweber][auth_code]" value="<?php echo $settings['aweber']['auth_code'] ?>" />
							
						<small><a href="<?php echo $auth_url ?>" target="_blank">GET AUTHORIZATION CODE</a></small>

					</div>

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="aweber_list_id">List Name</label>
						<input type="text" id="aweber_list_id" name="settings[aweber][list_id]" value="<?php echo $settings['aweber']['list_id'] ?>" />
							
						<small>Subscribers will be added to this list</small>

					</div>

				</div>

			</div>

		<!-- Aweber Section end -->