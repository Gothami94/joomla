<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

/**
 * Joomla! Core Login Redirect
 * Version 1.7.2
 * @author		River Media
 * @package		Joomla
 * @subpackage	System
 */
class  plgSystemCore_Login_Redirect extends JPlugin
{

	/**
	 * Object Constructor.
	 *
	 * @access	public
	 * @param	object	The object to observe -- event dispatcher.
	 * @param	object	The configuration object for the plugin.
	 * @return	void
	 * @since	1.0
	 */
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterRoute()
	{
		$params = $this->params;
		self::processRedirects($params, 'after_route');
		return;
	}

	function onAfterInitialise()
	{
		$params = $this->params;
		self::processRedirects($params, 'after_init');
		return;
	}
	
	public static function processRedirects($params, $type)
	{
		$app					= JFactory::getApplication();
		$user					= JFactory::getUser(); 					
		$jinput					= JFactory::getApplication()->input;

		$option					= $jinput->get('option', '', 'string');

		if(version_compare(JVERSION,'3.2','>'))
		{
			$requireReset = $user->requireReset;
		}
		else
		{
			$requireReset = 0;
		}
		
		if(!$app->isSite())
		{
			return false;
		}
		elseif($option=='com_users' || $option=='com_comprofiler' || $option=='com_community' || $option=='com_awdwall')
		{

			if($requireReset)
			{
				return;
			}
			
#			$params					= $this->params;
			$task					= $jinput->get('task', '', 'string');
			$view					= $jinput->get('view', '', 'string');
			$layout					= $jinput->get('layout', '', 'string');
			$return					= $jinput->get('return', '', 'string');
	
			$custom_register		= $params->get('custom_register', 'cb');
			$custom_post_register	= $params->get('custom_post_register', 'cb');
			$custom_login			= $params->get('custom_login', 'cb');
			$custom_profile			= $params->get('custom_profile', 'cb');
			$custom_password		= $params->get('custom_password', 'cb');
			$custom_username		= $params->get('custom_username', 'cb');
			$custom_post_login		= $params->get('custom_post_login', 0);
			$custom_post_login_menu	= $params->get('custom_post_login_menu', '');
			$custom_post_login_URL	= $params->get('custom_post_login_URL', '');
			$custom_logout			= $params->get('custom_logout', 0);
			$custom_logout_menu		= $params->get('custom_logout_menu', '');
			$custom_logout_URL		= $params->get('custom_logout_url', '');
			$devMode				= $params->get('dev_mode', 0);

			$ckeckRegister 			= ($task=='register' || $view=='registration' || $view=='register');
			$ckeckProfile 			= ($task!='user.logout' && $task != 'user.login');
			$redirectURL			= '';

			switch(true)
			{

// bypass plugin altogether if logging out with a valid token
// (it seems that the task 'user.logout' is only used when a token is present)
				case $option=='com_users' && $task=='user.logout':
					return;
#				case $clro:
#					return;
				
// LOGOUT:
				// redirect for a forced logout
				case $option=='com_users' && $view=='login' && !$user->guest && $custom_logout && $type=='after_route':
					$processType = 'LOGOUT';
					if($custom_logout_menu=='' && $custom_logout_URL=='')
					{
						$vars = $app::getRouter()->getVars();
						$returnVar = '&return='.base64_encode('index.php?' . JUri::buildQuery($vars));
					}
					else
					{
						$redirectURL = self::checkCustomURL($params, 'custom_logout');
						$returnVar = '&return='.base64_encode($redirectURL);
					}

					$masterRedirect = 'index.php?option=com_users&task=user.logout'.$returnVar.'&'.JSession::getFormToken().'=1';
					break;
				
// REGISTRATION:
				// redirect FROM joomla registration TO community builder registration
				case $option=='com_users' && $ckeckRegister && $custom_register == 'cb':
					$processType = 'REGISTRATION';
					$masterRedirect = 'index.php?option=com_comprofiler&task=registers';
					break;
				// redirect FROM joomla registration TO jomsocial registeration
				case $option=='com_users' && $ckeckRegister && $custom_register == 'js':
					$processType = 'REGISTRATION';
					$masterRedirect = "index.php?option=com_community&view=register";	
					break;		  
				// redirect FROM joomla registration TO custom registration
				case $option=='com_users' && $ckeckRegister && $custom_register == 'custom':
					$processType = 'REGISTRATION';
					$masterRedirect = self::checkCustomURL($params, 'custom_register');
					break;
				// redirect FROM community builder registration TO custom registration
				case $option=='com_comprofiler' && $task=='registers' && $custom_register == 'custom':
					$processType = 'REGISTRATION';
					$masterRedirect = self::checkCustomURL($params, 'custom_register');
					break;
				// redirect FROM jomsocial registration TO custom registration
				case $option=='com_community' && $task=='register' && $custom_register == 'custom':
					$processType = 'REGISTRATION';
					$masterRedirect = self::checkCustomURL($params, 'custom_register');
					break;
				// redirect FROM jomwall registration TO custom registration
					// not sure if this will be able to be used since it appears that JomWall doesn't have a direct URL to a registration page
/*
				case $option=='com_awdwall' && $task=='register' && $custom_register == 'custom':
					$masterRedirect = self::checkCustomURL($params, 'custom_register');
					break;
*/
// LOGIN:
				// redirect FROM joomla login TO custom login
				case $option=='com_users' && $view=='login' && $custom_login=='custom':
					$processType = 'LOGIN';
					$masterRedirect = self::checkCustomURL($params, 'custom_login');
					break;
				// redirect FROM community builder login TO custom login
				case $option=='com_comprofiler' && $view=='login' && $custom_login=='custom':
					$processType = 'LOGIN';
					$masterRedirect = self::checkCustomURL($params, 'custom_login');
					break;
				// redirect FROM jomsocial login TO custom login
				case $option=='com_users' && $view=='frontpage' && $custom_login=='custom':
					$processType = 'LOGIN';
					$masterRedirect = self::checkCustomURL($params, 'custom_login');
					break;
				// redirect FROM jomwall login TO custom login
				case $option=='com_awdwall' && $task=='login' && $custom_login=='custom':
					$processType = 'LOGIN';
					$masterRedirect = self::checkCustomURL($params, 'custom_login');
					break;
				// redirect FROM joomla login TO community builder login
				case $option=='com_users' && $view=='login' && $custom_login=='cb':
					$processType = 'LOGIN';
					$masterRedirect = "index.php?option=com_comprofiler&task=login";
					break;
				// redirect FROM joomla login TO jomsocial login
				case $option=='com_users' && $view=='login' && $custom_login == 'js':
					$processType = 'LOGIN';
					$app->redirect(JRoute::_("index.php?option=com_community&view=frontpage",false));	
					break;		  
				// redirect FROM joomla login TO jomwall login
				case $option=='com_users' && $view=='login' && $custom_login=='jw':
					$processType = 'LOGIN';
					$masterRedirect = "index.php?option=com_awdwall&task=login";
					break;
				// redirect FROM community builder login TO joomla login
				case $option=='com_comprofiler' && $task=='login' && $custom_login == 'joomla':
					$processType = 'LOGIN';
					$masterRedirect = "index.php?option=com_users&view=login";	
					break;		  
				// redirect FROM jomsocial login TO joomla login
				case $option=='com_community' && $view== 'frontpage' && $custom_login == 'joomla':
					$processType = 'LOGIN';
					$masterRedirect = "index.php?option=com_users&view=login";	
					break;		  
				// redirect FROM jomwall login TO joomla login
				case $option=='com_awdwall' && $task=='login' && $custom_login=='joomla':
					$processType = 'LOGIN';
					$masterRedirect = "index.php?option=com_users&view=login";	
					break;
// PROFILE:				
				// redirect FROM joomla profile TO community builder profile
				case $option=='com_users' && $view=='profile' && $custom_profile == 'cb':
					$processType = 'PROFILE';
					$masterRedirect = "index.php?option=com_comprofiler&view=profile";
					break;
				// redirect FROM joomla profile TO jomsocial profile
				case $option=='com_users' && $ckeckProfile && !$user->guest && $custom_profile == 'js':
					$processType = 'PROFILE';
					$masterRedirect = "index.php?option=com_community&view=profile";	
					break;		  
				// redirect FROM joomla profile TO jomwall profile
				case $option=='com_users' && $ckeckProfile && !$user->guest && $custom_profile == 'jw':
					$processType = 'PROFILE';
					$masterRedirect = "index.php?option=com_awdwall&view=awdwall&layout=mywall";	
					break;		  
				// redirect FROM community builder profile TO joomla profile
				case $option=='com_comprofiler' && $view=='profile' && $custom_profile == 'joomla':
					$processType = 'PROFILE';
					$masterRedirect = "index.php?option=com_users&view=profile";
					break;
				// redirect FROM jomsocial profile TO joomla profile
				case $option=='com_community' && $view=='profile' && $custom_profile == 'joomla':
					$processType = 'PROFILE';
					$masterRedirect = "index.php?option=com_users&view=profile";
					break;
				// redirect FROM jomwall profile TO joomla profile
				case $option=='com_awdwall' && $view=='awdwall' && $layout=='mywall' && $custom_profile == 'joomla':
					$processType = 'PROFILE';
					$masterRedirect = "index.php?option=com_users&view=profile";
					break;
				// redirect FROM community builder profile or joomla or jomsocial or jomwall TO custom profile
				case ($option=='com_comprofiler' || $option=='com_users' || $option == 'com_community' || $option=='com_awdwall') && ($view=='profile' || $view=='awdwall') && $custom_profile=='custom':
					$processType = 'PROFILE';
					$masterRedirect = self::checkCustomURL($params, 'custom_profile');
					break;
// PASSWORD:
				// redirect FROM joomla core TO community builder forgot password
				case $option=='com_users' && $view=='reset' && $custom_password=='cb':
					$processType = 'PASSWORD';
					$masterRedirect = "index.php?option=com_comprofiler&task=lostPassword";
					break;
				// redirect FROM joomla password TO custom password
				case $option=='com_users' && $view=='reset' && $custom_password=='custom':
					$processType = 'PASSWORD';
					$masterRedirect = self::checkCustomURL($params, 'custom_password');
					break;
				// redirect FROM community builder TO joomla password
				case $option=='com_comprofiler' && $task=='lostpassword' && ($custom_password=='joomla' || $custom_username=='joomla'):
					$processType = 'PASSWORD';
					$masterRedirect = 'index.php?option=com_users&view=reset';
					break;
				// redirect FROM community builder TO custom password
				case $option=='com_comprofiler' && $task=='lostpassword' && ($custom_password=='custom' || $custom_username=='custom'):
					$processType = 'PASSWORD';
					$masterRedirect = self::checkCustomURL($params, 'custom_password');
					break;
// USERNAME:
				// FYI, there isn't a seperate call for community builder username reminder
				// redirect FROM joomla core TO community builder forgot username
				case $option=='com_users' && $view=='remind' && $custom_username=='cb':
					$processType = 'USERNAME';
					$masterRedirect = "index.php?option=com_comprofiler&task=lostPassword";
					break;
				// redirect FROM joomla core TO custom username
				case $option=='com_users' && $view=='remind' && $custom_username=='custom':
					$processType = 'USERNAME';
					$masterRedirect = self::checkCustomURL($params, 'custom_profile');
					break;
				
				default:
					$processType = 'none';
					$masterRedirect = '';
			}
				
$devMessage='';
if($devMode)
{

	$html = '<pre>';
	$html.= time().'<br>';
	$html.= 'TYPE: '.$type.'<br>';
	$html.= 'PROCESS TYPE: '.$processType.'<br>';
	$html.= 'OPTION: '.$option.'<br>';
	$html.= 'TASK: '.$task.'<br>';
	$html.= 'VIEW: '.$view.'<br>';
	$html.= 'custom_logout: '.$custom_logout.'<br>';
	$html.= 'custom_register: '.$custom_register.'<br>';
	$html.= 'custom_login: '.$custom_login.'<br>';
	$html.= 'custom_profile: '.$custom_profile.'<br>';
	$html.= 'custom_password: '.$custom_password.'<br>';
	$html.= 'custom_username: '.$custom_username.'<br>';
	$html.= 'custom_post_login: '.$custom_post_login.'<br>';
	$html.= 'redirectURL: '.$redirectURL.'<br>';
	$html.= 'masterRedirect: '.$masterRedirect.'<br>';
	$html.= '</pre>';
#$_SESSION['devLog'].= $html;
#	print_r($vars);
	$devMessage = $html.'<br />';
/*	die('DevMode Enabled for \'Core Login Redirect\'.'.$devMessage);
*/
JError::raiseNotice( 100, '<strong>DEV NOTICE:</strong> The \'Core Login Redirect\' - System Plugin was processed.<p style="color:red;">This is a \'Developer Release\' of this plugin and should not to be installed on live sites.<br />'.$masterRedirect.$html );

}

			if($masterRedirect!='')
			{
				$app->redirect(JRoute::_($masterRedirect,false),$devMessage);
			}
		}
	}

	public static function checkCustomURL($params, $type='')
	{
		$app			= JFactory::getApplication();
#		$params			= $this->params;
		$custom_menu	= $params->get($type.'_menu');
		$menu = 'index.php?Itemid='.$custom_menu;
		if($type=='custom_login' && $custom_menu > 0)
		{
			$custom_url		=  $menu;
		}
		elseif($custom_menu > 0)
		{
			$custom_url = $menu;
		}
		elseif($type!='custom_login')
		{
			$custom_url = $params->get($type.'_url');
		}
		else
		{
			$custom_url = '';
		}

		// Check for valid URL.
		if (empty($custom_url)) 
		{
			$app->redirect('index.php','Could Not Redirect! You didn\'t specify a Menu Item or URL in the \''.strtoupper(str_replace('custom_','',$type)).' HANDLER\' settings!');
			return false;
		}
		
		return $custom_url;
	}
}