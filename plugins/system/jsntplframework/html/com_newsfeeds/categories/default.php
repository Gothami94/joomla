<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_newsfeeds
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
$app 		= JFactory::getApplication();
$template 	= $app->getTemplate();
$jsnUtils   = JSNTplUtils::getInstance();
if ($jsnUtils->isJoomla3()):
JHtml::_('behavior.caption');

JFactory::getDocument()->addScriptDeclaration("
jQuery(function($) {
	$('.categories-list').find('[id^=category-btn-]').each(function(index, btn) {
		var btn = $(btn);
		btn.on('click', function() {
			btn.find('span').toggleClass('icon-plus');
			btn.find('span').toggleClass('icon-minus');
		});
	});
});");
?>
<div class="categories-list<?php echo $this->pageclass_sfx;?>">
	<?php
		echo JLayoutHelper::render('joomla.content.categories_default', $this);
		echo $this->loadTemplate('items');
	?>
</div>
<?php else : ?>
<div class="com-newsfeed <?php echo $this->pageclass_sfx; ?>">
	<div class="category-list">	
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h2 class="componentheading">
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h2>
		<?php endif; ?>

		<?php if ($this->params->get('show_base_description')) : ?>
		<?php 	//If there is a description in the menu parameters use that; ?>
					<?php if($this->params->get('categories_description')) : ?>
				<div class="contentdescription clearafter">
					<?php echo  JHtml::_('content.prepare',$this->params->get('categories_description')); ?>
				</div>
			<?php  else: ?>
				<?php //Otherwise get one from the database if it exists. ?>
				<?php  if ($this->parent->description) : ?>
					<div class="contentdescription clearafter">
						<?php  echo JHtml::_('content.prepare', $this->parent->description); ?>
					</div>
				<?php  endif; ?>
			<?php  endif; ?>
		<?php endif; ?>
		<?php 
			echo $this->loadTemplate('items');
		?>
		<div class="clearbreak"></div>
	</div>
</div>
<?php endif; ?>