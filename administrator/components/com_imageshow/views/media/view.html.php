<?php
/**
 * @author JoomlaShine.com Team
 * @copyright JoomlaShine.com
 * @link joomlashine.com
 * @package JSN ImageShow
 * @version $Id: view.html.php 17386 2012-10-24 09:47:31Z giangnd $
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class ImageShowViewMedia extends JViewLegacy
{
	function display($tpl = null)
	{
		
		
		global $mainframe;

		$objJSNMedia = JSNISFactory::getObj('classes.jsn_is_media');
		$document = JFactory::getDocument();

		$objJSNMedia->addScript(JURI::root(true) . '/administrator/components/com_imageshow/assets/js/joomlashine/imagemanager.js');
		$objJSNMedia->addStyleSheet(JURI::root(true) . '/administrator/components/com_imageshow/assets/css/popup-imagemanager.css');
		$objJSNMedia->addStyleSheet(JURI::root(true) . '/templates/system/css/system.css');

		$objJSNMediaManager = JSNISFactory::getObj('classes.jsn_is_mediamanager');
		$objJSNMediaManager->setMediaBasePath();
		$state 				= $objJSNMediaManager->getStateFolder();
		$folderList			= $objJSNMediaManager->getFolderList();
		$session			= JFactory::getSession();
		
		$url = 'index.php?option=com_imageshow&controller=media&task=upload&tmpl=component&' . $session->getName() . '=' . $session->getId() . '&pop_up=1&' . JSession::getFormToken() . '=1&flag=jsn_imageshow';
		$this->assignRef('action', $url);
		$this->assignRef('session', $session);
		$this->assignRef('state', $state);
		$this->assignRef('folderList', $folderList);
		parent::display($tpl);
	}
}
