<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wrapper
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Load template framework
if (!defined('JSN_PATH_TPLFRAMEWORK')) {
	require_once JPATH_ROOT . '/plugins/system/jsntplframework/jsntplframework.defines.php';
	require_once JPATH_ROOT . '/plugins/system/jsntplframework/libraries/joomlashine/loader.php';
}

$app 		= JFactory::getApplication();
$template 	= $app->getTemplate();
$jsnUtils   = JSNTplUtils::getInstance();
?>
<script type="text/javascript">
function iFrameHeight() {
	var h = 0;
	if (!document.all) {
		h = document.getElementById('blockrandom').contentDocument.height;
		document.getElementById('blockrandom').style.height = h + 60 + 'px';
	} else if (document.all) {
		h = document.frames('blockrandom').document.body.scrollHeight;
		document.all.blockrandom.style.height = h + 20 + 'px';
	}
}
</script>
<div class="contentpane<?php echo $this->pageclass_sfx; ?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h2 class="componentheading <?php echo $this->pageclass_sfx; ?>">
		<?php if ($this->escape($this->params->get('page_heading'))) :?>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		<?php else : ?>
			<?php echo $this->escape($this->params->get('page_title')); ?>
		<?php endif; ?>
	</h2>
<?php endif; ?>
<iframe <?php echo $this->wrapper->load; ?>
	id="blockrandom"
	name="iframe"
	src="<?php echo $this->escape($this->wrapper->url); ?>"
	width="<?php echo $this->escape($this->params->get('width')); ?>"
	height="<?php echo $this->escape($this->params->get('height')); ?>"
	scrolling="<?php echo $this->escape($this->params->get('scrolling')); ?>"
<?php if ($jsnUtils->isJoomla3()): ?>
frameborder="<?php echo $this->escape($this->params->get('frameborder', 1)); ?>"
<?php endif; ?>
	class="wrapper<?php echo $this->pageclass_sfx; ?>">
	<?php echo JText::_('COM_WRAPPER_NO_IFRAMES'); ?>
</iframe>
</div>
