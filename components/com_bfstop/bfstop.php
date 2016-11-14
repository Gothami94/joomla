<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Direct Access to this script is not allowed.');

// Require base controller:
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('bfstop');

$controller->execute( JRequest::getCmd('task') );
$controller->redirect();

