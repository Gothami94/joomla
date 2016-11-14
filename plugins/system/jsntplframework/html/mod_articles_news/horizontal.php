<?php
/**
 * @version		$Id: horizontal.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
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
<?php if (!$jsnUtils->isJoomla3()): ?>
<div class="jsn-mod-newsflash jsn-horizontal-container">
<?php $column_width = 99.9/count($list); ?>
<?php for ($i = 0, $n = count($list); $i < $n; $i ++) :
	$item = $list[$i]; ?>
	<div class="jsn-article-container" style="float: left; width: <?php echo $column_width;?>%;">
	<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item');

	if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) : ?>
	<?php endif; ?>
	</div>
<?php endfor; ?>
</div>
<?php else : ?>
<ul class="newsflash-horiz<?php echo $params->get('moduleclass_sfx'); ?>">
<?php for ($i = 0, $n = count($list); $i < $n; $i ++) :
	$item = $list[$i]; ?>
	<li>
	<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item');

	if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) : ?>

	<span class="article-separator">&#160;</span>

	<?php endif; ?>
	</li>
<?php endfor; ?>
</ul>
<?php endif; ?>