<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'
                .DIRECTORY_SEPARATOR.'system'
                .DIRECTORY_SEPARATOR.'bfstop'
                .DIRECTORY_SEPARATOR.'helpers'
                .DIRECTORY_SEPARATOR.'db.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'
                .DIRECTORY_SEPARATOR.'system'
                .DIRECTORY_SEPARATOR.'bfstop'
                .DIRECTORY_SEPARATOR.'helpers'
                .DIRECTORY_SEPARATOR.'log.php');

function getLogger()
{
	$plugin = JPluginHelper::getPlugin('system', 'bfstop');
	$params = new JRegistry($plugin->params);
	$loglevel = $params->get('logLevel', JLog::ERROR);
	return new BFStopLogger($loglevel);
}
