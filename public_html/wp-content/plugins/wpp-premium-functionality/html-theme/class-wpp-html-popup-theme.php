<?php

class Wpp_Html_Popup_Theme extends Wpp_Popup_Theme {

	private $path = WPP_PREMIUM_FUNCTIONALITY_PATH;

	protected $id = 'wpp_html_theme';

	protected $description = 'Put any valid HTML in the popup';

	protected $name = 'HTML Theme';

	function save_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		if ( ! isset( $_POST['html_is_theme'] ) )
			return FALSE;

		$content = $_POST['html_theme_content'];

		$settings = array(
				'content' => $content
			);

		$this->save_settings_to_db( $popup_id, $settings );

	}

	function render_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		$content = $settings['content'];

		include $this->path . 'html-theme/theme_admin_view.php';

	}

	public function auto_popup_render( $popup_id ) {

		if ( ! $this->check_rules( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		$content = $this->filter_content( $settings['content'] );

		include $this->path . 'html-theme/theme_frontend_view.php';


	}

	function link_popup_render( $popup_id, $shortcode_atts ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$link_text = $shortcode_atts['link_text'];

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		$content = $this->filter_content( $settings['content'] );

		include $this->path . 'html-theme/theme_frontend_link_view.php';

	}

	function default_settings() {

		return $settings = array(
				'content' => ''
			);

	}

	private function filter_content( $content ) {

		$content = do_shortcode( $content );


		return $content;


	}	

}
