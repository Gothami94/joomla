<?php
/**
 * @author JoomlaShine.com Team
 * @copyright JoomlaShine.com
 * @link joomlashine.com
 * @package JSN ImageShow
 * @version $Id: default.php 16647 2012-10-03 10:06:41Z giangnd $
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');
$act = JRequest::getCmd('act','custom');

?>
<!--[if IE 7]>
	<link href="<?php echo JURI::base();?>components/com_imageshow/assets/css/fixie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type='text/javascript'>
var image_base_path = 'images/';
<?php if($act =='showlist'){?>
var image_base_path = 'images/';
window.addEvent('domready', function(){
	$('f_url').value ='';
	$('f_url').value = window.parent.$('alter_image_path').value;
});
<?php }?>

</script>
<div class="jsn-predefine-bg-selection">
	<h3 class="jsn-section-header">
	<?php
	if($act =='custom'){
		echo JText::_('MEDIA_SELECT_CUSTOM_GRAPHIC');
	}
	if($act == 'showlist'){
		echo JText::_('MEDIA_SELECT_IMAGE');
	}

	?>
	</h3>
	<fieldset class="jsn-url-properties" style="<?php echo ($act =='custom' || $act =='watermark' || $act =='showlist')? '': 'display:none;';?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td nowrap="nowrap">
					<form action="<?php echo $this->action; ?>" style="<?php echo ($act =='custom' || $act =='watermark' || $act =='showlist')? '': 'display:none;';?>" id="uploadForm" method="post" enctype="multipart/form-data">
						<label for="folder"><?php echo JText::_('Upload') ?>:&nbsp;</label>
						<input type="file" id="file-upload" name="Filedata" size="68" />
						<button type="submit" id="file-upload-submit"
							title="<?php echo htmlspecialchars(JText::_('MEDIA_START_UPLOAD')); ?>">
							<?php echo JText::_('MEDIA_START_UPLOAD'); ?>
						</button>
						<span id="upload-clear"></span> <input type="hidden"
							name="return-url"
							value="<?php echo base64_encode('index.php?option=com_imageshow&controller=media&act='.$act.'&tmpl=component&e_name='.JRequest::getCmd('e_name')); ?>" />
					</form>
				</td>
			</tr>
		</table>
	</fieldset>
	<fieldset class="jsn-url-properties" style="<?php echo ($act =='custom' || $act =='watermark' || $act =='showlist')? '': 'display:none;';?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td nowrap="nowrap">
					<form action="index.php" id="imageForm" method="post"
						enctype="multipart/form-data">
						<div style="float: left; <?php echo ($act =='custom' || $act =='watermark' || $act =='showlist')? '': 'display:none;';?>">
							<label for="folder"><?php echo JText::_('Directory') ?>:&nbsp;</label>
							<?php echo $this->folderList; ?>
							&nbsp;
							<button type="button" id="upbutton"
								title="<?php echo htmlspecialchars(JText::_('MEDIA_DIRECTORY_UP')) ?>">
								<?php echo JText::_('MEDIA_UP') ?>
							</button>
						</div>
					</form>
				</td>
			</tr>
		</table>
	</fieldset>
	<div class="jsn-image-folder-list">
		<iframe id="imageframe" name="imageframe"
			src="index.php?option=com_imageshow&amp;flag=jsn_imageshow&amp;controller=media&amp;view=imageslist&amp;act=<?php echo $act; ?>&amp;tmpl=component&amp;folder=<?php echo $this->state; ?>"></iframe>
	</div>
	<form action="index.php" id="imageForm" method="post"
		enctype="multipart/form-data">
		<div id="messages" style="display: none;">
			<span id="message"></span>
		</div>
		<fieldset class="jsn-image-url">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td nowrap="nowrap"><label for="f_url"><?php echo JText::_('MEDIA_IMAGE_URL') ?>&nbsp;</label>
					</td>
					<td width="100%"><input type="text" id="f_url" value=""
						readonly="readonly" /></td>
				</tr>
			</table>
		</fieldset>
		<div class="button">
			<button type="button"
				onclick="JSNISImageManager.onok('<?php echo $act?>');window.top.setTimeout('SqueezeBox.close()', 200);">
				<?php echo JText::_('MEDIA_SELECT') ?>
			</button>
			<button type="button"
				onclick="window.top.setTimeout('SqueezeBox.close()', 200);">
				<?php echo JText::_('MEDIA_CANCEL') ?>
			</button>
		</div>
		<input type="hidden" id="dirPath" name="dirPath" /> <input
			type="hidden" id="f_file" name="f_file" /> <input type="hidden"
			id="tmpl" name="component" />
	</form>
</div>
