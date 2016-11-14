<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.database.table');

class BfstopTableWhiteip extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__bfstop_whitelist', 'id', $db);
	}
}
