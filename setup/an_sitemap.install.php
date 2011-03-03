<?php

$an_sitemap_db_struct = $db_x ."ansitemap_struct";
$an_sitemap_db_add_urls = $db_x ."ansitemap_add_urls";

$sql = "CREATE TABLE IF NOT EXISTS `$an_sitemap_db_struct` (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`area` VARCHAR( 255 ) NOT NULL ,
		`code` VARCHAR( 255 ) NOT NULL ,
		`state` VARCHAR( 10 ) NOT NULL ,
		`default` varchar(10) NOT NULL
	) ENGINE = MYISAM DEFAULT CHARSET={$cfg['mysqlcharset']} COMMENT = 'AN SiteMap';";

$sql = $db->query($sql);

// Добавление тестовых данных только если их нет!!!
$sql = "SELECT COUNT(*) FROM $an_sitemap_db_struct WHERE area='integrators' AND code='test'";
$total = $db->query($sql)->fetchColumn();

if ($total==0){
	$sql = "INSERT INTO `$an_sitemap_db_struct` (`area`, `code`, `state`, `default`) VALUES
			('lists', 'system', 'no', 'no'),
			('integrators', 'test', 'no', 'no') ; ";
	$sql = $db->query($sql);
}


$sql = "CREATE TABLE IF NOT EXISTS `$an_sitemap_db_add_urls` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) NOT NULL,
		  `loc` tinytext NOT NULL,
		  `priority` float NOT NULL,
		  `lastmod` varchar(30) NOT NULL,
		  `changefreq` varchar(10) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  `state` VARCHAR( 10 ) NOT NULL ,
		  `order` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET={$cfg['mysqlcharset']} COMMENT='An sitemap additional links';";

$sql = $db->query($sql);

?>
