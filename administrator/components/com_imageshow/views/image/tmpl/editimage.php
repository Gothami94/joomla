<?php
/**
 * @version    $Id: view.html.php 16077 2012-09-17 02:30:25Z giangnd $
 * @package    JSN.ImageShow
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2015 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

defined('_JEXEC') or die('Restricted access');

$sourceType = JRequest::getVar('sourceType');
$baseurl 	= ($sourceType == 'external') ? '' : JURI::root();
?>
<script type="text/javascript">
	var JSNISLinkWindow;
	var imageLinkID = '';
	require(['jquery', 'jsn/libs/modal'], function ($, JSNModal) {
		$(function () {

			$('.select-link-edit').click(function() {
				imageLinkID = $(this).attr('name');
				var link = 'index.php?option=com_imageshow&controller=image&task=linkpopup&tmpl=component';
				JSNISLinkWindow = new JSNModal({
					url: link,
					width: $(window).width()*0.9,
					height: $(window).height()*0.85,
					scrollable: true,
					title: '<?php echo JText::_('SHOWLIST_POPUP_IMAGE_CHOOSE_LINK', true); ?>',
					buttons: {
						'<?php echo JText::_('JSN_IMAGESHOW_CANCEL', true); ?>': function (){
							JSNISLinkWindow.close();
						}
					}
				});
				JSNISLinkWindow.iframe.css('overflow-x', 'hidden');
				JSNISLinkWindow.show();
			})   
			    
			tinymce.init({
                selector: 'textarea.description',
                mode : "specific_textareas",
                autosave_restore_when_empty: false,
                skin : "lightgray",
                theme : "modern",
                schema: "html5",
                menubar: false,
                // Cleanup/Output
                inline_styles : true,
                gecko_spellcheck : true,
                entity_encoding : "raw",
                valid_elements : "",
                extended_valid_elements : "iframe|hr[id|title|alt|class|width|size|noshade]",
                force_br_newlines : false, force_p_newlines : true, forced_root_block : 'p',
                toolbar_items_size: "small",
                invalid_elements : "script,applet",
                // Plugins
                plugins : "textcolor",
                // Toolbar
                toolbar1: "bold italic underline strikethrough | forecolor | undo redo | removeformat ",
                
                removed_menuitems: "newdocument",
                // URL
                relative_urls : false,
                remove_script_host : false,
                // Layout
                importcss_append: true,
                // Advanced Options
                resize: "both",
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });			
		});
	});

	function jsnGetMenuItems(id, title, object,link)
	{
		var id = '#item_link';
		if (imageLinkID != '')
		{
			 id = id + '_' + imageLinkID;
		}
		jQuery(id).val(link);
		JSNISLinkWindow.close();
	}

	function jsnGetArticle(id, title, catid, object,link)
	{
		var id = '#item_link';
		if (imageLinkID !='')
		{
			 id = id + '_' + imageLinkID;
		}
		jQuery(id).val(link);
		JSNISLinkWindow.close();
	}
</script>
<div id="edit-item-details" class="jsn-bootstrap">
	<form name="editForm" method="post" action="" id="jsn-is-link-image-form">
		<?php
		$countImage = count($this->image);
		if($countImage > 1)
		{
			?>
		<div class="jsn-section-striped">
		<?php
		for($i=0; $i < $countImage; $i++)
		{
			?>
			<div id="edit-item-details-multiple">
				<div class="jsn-item-details">
					<div class="control-group pull-left">
						<div class="thumbnail jsn-item-thumbnail">
							<img class="jsn-box-shadow-light"
								src="<?php echo $baseurl . $this->image[$i]->image_small;?>"
								name="image" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"><?php echo JText::_('SHOWLIST_EDIT_IMAGE_TITLE');?></label>
						<input type="text" class="jsn-input-medium-fluid title"
							name="title[]" id="item-title"
							value="<?php echo htmlspecialchars($this->image[$i]->image_title);?>" />
						<input type="hidden" name="originalTitle[]"
							value="<?php echo htmlspecialchars($this->image[$i]->image_title);?>" />
					</div>
					<div class="control-group">
						<div class="controls">
							<label class="control-label"><?php echo JText::_('SHOWLIST_EDIT_IMAGE_ALT_TEXT');?></label>
							<input type="text" class="jsn-input-medium-fluid alt-text" name="alt_text[]" id="item-alt-text" value="<?php echo htmlspecialchars($this->image[$i]->image_alt_text);?>" />
							<input type="hidden" name="originalAltText[]" value="<?php echo htmlspecialchars($this->image[$i]->image_alt_text);?>" />
						</div>
					</div>						
					<div class="control-group" style="padding-left: 147px;">
						<label class="control-label"><?php echo JText::_('SHOWLIST_EDIT_IMAGE_DESCRIPTION');?></label>
						<textarea rows="3" class="jsn-input-large-fluid description" id="item-description-<?php echo $i; ?>" name="description[]"><?php echo htmlspecialchars($this->image[$i]->image_description);?></textarea>
						<input type="hidden" name="originalDescription[]" value="<?php echo htmlspecialchars($this->image[$i]->image_description);?>" />
						<div class="input-append">
							<input type="text" class="link" id="item_link_<?php echo $this->image[$i]->image_id;?>" value="<?php echo $this->image[$i]->image_link;?>" name="image_link[]" />
							<input class="btn select-link-edit" type="button" name="<?php echo $this->image[$i]->image_id;?>" value="..." />
						</div>
					</div>
					<input type="hidden" name="originalLink[]"
						value="<?php echo $this->image[$i]->image_link;?>" /> <input
						type="hidden" name="imageID[]"
						value="<?php echo $this->image[$i]->image_id;?>" /> <input
						type="hidden" name="image_extid[]"
						value="<?php echo $this->image[$i]->image_extid;?>" />
					<div class="clearbreak"></div>
				</div>
			</div>
			<?php
		}
		?>
			<input type="hidden" name="numberOfImages"
				value="<?php echo count($this->image);?>" /> <input type="hidden"
				name="showlistID"
				value="<?php echo $this->image[0]->showlist_id ;?>" /> <input
				type="hidden" name="option" value="com_imageshow" /> <input
				type="hidden" name="controller" value="image" /> <input
				type="hidden" name="task" value="apply" />
		</div>
		<?php
		}
		else
		{
			?>
		<div id="edit-item-details-single">
			<div class="jsn-item-details">
				<div class="control-group">
					<div class="thumbnail jsn-item-thumbnail jsn-single-item-thumbnail">
						<img class="jsn-box-shadow-light" src="<?php echo $baseurl . $this->image->image_small;?>" name="image" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo JText::_('SHOWLIST_EDIT_IMAGE_TITLE');?>
					</label>
					<div class="controls">
						<input type="text" class="jsn-input-xxlarge-fluid title" name="title" id="item-title" value="<?php echo htmlspecialchars($this->image->image_title);?>" />
						<input type="hidden" name="originalTitle" value="<?php echo htmlspecialchars($this->image->image_title);?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo JText::_('SHOWLIST_EDIT_IMAGE_ALT_TEXT');?></label>
					<div class="controls">
						<input type="text" class="jsn-input-xxlarge-fluid alt-text" name="alt_text" id="item-alt-text" value="<?php echo htmlspecialchars($this->image->image_alt_text);?>" />
						<input type="hidden" name="originalAltText" value="<?php echo htmlspecialchars($this->image->image_alt_text);?>" />
					</div>
				</div>					
				<div class="control-group">
					<label class="control-label"><?php echo JText::_('SHOWLIST_EDIT_IMAGE_DESCRIPTION');?>
					</label>
					<div class="controls">
						<textarea class="jsn-input-xxlarge-fluid description" rows="5" id="item-description" name="description"><?php echo htmlspecialchars($this->image->image_description);?></textarea>
						<input type="hidden" name="originalDescription" value="<?php echo htmlspecialchars($this->image->image_description);?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo JText::_('SHOWLIST_EDIT_IMAGE_LINK');?>
					</label>
					<div class="controls">
						<div class="input-append">
							<input type="text" id="item_link" class="link" value="<?php echo $this->image->image_link;?>" name="link" />
							<input class="btn select-link-edit" type="button" name="" value="..." />
						</div>
						<input type="hidden" name="originalLink" value="<?php echo $this->image->image_link;?>" />
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="numberOfImages" value="1" />
		<input type="hidden" name="option" value="com_imageshow" />
		<input type="hidden" name="controller" value="image" />
		<input type="hidden" name="task" value="apply" />
		<input type="hidden" name="imageID" value="<?php echo $this->image->image_id;?>" />
		<input type="hidden" name="image_extid" value="<?php echo $this->image->image_extid;?>" />
		<input type="hidden" name="showlistID" value="<?php echo $this->image->showlist_id ;?>" />
		<?php }?>
	</form>
</div>
