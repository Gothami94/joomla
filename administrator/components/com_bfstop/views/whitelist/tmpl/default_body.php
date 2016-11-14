<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;
foreach ($this->items as $i => $item): ?>
<tr>
	<td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
	<td><?php echo $item->id; ?></td>
	<td><a href="<?php echo BFStopLinkHelper::getIpInfoLink($item->ipaddress);?>"><?php echo $item->ipaddress; ?></a></td>
	<td><?php echo $item->crdate; ?></td>
</tr>
<?php endforeach;
