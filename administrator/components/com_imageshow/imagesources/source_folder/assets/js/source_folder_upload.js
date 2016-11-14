(function($) {
    $(document).ready(function(){
    	var language = $.parseJSON( lang );
		$('button.upload-image-local').click(function(){
			var iframeID 	= 'iframe-upload-image-modal';
			var link = baseUrl + "administrator/index.php?option=com_imageshow&view=media&flag=jsn_imageshow&tmpl=component";			
			var modalUploadImage = new $.JSNISUIWindow(link,{
				width: $(window).width()*0.6,
				height: $(window).height()*0.6,
				title: language.FOLDER_SOURCE_UPLOAD_IMAGE_MODAL_TITLE,
				scrollContent: true,
				frameID: iframeID,
				buttons:
				[
					{
						text: language.JSN_IMAGESHOW_CANCEL,
						click: function (){
							$(this).dialog('close');
						}
					}
				],
			});	
		});
	});
})((typeof JoomlaShine != 'undefined' && typeof JoomlaShine.jQuery != 'undefined') ? JoomlaShine.jQuery : jQuery);
