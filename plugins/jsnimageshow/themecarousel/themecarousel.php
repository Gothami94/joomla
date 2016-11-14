<?php
/**
 * @version     $Id$
 * @package     JSN.ImageShow
 * @subpackage  JSN.ThemeCarousel
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) @JOOMLASHINECOPYRIGHTYEAR@ JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die('Restricted access');
if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}
jimport( 'joomla.plugin.plugin' );
include_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_imageshow'.DS.'classes'.DS.'jsn_is_factory.php');
class plgJSNImageshowThemeCarousel extends JPlugin
{
	var $_showcaseThemeName = 'themecarousel';
	var $_showcaseThemeType = 'jsnimageshow';
	var $_pathAssets 		= 'plugins/jsnimageshow/themecarousel/assets/';
	var $_tableName			= 'theme_carousel';

	function onLoadJSNShowcaseTheme($name, $themeID = 0)
	{
		if($name != $this->_showcaseThemeName){
			return false;
		}

		JPlugin::loadLanguage('plg_'.$this->_showcaseThemeType.'_'.$this->_showcaseThemeName);

		ob_start();

		JHTML::stylesheet( $this->_pathAssets.'css/style.css');
		JHTML::script($this->_pathAssets.'js/jsn_is_admin_conflict.js');
		JSNHtmlAsset::addScript(JSN_URL_ASSETS . '/3rd-party/jquery-easing/jquery.easing.1.3.js');
		JHTML::script($this->_pathAssets.'js/jquery/jquery.event.drag-2.2.js');
		JHTML::script($this->_pathAssets.'js/jquery/jquery.event.drop-2.2.js');
		JHTML::script($this->_pathAssets.'js/jquery/jquery.roundabout.js');
		JHTML::script($this->_pathAssets.'js/jquery/jquery.roundabout-shapes.js');
		JHTML::script($this->_pathAssets.'js/jsn_is_carouseltheme_setting.js');

		include(dirname(__FILE__).DS.'helper'.DS.'helper.php');
		include(dirname(__FILE__).DS.'views'.DS.'default.php');

		return ob_get_clean();
	}

	function onExtensionBeforeUninstall($eid)
	{
		$query 	= 'DROP TABLE IF EXISTS `#__imageshow_'.$this->_tableName.'`';
		$db 	= JFactory::getDbo();
		$db->setQuery($query);
		$db->query();
	}

	function getLanguageJSNPlugin()
	{
		$language = array();
		$language['admin']['files'] = array('plg_'.$this->_showcaseThemeType.'_'.$this->_showcaseThemeName.'.ini');
		$language['admin']['path'] 	= array(dirname(__FILE__).DS.'languages');

		return $language;
	}

	function onDisplayJSNShowcaseTheme($args)
	{
		if ($args->theme_name != $this->_showcaseThemeName) {
			return false;
		}

		JPlugin::loadLanguage('plg_'.$this->_showcaseThemeType.'_'.$this->_showcaseThemeName);
		$basePath 		 = JPATH_PLUGINS.DS.$this->_showcaseThemeType.DS.$this->_showcaseThemeName;
		$objThemeDisplay = JSNISFactory::getObj('classes.jsn_is_carouseldisplay', null ,null, $basePath);
		$result			 = $objThemeDisplay->display($args);
		return $result;
	}

	function listThemecarouselTable()
	{
		return array('#__imageshow_theme_carousel');
	}
}