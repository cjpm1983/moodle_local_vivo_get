<?php

/*
* ubicacion del plugin en menu local
*
* @package local_vivo_get
* @author Carlos Palacios <cjpm1983@gmail.com>
* @copyright  Carlos Palacios 2022
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die;



// Ensure the configurations for this site are set
if ( $hassiteconfig ){

	// Create the new settings page
	// - in a local plugin this is not defined as standard, so normal $settings->methods will throw an error as
	// $settings will be NULL
	$settings = new admin_settingpage( 'local_vivo_get', 'Get from Vivo Settings' );

	// Create 
	$ADMIN->add( 'localplugins', $settings );

	// Add a setting field to the settings for this page
	$settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/serverurl',
	
		// This is the friendly title for the config, which will be displayed
		'Sparql endpoint: url',
	
		// This is helper text for this config field
		get_string('labelServer','local_vivo_get'),
	
		// This is the default value
		'No Url Defined',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );

    $settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/serveruser',
	
		// This is the friendly title for the config, which will be displayed
		'Sparql endpoint: user',
	
		// This is helper text for this config field
		get_string('labelUser','local_vivo_get'),
	
		// This is the default value
		'No user Defined',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );

    $settings->add( new admin_setting_configpasswordunmask(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/serverpass',
	
		// This is the friendly title for the config, which will be displayed
		'Sparql endpoint: pass',
	
		// This is helper text for this config field
		get_string('labelPassword','local_vivo_get'),
	
		// This is the default value
		'No password Defined',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );

	
    $settings->add( new admin_setting_heading(
		'local_vivo_get/mappedfields',
		get_string('mappedFields','local_vivo_get'),
		get_string('mappedFieldsInfo','local_vivo_get')
		)
	);


	$settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/remotefield1',
	
		// This is the friendly title for the config, which will be displayed
		'remote endpoint field: remotefield1',
	
		// This is helper text for this config field
		'',
	
		// This is the default value
		'',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );
	$settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/localfield1',
	
		// This is the friendly title for the config, which will be displayed
		'local profile field: localfield1',
	
		// This is helper text for this config field
		'',
	
		// This is the default value
		'',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );

	$settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/remotefield2',
	
		// This is the friendly title for the config, which will be displayed
		'remote endpoint field: remotefield2',
	
		// This is helper text for this config field
		'',
	
		// This is the default value
		'',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );
	$settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/localfield2',
	
		// This is the friendly title for the config, which will be displayed
		'local profile field: localfield2',
	
		// This is helper text for this config field
		'',
	
		// This is the default value
		'',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );

	$settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/remotefield3',
	
		// This is the friendly title for the config, which will be displayed
		'remote endpoint field: remotefield3',
	
		// This is helper text for this config field
		'',
	
		// This is the default value
		'',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );
	$settings->add( new admin_setting_configtext(
		
		// This is the reference you will use to your configuration
		'local_vivo_get/localfield3',
	
		// This is the friendly title for the config, which will be displayed
		'local profile field: localfield3',
	
		// This is helper text for this config field
		'',
	
		// This is the default value
		'',
	
		// This is the type of Parameter this config is
		PARAM_TEXT
	
	) );

	// $settings->add(new admin_setting_configcheckbox_with_advanced('mod_lesson/password',
	// get_string('password', 'lesson'), get_string('configpassword_desc', 'lesson'),
	// array('value' => 0, 'adv' => true)));
    
}
/*
$pluginname =  "Get from Vivo";//get_string('pluginname'); //nombre de la clave, archivo de idioma

$ADMIN->add(new admin_setting_FIELDTYPE('MYMOD/MYNAME',  'MYNAME',  'MYDESC', array('value' => '0',  'fix' => false),  PARAM_INT));
$ADMIN->add('local', new admin_externalpage('vivo_get',
            $pluginname,
            new moodle_url('/local/vivo_get/index.php'),
            "local/vivo_get:view"));

//aqui iria la configuracion
$settings = null;   
*/