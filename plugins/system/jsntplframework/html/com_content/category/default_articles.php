<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$app 		= JFactory::getApplication();
$template 	= $app->getTemplate();
$jsnUtils   = JSNTplUtils::getInstance();

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Create some shortcuts.
$params		= &$this->item->params;
$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<?php if (!$jsnUtils->isJoomla3()):
	JHtml::_('behavior.tooltip');
	JHtml::_('behavior.framework');
	if (empty($this->items)) :
		if ($this->params->get('show_no_articles',1)) :
	?>
		<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
<?php if (!$jsnUtils->isJoomla3()): ?>
<form action="<?php echo JFilterOutput::ampReplace(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (($this->params->get('filter_field') != 'hide') || ($this->params->get('show_pagination_limit'))) : ?>
	<div class="jsn-infofilter">
		<?php if ($this->params->get('filter_field') != 'hide') : ?>
		<span class="jsn-titlefilter">
		<label class="filter-search-lbl" for="filter-search"><?php echo JText::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL').'&#160;'; ?></label>
		<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
		</span>
		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
		<span class="jsn-filter-limit"> <?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160; <?php echo $this->pagination->getLimitBox(); ?> </span>
		<?php endif; ?>     
	</div>
	<?php endif; ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="jsn-infotable">
		<?php if ($this->params->get('show_headings')) :?>
		<tr class="jsn-tableheader">
			<td class="sectiontableheader jsn-table-column-order" width="" align="center"><?php echo JText::_('JGLOBAL_NUM'); ?></td>
			<td class="sectiontableheader jsn-table-column-title"><?php  echo JHTML::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder) ; ?></td>
			<?php if ($this->params->get('list_show_author',1)) : ?>
			<td class="sectiontableheader jsn-table-column-author" width="30%"><?php echo JHTML::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?></td>
			<?php endif; ?>
			<?php if ($date = $this->params->get('list_show_date')) : ?>
			<td class="sectiontableheader jsn-table-column-date" width="20%"><?php echo JHTML::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.created', $listDirn, $listOrder); ?></td>
			<?php endif; ?>
			<?php if ($this->params->get('list_show_hits',1)) : ?>
			<td class="sectiontableheader jsn-table-column-hits" width="" align="center"><?php echo JHTML::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?></td>
			<?php endif; ?>
		</tr>
		<?php endif; ?>
		<?php foreach ($this->items as $i => $article) : ?>
		<?php if ($this->items[$i]->state == 0) : ?>
		<tr class="system-unpublished sectiontableentry<?php echo $i % 2 +1; ?>">
			<?php else: ?>
		<tr class="sectiontableentry<?php echo $i % 2 +1; ?>">
			<?php endif; ?>
			<td class="jsn-table-column-order" width="" align="center"><?php echo $this->pagination->getRowOffset( $i ); ?></td>
			<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
			<td class="jsn-table-column-title"><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid)); ?>"> <?php echo $this->escape($article->title); ?> </a>
				<?php if ($article->params->get('access-edit')) : ?>
				<span class="icon-edit"><?php echo JHtml::_('icon.edit',$article, $params); ?></span>
				<?php endif; ?></td>
			<?php if ($this->params->get('list_show_author',1)) : ?>
			<td class="jsn-table-column-author"><?php $author =  $article->author ?>
				<?php $author = ($article->created_by_alias ? $article->created_by_alias : $author);?>
				<?php if (!empty($article->contactid ) &&  $this->params->get('link_author') == true):?>
				<?php echo JHTML::_(
										'link',
										JRoute::_('index.php?option=com_contact&view=contact&id='.$article->contactid),
										$author
								); ?>
				<?php else :?>
				<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
				<?php endif; ?></td>
				<?php endif; ?>
			<?php if ($this->params->get('list_show_date')) : ?>
			<td class="jsn-table-column-date"><?php echo JHTML::_('date',$article->displayDate, $this->escape(
				$this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))); ?></td>
			<?php endif; ?>
			<?php if ($this->params->get('list_show_hits',1)) : ?>
			<td class="jsn-table-column-hits" width="" align="center"><?php echo $article->hits; ?></td>
			<?php endif; ?>
			<?php else : // Show unauth links. ?>
				<td>
					<?php
						echo $this->escape($article->title).' : ';
						$menu		= JFactory::getApplication()->getMenu();
						$active		= $menu->getActive();
						$itemId		= $active->id;
						$link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$itemId);
						$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug));
						$fullURL = new JURI($link);
						$fullURL->setVar('return', base64_encode($returnURL));
					?>
					<a href="<?php echo $fullURL; ?>" class="register">
						<?php echo JText::_( 'COM_CONTENT_REGISTER_TO_READ_MORE' ); ?></a>
				</td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<div class="jsn-pagination-container"> <?php echo $this->pagination->getPagesLinks(); ?>
		<p class="jsn-pageinfo"><?php echo $this->pagination->getPagesCounter(); ?></p>
	</div>
	<?php endif; ?>
	<!-- @TODO add hidden inputs -->
	<input type="hidden" name="filter_order" value="" />
	<input type="hidden" name="filter_order_Dir" value="" />
	<input type="hidden" name="limitstart" value="" />
