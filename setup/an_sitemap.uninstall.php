<?php

$an_sitemap_db_struct = $db_x ."ansitemap_struct";
$an_sitemap_db_add_urls = $db_x ."ansitemap_add_urls";

$sql = "DROP TABLE IF EXISTS `$an_sitemap_db_struct`, `$an_sitemap_db_add_urls` ";
$sql = $db->query($sql);

?>
