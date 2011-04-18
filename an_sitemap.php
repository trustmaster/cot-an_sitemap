<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]

==================== */
// *********************************************
// *    Plugin AN Site Map                     *
// *       HTML Site map out                   *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
defined('COT_CODE') or die('Wrong URL.');
define(DS, DIRECTORY_SEPARATOR);										// Разделитель папок в пути к папке

require_once cot_langfile('an_sitemap', 'plug');
require_once cot_incfile('an_sitemap', 'plug', 'class');

$plugin_base_url = $cfg['mainurl'].getRelativeURL(dirname(__FILE__));
$out['meta_desc'] = $L['an_sitemap']['plu_subtitle'];
$out['meta_keywords'] = $L['an_sitemap']['plu_meta_keywords'];

$out['subtitle'] = $L['an_sitemap']['plu_title'];

$sitemap = new an_sitemap();	
$sitemap->html_sitemap_out($t);
	
$t->assign(array(	
	"PLUGIN_TITLE" => $L['an_sitemap']['plu_title'],
	));

?>