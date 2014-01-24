ALTER TABLE dmsp_download
ADD filter_type varchar(100);

CREATE TABLE IF NOT EXISTS `dmsp_guidelines_downloaded` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `download_id` int(11) NOT NULL,
  `guideline_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;