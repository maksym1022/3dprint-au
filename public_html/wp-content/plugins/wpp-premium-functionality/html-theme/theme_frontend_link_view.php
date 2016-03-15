<script>
jQuery(function ($) {

	var id = "<?php echo esc_js( $popup_id ) ?>";
	
	var options = <?php $this->echo_popup_options_in_json( $popup_id ) ?>;

	var uniq_id = "<?php echo esc_js( $uniq_id ) ?>";

	var rules = options.rules;

	$('.link_<?php echo $this->id . '-' . $popup_id ?>').colorbox({
		inline: true,
		fixed: true,
		className: 'cbox_wpp_html_theme',
		transition: options.transition,
		overlayClose: false,
		escKey: false,
		speed: 200,

		onOpen: function() {

				$("#colorbox").css("opacity", 0);
		
		},

		onComplete: function() {

			$("#colorbox").css("opacity", 1);

			$('#cboxOverlay.cbox_wpp_html_theme').css( 'background', options.mask_color );

			$('.cbox_wpp_html_theme #cboxLoadedContent').css( 'border-color', options.border_color );
		}
	});

	if ( rules.comment_autofill ) {
		
		wpp_do_comment_autofill( uniq_id, '<?php echo esc_js(COOKIEHASH) ?>' );
	
	}
	
});
</script>

<a class='link_<?php echo $this->id . '-' . $popup_id ?>' href='#<?php echo $this->id . '-' . $popup_id ?>'><?php echo $link_text ?></a>

<!-- This contains the hidden content for popup -->
<div style='display:none'>
	
	<div id='<?php echo $this->id . '-' . $popup_id ?>' style='padding:0px;' class="<?php echo $uniq_id ?>">
		<?php echo $content ?>
	</div>
		
</div>