		<!-- iContact Section start -->

			<div class="wpp_settings_section">

				<div class="wpp_settings_title">
					<h3>
						<img src="<?php echo plugins_url( "images/trans.png", POPUP_PLUGIN_MAIN_FILE ) ?>" class="inactive" alt="">
						iContact</h3>
						<span class="submit">
							<input type="submit" name="saved" class="button button-primary" value="Save changes" />
						</span>
					<div class="clearfix"></div>
				</div>

				<div class="wpp_settings_options">

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="icontact_username">Username</label>
						<input type="text" id="icontact_username" name="settings[icontact][username]" value="<?php echo $settings['icontact']['username'] ?>" />
							
						<small>Your iContact account username</small>

					</div>

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="icontact_password">App Password</label>
						<input type="text" id="icontact_password" name="settings[icontact][password]" value="<?php echo $settings['icontact']['password'] ?>" />
							
						<small>Please use the App ID <em><strong>r580q5Cg5vfwLMa9aVQJp7fQsOXcDk2O</strong></em> on <a href="https://app.icontact.com/icp/core/externallogin/">App page</a> and set the password</small>

					</div>

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="icontact_account_id">Account ID</label>
						<input type="text" id="icontact_account_id" name="settings[icontact][account_id]" value="<?php echo $settings['icontact']['account_id'] ?>" />
							
						<small>Account ID can be found on the <a href="https://app.icontact.com/icp/core/externallogin/">App page</a></small>

					</div>


					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="icontact_folder_id">Folder ID</label>
						<input type="text" id="icontact_folder_id" name="settings[icontact][folder_id]" value="<?php echo $settings['icontact']['folder_id'] ?>" />
							
						<small>Folder ID can be found on the <a href="https://app.icontact.com/icp/core/externallogin/">App page</a></small>

					</div>

					<div class="wpp_settings_input wpp_settings_textarea">

						<label for="icontact_list_id">List Name</label>
						<input type="text" id="icontact_list_id" name="settings[icontact][list_id]" value="<?php echo $settings['icontact']['list_id'] ?>" />
							
						<small>List Name, where subscribers will be added</small>

					</div>

				</div>

			</div>

		<!-- iContact Section end -->