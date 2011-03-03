<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

// *********************************************
// *    Plugin:  "AN Site Map"                 *
// *      header.main Part                     *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Naty Studio  2009     *
// *********************************************

if (!defined('COT_CODE')) { die('Wrong URL.'); }

if (defined('COT_ADMIN') && $p == 'an_sitemap'){
	cot_rc_link_file($cfg["plugins_dir"].'/an_sitemap/js/an_sitemap.admin.js');
}
?>