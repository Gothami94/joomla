SET QUOTED_IDENTIFIER ON;
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[#__imageshow_theme_carousel]') AND type in (N'U'))
BEGIN
DROP TABLE #__imageshow_theme_carousel
END;
