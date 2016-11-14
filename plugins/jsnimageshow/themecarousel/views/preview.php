<?php
/**
 * @version     $Id$
 * @package     JSN.ImageShow
 * @subpackage  JSN.ThemeCarousel
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) @JOOMLASHINECOPYRIGHTYEAR@ JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.plugin.plugin' );
?>
<div id="jsn-themecarousel-container" class="jsn-themecarousel-container">
	<ul id="jsn-themecarousel-gallery">
	<?php
		$i = 1;
		$directory	= JPATH_PLUGINS.DS.'jsnimageshow'.DS.'themecarousel'.DS.'assets'.DS.'images'.DS.'thumb'.DS;
		$path		= '../plugins/jsnimageshow/themecarousel/assets/images/thumb/';
		$type=Array(1 => 'jpg', 2 => 'jpeg', 3 => 'png', 4 => 'gif');
		if ($handle = opendir($directory)) {
		    while (false !== ($entry = readdir($handle))) {
		    	$ext = explode(".",$entry);
				if ($entry != "." && $entry != ".." && in_array($ext[1],$type)) {
	?>
		<li><img src="<?php echo $path.$entry;?>"/></li>
	<?php
		            $i++;
		        }
		    }
		    closedir($handle);
		}
	?>
	</ul>
 	<span id="jsn_carousel_prev_button"></span>
 	<span id="jsn_carousel_next_button"></span>
</div>