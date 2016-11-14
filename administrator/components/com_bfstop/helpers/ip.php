<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;
 
function get_whois($ip)
{
require_once(JPATH_ADMINISTRATOR
                .DIRECTORY_SEPARATOR.'components'
                .DIRECTORY_SEPARATOR.'com_bfstop'
                .DIRECTORY_SEPARATOR.'helpers'
                .DIRECTORY_SEPARATOR.'phpwhois'
                .DIRECTORY_SEPARATOR.'whois.main.php');
require_once(JPATH_ADMINISTRATOR
                .DIRECTORY_SEPARATOR.'components'
                .DIRECTORY_SEPARATOR.'com_bfstop'
                .DIRECTORY_SEPARATOR.'helpers'
                .DIRECTORY_SEPARATOR.'phpwhois'
                .DIRECTORY_SEPARATOR.'whois.utils.php');
	$whois = new Whois();
	$whois->non_icann = true;
	$result = $whois->Lookup($ip);
	$winfo = '';
	if (!empty($result['rawdata']))
	{
		$utils = new utils;
		return $utils->showHTML($result);
	}
	else
	{
		if (isset($whois->Query['errstr']))
			$winfo = implode("\n<br></br>", $whois->Query['errstr']);
		else
			$winfo = 'Unexpected error';
	}
	return $winfo;
}