</form>
<?php else : ?>
<?php
// check for at least one editable article
$isEditable = false;
if (!empty($this->items))
{
	foreach ($this->items as $article)
	{
		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}
}
?>
<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<?php if ($this->params->get('show_headings') || $this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
	<fieldset class="filters btn-toolbar clearfix">
		<?php if ($this->params->get('filter_field') != 'hide') :?>
			<div class="btn-group">
				<label class="filter-search-lbl element-invisible" for="filter-search">
					<?php echo JText::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL').'&#160;'; ?>
				</label>
				<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL'); ?>" />
			</div>
		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="btn-group pull-right">
				<label for="limit" class="element-invisible">
					<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
				</label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		<?php endif; ?>

		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
		<input type="hidden" name="task" value="" />
	</fieldset>
	<?php endif; ?>

	<table class="category table table-striped table-bordered table-hover">
		<?php
		$headerTitle    = '';
		$headerDate     = '';
		$headerAuthor   = '';
		$headerHits     = '';
		$headerEdit     = '';
		?>
		<?php if ($this->params->get('show_headings')) : ?>
			<?php
			$headerTitle    = 'headers="categorylist_header_title"';
			$headerDate     = 'headers="categorylist_header_date"';
			$headerAuthor   = 'headers="categorylist_header_author"';
			$headerHits     = 'headers="categorylist_header_hits"';
			$headerEdit     = 'headers="categorylist_header_edit"';
			?>
		<thead>
			<tr>
				<th id="categorylist_header_title">
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>
				<?php if ($date = $this->params->get('list_show_date')) : ?>
					<th id="categorylist_header_date">
						<?php if ($date == "created") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.created', $listDirn, $listOrder); ?>
						<?php elseif ($date == "modified") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.modified', $listDirn, $listOrder); ?>
						<?php elseif ($date == "published") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
						<?php endif; ?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_author')) : ?>
					<th id="categorylist_header_author">
						<?php echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_hits')) : ?>
					<th id="categorylist_header_hits">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
					</th>
				<?php endif; ?>
				<?php if ($isEditable) : ?>
					<th id="categorylist_header_edit"><?php echo JText::_('COM_CONTENT_EDIT_ITEM'); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<?php endif; ?>
		<tbody>
			<?php foreach ($this->items as $i => $article) : ?>
				<?php if ($this->items[$i]->state == 0) : ?>
				 <tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
				<?php else: ?>
				<tr class="cat-list-row<?php echo $i % 2; ?>" >
				<?php endif; ?>
					<td <?php echo $headerTitle; ?> class="list-title">
						<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
							<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>">
								<?php echo $this->escape($article->title); ?>
							</a>
						<?php else: ?>
							<?php
							echo $this->escape($article->title) . ' : ';
							$menu		= JFactory::getApplication()->getMenu();
							$active		= $menu->getActive();
							$itemId		= $active->id;
							$link = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
							$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language));
							$fullURL = new JUri($link);
							$fullURL->setVar('return', base64_encode($returnURL));
							?>
							<a href="<?php echo $fullURL; ?>" class="register">
								<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
							</a>
						<?php endif; ?>
						<?php if ($article->state == 0) : ?>
							<span class="list-published label label-warning">
								<?php echo JText::_('JUNPUBLISHED'); ?>
							</span>
						<?php endif; ?>
						<?php if (strtotime($article->publish_up) > strtotime(JFactory::getDate())) : ?>
							<span class="list-published label label-warning">
								<?php echo JText::_('JNOTPUBLISHEDYET'); ?>
							</span>
						<?php endif; ?>
						<?php if ((strtotime($article->publish_down) < strtotime(JFactory::getDate())) && $article->publish_down != JFactory::getDbo()->getNullDate()) : ?>
							<span class="list-published label label-warning">
								<?php echo JText::_('JEXPIRED'); ?>
							</span>
						<?php endif; ?>
					</td>
					<?php if ($this->params->get('list_show_date')) : ?>
						<td <?php echo $headerDate; ?> class="list-date small">
							<?php
							echo JHtml::_(
								'date', $article->displayDate,
								$this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))
							); ?>
						</td>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_author', 1)) : ?>
						<td <?php echo $headerAuthor; ?> class="list-author">
							<?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>
								<?php $author = $article->author ?>
								<?php $author = ($article->created_by_alias ? $article->created_by_alias : $author);?>
								<?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) : ?>
									<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $article->contact_link, $author)); ?>
								<?php else: ?>
									<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_hits', 1)) : ?>
						<td <?php echo $headerHits; ?> class="list-hits">
							<span class="badge badge-info">
								<?php echo JText::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
							</span>
						</td>
					<?php endif; ?>
					<?php if ($isEditable) : ?>
						<td <?php echo $headerEdit; ?> class="list-edit">
							<?php if ($article->params->get('access-edit')) : ?>
								<?php echo JHtml::_('icon.edit', $article, $params); ?>
							<?php endif; ?>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<?php // Code to add a link to submit an article. ?>
<?php if ($this->category->getParams()->get('access-create')) : ?>
	<?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?>
<?php  endif; ?>

<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
	<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && (isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1)) : ?>
	<div class="center">

		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php endif; ?>

		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
</form>
<?php endif; ?>
