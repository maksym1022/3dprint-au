<tr id="rule_post">
			
			<td class="label">
				<label>
					<?php _e( 'Post/Page Rule', POPUP_PLUGIN_PREFIX ); ?>
				</label>
				<p class="description">Leave this field empty to show popup on all posts or pages.</p>
			</td>
			<td>
				<label>
					<input type="text" value="<?php echo $options['rules']['show_only_on_these_posts'] ?>" name="options[rules][show_only_on_these_posts]" placeholder="Enter post ID or multiple ID's with comma separated each value" />
					<p class="description"></p>
				</label>
			</td>
			
</tr>

<tr id="rule_category">
			
			<td class="label">
				<label>
					<?php _e( 'Category Rule', POPUP_PLUGIN_PREFIX ); ?>
				</label>
				<p class="description">Show popup only for the posts in these categories.</p>
			</td>
			<td>
				<label>
					<input type="text" value="<?php echo $options['rules']['show_only_on_these_categories'] ?>" name="options[rules][show_only_on_these_categories]" placeholder="Enter category ID or multiple ID's with comma separated each value" />
					<p class="description"></p>
				</label>
			</td>
			
</tr>

<tr id="rule_websites">
			
			<td class="label">
				<label>
					<?php _e( 'Website Rule', POPUP_PLUGIN_PREFIX ); ?>
				</label>
				<p class="description">Show popup only to the visitors from these websites.</p>
			</td>
			<td>
				<label>
					<input type="text" value="<?php echo $options['rules']['show_only_to_visitors_from_these_sites'] ?>" name="options[rules][show_only_to_visitors_from_these_sites]" placeholder="Enter valid website URL or multiple URL's with comma separated each value" />
					<p class="description"></p>
				</label>
			</td>
			
</tr>