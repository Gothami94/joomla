<?php
/**
 * @version    $Id: view_j25.php 17915 2012-11-02 09:33:11Z cuongnm $
 * @package    JSN_Sample
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2015 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla library
jimport('joomla.application.component.view');

/**
 * Base view class for use across JSN libraries and extensions.
 *
 * @package  JSN_Sample
 * @since    1.1.0
 */
class JSNBaseView extends JView
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  Exception object if there is any failure, otherwise nothing is returned.
	 */
	public function display($tpl = null)
	{
		// Load assets
		! class_exists('JSNBaseHelper') OR JSNBaseHelper::loadAssets();

		return parent::display($tpl);
	}
}
