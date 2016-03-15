<?php

class Wpp_D2_Popup_Theme extends Wpp_Popup_Theme {

	private $path = WPP_PREMIUM_FUNCTIONALITY_PATH;

	protected $id = 'wpp_d2_theme';

	protected $description = 'A beautiful 2 column popup theme with support for image and subscriber form';

	protected $name = 'Theme 2';

	function save_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		if ( ! isset( $_POST['d2_is_theme'] ) )
			return FALSE;

		$list_items = array( $_POST['d2-list-item-1'], $_POST['d2-list-item-2'], $_POST['d2-list-item-3'], $_POST['d2-list-item-4'] );
		
		$before_save_settings = array(
				'heading' => $_POST['d2-heading'],
				'sub-heading' => $_POST['d2-sub-heading'],
				'description' => $_POST['d2-description'],
				'left-column-image' => $_POST['d2-left-column-image'],
				'list-items' => $list_items,
				'right-column-image'=> $_POST['d2-right-column-image'],
				'enter-name-text' => $_POST['d2-enter-name-text'],
				'enter-email-text' => $_POST['d2-enter-email-text'],
				'button-text' => $_POST['d2-button-text'],
				'privacy-text' => $_POST['d2-privacy-text']
			);

		$settings = $before_save_settings;

		$this->save_settings_to_db( $popup_id, $settings );

	}

	function render_settings( $popup_id ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		include $this->path . 'D2/theme_admin_view.php';

	}

	public function auto_popup_render( $popup_id ) {

		if ( ! $this->check_rules( $popup_id ) )
			return FALSE;

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		include $this->path . 'D2/theme_frontend_view.php';


	}

	function link_popup_render( $popup_id, $shortcode_atts ) {

		if ( ! $this->is_activated( $popup_id ) )
			return FALSE;

		$link_text = $shortcode_atts['link_text'];

		$settings = $this->get_settings( $popup_id );

		$uniq_id = uniqid();

		include $this->path . 'D2/theme_frontend_link_view.php';

	}

	function default_settings() {

		return $settings = array(
				'heading' => 'Get it Now',
				'sub-heading' => 'FREE! HTML and WYSIWYG editor',
				'description' => 'Create your own designs and any other content with fully featured visual html editor. Create your own designs and any other content like videos ebooks',
				'left-column-image' => plugins_url( "images/noteimg.png", __FILE__ ),
				'list-items' => array( 'This is the list item', 'This is the list item', 'This is the list item ', 'This is the list item' ),
				'right-column-image'=> plugins_url( "images/subscribeNow.png", __FILE__ ),
				'enter-name-text' => 'Your Name',
				'enter-email-text' => 'Your Email',
				'button-text' => 'Subscribe Now',
				'privacy-text' => 'Your information will not be shared to anyone.'
			);

	}
	

}
