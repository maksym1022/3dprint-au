<?php

class Wpp_D1_Popup_Theme extends Wpp_Popup_Theme {

	private $path = WPP_PREMIUM_FUNCTIONALITY_PATH;

	protected $id = 'd1';

	protected $description = 'Simple and beautiful Popup theme';

	protected $name = 'Theme 1';

	function save_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		if ( ! isset( $_POST['d1_is_theme'] ) )
			return FALSE;

		$heading = $_POST['d1_heading'];

		$sub_heading = $_POST['d1_sub_heading'];

		$button_txt = $_POST['d1_button_txt'];

		$privacy_notice = $_POST['d1_privacy_notice'];

		$enter_email_text = $_POST['d1_enter_email_text'];

		if ( $enter_email_text == '' )
			$enter_email_text = 'Enter your Email Address..';

		$settings = array(
				'heading' => $heading,
				'privacy_notice' => $privacy_notice,
				'sub_heading' => $sub_heading,
				'enter_email_text' => $enter_email_text,
				'button_txt' => $button_txt
			);

		$this->save_settings_to_db( $popup_id, $settings );

	}

	function render_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		include $this->path . 'D1/theme_admin_view.php';

	}

	public function auto_popup_render( $popup_id ) {

		if ( ! $this->check_rules( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		include $this->path . 'D1/theme_frontend_view.php';


	}

	function link_popup_render( $popup_id, $shortcode_atts ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$link_text = $shortcode_atts['link_text'];

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		include $this->path . 'D1/theme_frontend_link_view.php';

	}

	function default_settings() {

		return $settings = array(
				'heading' => 'GET it NOW and increase more than 700% Email Subscribers.',
				'privacy_notice' => 'Your information will not be shared to anyone',
				'sub_heading' => 'WP Popup plugin is the most powerful popup plugin for Wordpress on the market. Get it Now!',
				'enter_email_text' => 'Enter your email address..',
				'button_txt' => 'Subscribe Now'
			);

	}	

}
