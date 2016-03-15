<?php

function wpp_premium_add_rules_to_options( $popup_id, $options ) {

	if ( ! isset( $options['rules']['show_only_on_these_posts'] ) ||
		 ! isset( $options['rules']['show_only_on_these_categories'] ) )
		$options['rules'] = wpp_premium_modify_default_rules( $options['rules'] );

	if ( ! isset( $options['rules']['show_only_to_visitors_from_these_sites'] ) )
		$options['rules']['show_only_to_visitors_from_these_sites'] = '';

	include WPP_PREMIUM_FUNCTIONALITY_PATH . '/rules/view.php';

}

function wpp_premium_modify_default_rules( $rules ) {

	$rules['show_only_on_these_posts'] = '';

	$rules['show_only_on_these_categories'] = '';

	$rules['show_only_to_visitors_from_these_sites'] = '';

	return $rules;

}

function wpp_premium_validate_rules( $value, $popup_id ) {

	if ( ! $value )
		return $value;

	if (  isset( $_REQUEST['wpp-no-popup'] ) ) {

		if ( $_REQUEST['wpp-no-popup'] === 'yes' )
			return FALSE;

	}

	$options = wpp_get_popup_meta( $popup_id, 'options' );

	if (  isset( $_REQUEST['wpp-close-cookie'] ) ) {

		if ( $_REQUEST['wpp-close-cookie'] === 'yes' ) {

			$cookie_name = 'wpp_popup_' . $popup_id . '_closed';
			
			setcookie( $cookie_name, "", 
				$options['rules']['cookie_expiration_time'], "/" );

			return FALSE;

		}

	}

	if (  isset( $_REQUEST['wpp-subscribed'] ) ) {

		if ( $_REQUEST['wpp-subscribed'] === 'yes' ) {

			$cookie_name = 'wpp_popup_' . $popup_id . '_subscribed';
			
			setcookie( $cookie_name, "", 
				$options['rules']['cookie_expiration_time'], "/" );

			return FALSE;

		}

	}

	global $post;

	if ( get_post_meta( $post->ID, '_wpp_hide_popup', true ) == 'yes' )
		return FALSE;


	if ( ! isset( $options['rules']['show_only_on_these_posts'] ) ||
		 ! isset( $options['rules']['show_only_on_these_categories'] ) )
		$options['rules'] = wpp_premium_modify_default_rules( $options['rules'] );

	if ( ! isset( $options['rules']['show_only_to_visitors_from_these_sites'] ) )
		$options['rules']['show_only_to_visitors_from_these_sites'] = '';

	$post_rule = $options['rules']['show_only_on_these_posts'];

	$category_rule = $options['rules']['show_only_on_these_categories'];

	$website_rule = $options['rules']['show_only_to_visitors_from_these_sites'];

	if ( ! empty( $category_rule  ) ):

		if ( ! is_single()  )
			return $value;

		global $post;

		$post_id = $post->ID;

		$category_rule = str_replace( ' ', '', $category_rule);

		if ( is_numeric( $category_rule ) )
			$category_ids = intval( $category_rule );
		else
			$category_ids = explode( ',', $category_rule );

		if ( is_array( $category_ids ) ) 
			foreach ( $category_ids as $key => $category_id )
				$category_ids[$key] = intval( $category_id );

		if ( in_category( $category_ids, $post_id ) )
			return 	TRUE;

	endif;

	if ( ! empty( $post_rule ) ):

		if ( ! is_single() && ! is_page() )
			return $value;

		global $post;

		$post_id = $post->ID;

		$post_rule = str_replace( ' ', '', $post_rule);

		if ( is_numeric( $post_rule ) )
			$post_ids = array( $post_rule );
		else
			$post_ids = explode( ',', $post_rule );

		if ( ! in_array( $post_id , $post_ids ) )
			return 	FALSE;

	endif;

	if ( ! empty( $website_rule ) && ! empty( $_SERVER['HTTP_REFERER'] ) ):

		if ( strpos( $website_rule, ',' ) !== false )
			$websites = explode( ',', $website_rule );
		else
			$websites = array( $website_rule );

		$ref = $_SERVER['HTTP_REFERER'];

		foreach( $websites as $website ):

			if ( filter_var( $website, FILTER_VALIDATE_URL ) ):

				$website = parse_url( $website, PHP_URL_HOST );
			
				if ( strpos( $ref, $website ) === false )
					return FALSE; 

			endif;

		endforeach;

	endif;

	return $value;

}

function wpp_premium_shortcode_show_popup_when_here( $atts, $content = null ) {

	ob_start();

	echo '<div style="display: block !important; margin:0 !important; padding: 0 !important" id="wpp_popup_post_end_element"></div>';

	return ob_get_clean();
}

function wpp_premium_add_hide_popup_option_in_publish_box() {

	global $post;
	
	$value = get_post_meta( $post->ID, '_wpp_hide_popup', true );

	$checked = checked( $value, 'yes', false );

	echo '<div class="misc-pub-section"><label><input type="checkbox" value="yes" name="_wpp_hide_popup" style="margin-right: 10px;"'. $checked  .' />Hide Popup</label></div>';

}
function wpp_premium_save_hide_popup_option( $post_id ) {

	if ( ! isset( $_REQUEST['_wpp_hide_popup'] ) ) {
		
		update_post_meta( $post_id, '_wpp_hide_popup', 'no' );

		return $post_id;

	}

	update_post_meta( $post_id, '_wpp_hide_popup', 'yes' );

}


add_filter( 'wpp_default_popup_options_rules',
	'wpp_premium_modify_default_rules' );

add_action( 'wpp_options_meta_box_end',
	'wpp_premium_add_rules_to_options', 10, 2 );

add_filter( 'wpp_check_rules', 
	'wpp_premium_validate_rules', 999, 3 );

add_shortcode( 'show_popup_when_here', 'wpp_premium_shortcode_show_popup_when_here' );

add_action( 'post_submitbox_misc_actions', 
	'wpp_premium_add_hide_popup_option_in_publish_box' );

add_action( 'save_post', 'wpp_premium_save_hide_popup_option' );
