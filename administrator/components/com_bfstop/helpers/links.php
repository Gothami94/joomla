<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

class BFStopLinkHelper
{
	public function getIpInfoLink($ipaddress)
	{
		$menuId = JRequest::getInt('Itemid');
		$link = 'index.php?option=com_bfstop&Itemid='.$menuId.'&view=ipinfo&ipaddress='.$ipaddress;	
		return $link;
	}
}
