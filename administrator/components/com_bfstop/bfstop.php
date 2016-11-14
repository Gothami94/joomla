<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

JLoader::register('BfstopHelper', dirname(__FILE__).
	DIRECTORY_SEPARATOR.'helpers'.
	DIRECTORY_SEPARATOR.'bfstop.php');

jimport('joomla.application.component.controller');
require_once(JPATH_ADMINISTRATOR
		.DIRECTORY_SEPARATOR.'components'
		.DIRECTORY_SEPARATOR.'com_bfstop'
                .DIRECTORY_SEPARATOR.'helpers'
                .DIRECTORY_SEPARATOR.'log.php');

$controller = JControllerLegacy::getInstance('bfstop');
$jinput = JFactory::getApplication()->input;
$task = $jinput->get('task', "", 'STR');
$controller->execute($task);
$controller->redirect();
