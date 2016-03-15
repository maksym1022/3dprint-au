<?php

function wpp_premium_cm_settings_page() {

	$settings = wpp_get_settings();

	if ( ! isset( $settings['cm'] ) )
		$settings = wpp_premium_cm_modify_default_settings( $settings );

	include WPP_PREMIUM_FUNCTIONALITY_PATH . 
			'/campaignmonitor/settings_page_view.php';

}

function wpp_premium_cm_modify_default_settings( $settings ) {

	$settings['cm'] = array( 'api_key' => '', 'list_id' => '' );

	return $settings;

}

function wpp_premium_cm_email_service_select( $email_service ) {

	$selected = '';

	if ( $email_service == 'cm' )
		$selected = 'selected="selected"';

	echo "<option value='cm' $selected>Campaign Monitor</option>";

}

function wpp_premium_cm_store_email( $data ) {

	$settings = wpp_get_settings();

	$subscriber_exist_message = $settings['error_message']['subscriber_already_exist'];

	$unknown_error_message = $settings['error_message']['unknown'];

	if ( ! isset( $settings['cm'] ) )
		$settings = wpp_premium_cm_modify_default_settings( $settings );

	require_once WPP_PREMIUM_FUNCTIONALITY_PATH . 
				'/campaignmonitor/csrest_subscribers.php';

	$auth = array( 'api_key' => $settings['cm']['api_key'] );

	$wrap = new CS_REST_Subscribers( $settings['cm']['list_id'], $auth );
	
	$result = $wrap->add( array(
			'EmailAddress' => $data['email'],
			'Name' => $data['name'],
			'CustomFields' => array(
					array(
							'Key' => 'POPUPID',
							'Value' => $data['popup_id']
						),
					array(
							'Key' => 'POPUPTHEMEID',
							'Value' => $data['theme_id']
						)
				),
			'Resubscribe' => true
		) );

	if ( ! $result->was_successful() ):

		$error_msg = $result->response->Message;

		$error_code = $result->response->Code;

		$response = array(
					'status' => 'error',
					'code' => -1,
					'cm_http_error_code' => $result->http_status_code,
					'cm_error_code' => $error_code,
					'message' => $unknown_error_message . ' - ' . $error_msg
				);

		exit( json_encode( $response ) );

	endif;



	
}

add_action( 'wpp_settings_page_end', 'wpp_premium_cm_settings_page' );

add_filter( 'wpp_default_options', 'wpp_premium_cm_modify_default_settings' );

add_action( 'wpp_settings_email_service_select', 
	'wpp_premium_cm_email_service_select' );

add_action( 'wpp_store_email_to_campaign_monitor', 
	'wpp_premium_cm_store_email'  );