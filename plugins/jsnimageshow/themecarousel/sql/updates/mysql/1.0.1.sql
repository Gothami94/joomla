ALTER TABLE `#__imageshow_theme_carousel`
DROP COLUMN `caption_css`,
ADD COLUMN `diameter` char(150) DEFAULT '50',
ADD COLUMN `image_border_thickness` char(150) DEFAULT '5',
ADD COLUMN `image_border_color` char(150) DEFAULT '',
ADD COLUMN `caption_background_color` char(150) DEFAULT '',
ADD COLUMN `caption_show_title` char(150) DEFAULT 'yes',
ADD COLUMN `caption_title_css` text,
ADD COLUMN `caption_show_description` char(150) DEFAULT 'yes',
ADD COLUMN `caption_description_length_limitation` char(150) DEFAULT '50',
ADD COLUMN `caption_description_css` text,
ADD COLUMN `navigation_presentation` char(150) DEFAULT 'show';
