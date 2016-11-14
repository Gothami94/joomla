<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');

?>

	<form method="post" name="adminForm" id="adminForm">
		<input type="hidden" name="task" value="unblock" />
		<?php echo JHtml::_('form.token'); ?>
		<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<table class="adminlist table table-striped">
			<thead><?php echo $this->loadTemplate('head'); ?></thead>
			<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
			<tbody><?php echo $this->loadTemplate('body');?></tbody>
		</table>
	</form>
