SET QUOTED_IDENTIFIER ON;
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[#__imageshow_theme_classic_javascript]') AND type in (N'U'))
BEGIN
ALTER TABLE [#__imageshow_theme_classic_javascript]
ADD
	[infopanel_show_link_title] [nvarchar](30) DEFAULT 'no',
	[infopanel_show_link_title_in] [nvarchar](30) DEFAULT 'new-browser',
END;