IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[#__imageshow_images]') AND type in (N'U'))
BEGIN
ALTER TABLE [#__imageshow_images] ADD [image_alt_text] [nvarchar](max) DEFAULT ''
END;