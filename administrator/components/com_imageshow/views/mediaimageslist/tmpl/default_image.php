<?php
/**
 * @author JoomlaShine.com Team
 * @copyright JoomlaShine.com
 * @link joomlashine.com
 * @package JSN ImageShow
 * @version $Id: default_image.php 6505 2011-05-31 11:01:31Z trungnq $
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');
?>
<div class="item jsn-graphic">
	<a
		href="javascript:JSNISImageManager.populateFields('<?php echo $this->_tmp_img->path_relative; ?>')">
		<img
		src="<?php echo $this->baseURL.'/'.$this->_tmp_img->path_relative; ?>"
		class="jsn-graphic-showcase"
		width="<?php echo $this->_tmp_img->width_60; ?>"
		height="<?php echo $this->_tmp_img->height_60; ?>"
		alt="<?php echo $this->_tmp_img->name; ?> - <?php echo JHtmlNumber::bytes($this->_tmp_img->size); ?>" />
		<span><?php echo $this->_tmp_img->name; ?> </span> </a>
</div>
