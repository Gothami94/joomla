<?php
/**
* @package Redirect-On-Login (com_redirectonlogin)
* @version 4.0.2
* @copyright Copyright (C) 2008 - 2016 Carsten Engel. All rights reserved.
* @license GPL versions free/trial/pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class redirectonloginModelUsergroup extends JModelList{	
	//bogus empty model just for some crazy 3rd party extensions (k2 system plugin) which throw errors if class does not exist	
	//http://www.pages-and-items.com/forum/38-redirect-on-login/8307-model-class-redirectonloginmodelusergroup-not-found-in-file
}
?>