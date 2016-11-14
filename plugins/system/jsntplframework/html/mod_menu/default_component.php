<?php
/**
 * @version		$Id: default_component.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

global $jsn_richmenu_separator;
$app 		= JFactory::getApplication();
$jsnUtils 	= JSNTplUtils::getInstance();
$menus		= $app->getMenu();
$menu 		= $menus->getActive();
$class 		= ''; 

// Note. It is important to remove spaces between elements.
if ($item->id == $active_id) {
	$class .= ' current';
}
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ? 
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
} 
else { $linktype = $item->title;}

if (!$item->anchor_title && strpos($class_sfx, 'menu-richmenu') !== false) {
	$class = "jsn-nodescription ".trim($class);
}
switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo ($class)? 'class="'.trim($class).'"' : ''; ?> href="<?php echo $item->flink; ?>" <?php echo $title; ?>>
	<span>
		<?php 			
		if ($item->anchor_title) {
			echo '<span class="jsn-menutitle">'.$linktype.'</span>';
			echo '<span class="jsn-menudescription">'.$item->anchor_title.'</span>';		
		} else {
			echo $linktype;
		}
		?>
	</span>
</a><?php
		break;
	case 1:
		// _blank
?><a class="<?php echo $class; ?>" href="<?php echo $item->flink; ?>" target="_blank" <?php echo $title; ?>>
	<span>
		<?php 			
			if ($item->anchor_title) {
				echo '<span class="jsn-menutitle">'.$linktype.'</span>';
				echo '<span class="jsn-menudescription">'.$item->anchor_title.'</span>';		
			} else {
				echo $linktype;
			}
		?>
	</span>
</a><?php
		break;
	case 2:
		// window.open
?><a class="<?php echo $class; ?>" href="<?php echo $item->flink ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;" <?php echo $title; ?>>
	<span>
		<?php 			
			if ($item->anchor_title) {
				echo '<span class="jsn-menutitle">'.$linktype.'</span>';
				echo '<span class="jsn-menudescription">'.$item->anchor_title.'</span>';		
			} else {
				echo $linktype;
			}
		?>
	</span>
</a><?php
		break;
endswitch;
