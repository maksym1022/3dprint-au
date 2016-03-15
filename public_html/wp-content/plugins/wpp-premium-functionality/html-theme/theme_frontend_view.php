<script>
jQuery(function ($) {

	var id = "<?php echo esc_js( $popup_id ) ?>";

	var uniq_id = "<?php echo esc_js( $uniq_id ) ?>";

	var options = <?php $this->echo_popup_options_in_json( $popup_id ) ?>;

	var rules = options.rules;
	
	if ( ! wpp_check_rules( rules, id ) )
		return false;

	var do_popup_function = function() {
		$.colorbox({
			inline: true,
			fixed: true,
			width: 'auto',
			height: 'auto',
			
			href: "#<?php echo $this->id . '-auto_popup-' . $popup_id ?>",
			className: 'cbox_wpp_html_theme',
			overlayClose: false,
			escKey: false,
			transition: options.transition,

			onOpen: function() {

				$("#colorbox").css("opacity", 0);

			},

			onComplete: function() {

				$("#colorbox").css("opacity", 1);

			},

			onClosed: function() {

				if ( rules.use_cookies )
					wpp_place_popup_close_cookie( id, rules.cookie_expiration_time );
			}
		});

		$('#cboxOverlay.cbox_wpp_html_theme').css( 'background', options.mask_color );

		$('.cbox_wpp_html_theme #cboxLoadedContent').css( 'border-color', options.border_color );

		//$('.cbox_wpp_html_theme #cboxLoadedContent').css( 'background', 'transparent' );
	
	};

	if ( rules.exit_popup ) {

		wpp_do_exit_popup( do_popup_function );

	} else if ( rules.when_post_end_rule ) {

		wpp_check_when_post_rule( do_popup_function );

	} else {

		setTimeout( do_popup_function, options.delay_time );
	
	}

	if ( rules.comment_autofill ) {
		
		wpp_do_comment_autofill( uniq_id, '<?php echo esc_js(COOKIEHASH) ?>' );
	
	}

});
</script>

<!-- This contains the hidden content for popup -->
<div style='display:none'>
	
	<div id='<?php echo $this->id . '-auto_popup-' . $popup_id ?>' style='padding:0px;' class="<?php echo $uniq_id ?> wpp_html_theme">
		<?php echo $content ?>
	</div>

</div>