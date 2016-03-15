<?php

class Wpp_D8_Popup_Theme extends Wpp_Popup_Theme {

	private $path = WPP_PREMIUM_FUNCTIONALITY_PATH;

	protected $id = 'wpp_d8_theme';

	protected $description = '';

	protected $name = 'Theme 3';

	function save_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		if ( ! isset( $_POST['d8_is_theme'] ) )
			return FALSE;

		$before_save_settings = array(
				'heading' => $_POST['d8-heading'],
				'sub-heading' => $_POST['d8-sub-heading'],
				'description' => $_POST['d8-description'],
				'enter-name-text' => $_POST['d8-enter-name-text'],
				'enter-email-text' => $_POST['d8-enter-email-text'],
				'button-text' => $_POST['d8-button-text'],
				'privacy-text' => $_POST['d8-privacy-text'],
				'teaser-text' => $_POST['d8-teaser-text']
			);

		$settings = $before_save_settings;

		$this->save_settings_to_db( $popup_id, $settings );

	}

	function render_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		include $this->path . 'D8/theme_admin_view.php';

	}

	public function auto_popup_render( $popup_id ) {

		if ( ! $this->check_rules( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		include $this->path . 'D8/theme_frontend_view.php';

	}

	function link_popup_render( $popup_id, $shortcode_atts ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$link_text = $shortcode_atts['link_text'];

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		include $this->path . 'D8/theme_frontend_link_view.php';

	}

	function default_settings() {

		return $settings = array(
				'heading' => 'Get it Now',
				'sub-heading' => 'FREE! HTML and WYSIWYG editor',
				'description' => 'Create your own designs and any other content with fully featured visual html editor.',
				'enter-name-text' => 'Your Name',
				'enter-email-text' => 'Your Email',
				'button-text' => 'Subscribe Now',
				'privacy-text' => 'Your information will not be shared to anyone.',
				'teaser-text' => 'Subscribe Now'
			);

	}
	

}
