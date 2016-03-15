<?php

function wpp_premium_icontact_settings_page() {

	$settings = wpp_get_settings();

	if ( ! isset( $settings['icontact'] ) )
		$settings = wpp_premium_icontact_modify_default_settings( $settings );

	$app_id = "r580q5Cg5vfwLMa9aVQJp7fQsOXcDk2O";

	$api_url = "https://app.icontact.com/icp";

	include WPP_PREMIUM_FUNCTIONALITY_PATH . 
			'/icontact/settings_page_view.php';

}

function wpp_premium_icontact_modify_default_settings( $settings ) {

	$settings['icontact'] = array( 'account_id' => '', 'folder_id' => '' ,'list_id' => '', 'password' => '', 'username' => '' );

	return $settings;

}

function wpp_premium_icontact_email_service_select( $email_service ) {

	$selected = '';

	if ( $email_service == 'icontact' )
		$selected = 'selected="selected"';

	echo "<option value='icontact' $selected>iContact</option>";

}


function wpp_premium_icontact_store_email( $data ) {
	
	$settings = wpp_get_settings();

	if ( $settings['email_service'] !== 'icontact' )
		return FALSE;
	
	$subscriber_exist_message = $settings['error_message']['subscriber_already_exist'];

	$unknown_error_message = $settings['error_message']['unknown'];

	if ( ! isset( $settings['icontact'] ) )
		$settings = wpp_premium_icontact_modify_default_settings( $settings );

	require_once WPP_PREMIUM_FUNCTIONALITY_PATH . '/icontact/iContact.php';	

	$username = $settings['icontact']['username'];

	$password = $settings['icontact']['password'];

	$account_id = $settings['icontact']['account_id'];

	$folder_id = $settings['icontact']['folder_id'];

	$list_name = $settings['icontact']['list_id'];

	$list_id = NULL;

	$iContact = new iContact(
			'https://app.icontact.com/icp',		// apiUrl
			$username,					// username
			$password,						// password
			'r580q5Cg5vfwLMa9aVQJp7fQsOXcDk2O',	// appId
			$account_id,								// accountId
			$folder_id,								// clientFolderId
			false								// debug mode
	);

	$lists = $iContact->getLists();

	foreach ( $lists as $list ) {

		if ( $list['name'] == $list_name ) {
			
			$list_id = $list['listId'];

			break;

		}

	}

	if ( $list_id === NULL ) {

		$response = array(
					'status' => 'error',
					'code' => -1,
					'message' => 'Error - No List found with the List name you entered in the settings'
				);

		exit( json_encode( $response ) );

	}

	$contact[] = array(
			'email' => $data['email'],
			'firstName' => $data['name'],
			'status' => 'normal'
		);

	$contact_id = $iContact->createContacts( $contact );

	$iContact->subscribeContactsToList( $list_id, $contact_id );

}

add_action( 'wpp_settings_page_end', 'wpp_premium_icontact_settings_page' );

add_filter( 'wpp_default_options', 
	'wpp_premium_icontact_modify_default_settings' );

add_action( 'wpp_settings_email_service_select', 
	'wpp_premium_icontact_email_service_select' );

add_action( 'wpp_store_email', 
	'wpp_premium_icontact_store_email'  );