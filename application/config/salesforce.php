<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Salesforce API Username
|--------------------------------------------------------------------------
|
| Your username used to access Salesforce through the API
|
*/
$config['sforce_username'] = 'keshav_mantri@marketingmindz.in';

/*
|--------------------------------------------------------------------------
| Salesforce API Password
|--------------------------------------------------------------------------
|
| Your password used to access Salesforce through the API
|
*/
$config['sforce_password'] = 'asdf1234%';

/*
|--------------------------------------------------------------------------
| Salesforce API Security Token
|--------------------------------------------------------------------------
|
| Your salesforce security token
|
*/
$config['sforce_token'] = 'T3o7ICELyJ1xCSLBtMsIAWGBo';

/*
|--------------------------------------------------------------------------
| Salesforce WSDL Type
|--------------------------------------------------------------------------
|
| If using the Partner WSDL, set the value to partner
| If using the Enterprise WSDL, set the value to enterprise
|
| For more information on the difference between partner and enterprise WSDL, see: 
| http://www.salesforce.com/us/developer/docs/api/Content/sforce_api_partner.htm
|
*/
$config['sforce_type']  = 'partner';

/*
|--------------------------------------------------------------------------
| Salesforce Sandbox Mode
|--------------------------------------------------------------------------
|
| Set to true to use sandbox WSDL
|
*/
$config['sforce_sandbox']  = false;