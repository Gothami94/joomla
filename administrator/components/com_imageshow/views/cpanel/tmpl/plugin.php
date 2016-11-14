<?php
/**
 * @version    $Id: plugin.php 16077 2012-09-17 02:30:25Z giangnd $
 * @package    JSN.ImageShow
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2015 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$objUtils 	= JSNISFactory::getObj('classes.jsn_is_utils');
$input = JFactory::getApplication()->input;
$showlistID = $input->getInt('showlist_id', 0);
$showcaseID = $input->getInt('showcase_id', 0);

?>

<div class="jsn-plugin-details">
	<div class="jsn-bootstrap">
		<div class="form-search">
		<?php
		echo JText::_('CPANEL_PLEASE_INSERT_FOLLOWING_TEXT_TO_YOUR_ARTICLE_AT_THE_POSITION_WHERE_YOU_WANT_TO_SHOW_GALLERY');
		?>
			<div id="jsn-clipboard">
				<span class="jsn-clipboard-input">
					<input type="text" id="syntax-plugin" name="plugin" value="{imageshow sl=<?php echo $showlistID; ?> sc=<?php echo $showcaseID; ?> /}" />
					
				</span>
			</div>
		</div>
		<?php
		echo JText::_('CPANEL_MORE_DETAILS_ABOUT_PLUGIN_SYNTAX');
		?>
	</div>
</div>
