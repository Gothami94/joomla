SET QUOTED_IDENTIFIER ON;
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[#__imageshow_theme_carousel]') AND type in (N'U'))
BEGIN
EXEC sp_RENAME '#__imageshow_theme_carousel.caption_css', 'caption_title_css' , 'COLUMN'
ALTER TABLE [#__imageshow_theme_carousel]
ADD 
	[diameter] [nvarchar](150) DEFAULT '50',
	[image_border_thickness] [nvarchar](150) DEFAULT '5',
	[image_border_color] [nvarchar](150) DEFAULT '#666666',
	[caption_background_color] [nvarchar](150) DEFAULT '#000000',
	[caption_show_title] [nvarchar](150) DEFAULT 'yes',
	[caption_show_description] [nvarchar](150) DEFAULT 'yes',
	[caption_description_length_limitation] [nvarchar](150) DEFAULT '50',
	[caption_description_css] [nvarchar](150) DEFAULT '',
	[navigation_presentation] [nvarchar](150) DEFAULT 'show'
END;