<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

// *********************************************
// *    Plugin AN Site Map                     *
// *       XML and TXT maps                    *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *           ©  Alex & Natty Studio  2010    *
// *********************************************

if ( !defined('COT_CODE') OR !defined('COT_PLUG') ) { die("Wrong URL."); }
define(DS, DIRECTORY_SEPARATOR);										// Разделитель папок в пути к папке

require_once cot_langfile('an_sitemap', 'plug');
require_once cot_incfile('an_sitemap', 'plug');
require_once cot_incfile('an_sitemap', 'plug', 'class');

$out = cot_import('out','G','TXT');
if (empty($out)) $out = 'xml';

$sitemap = new an_sitemap();	

switch($out){
	case 'txt':
		header('Content-Type: text/plain; charset=utf-8');
		echo $sitemap -> out_txt_map();
		break;
	
	case 'xml_index':
	default:
		ob_clean();
		header('Content-Type: application/xml; charset=utf-8');
		echo $sitemap -> out_xml_index();
		break;
	
	case 'xml':
	default:
		ob_clean();
		header('Content-Type: application/xml; charset=utf-8');
		echo $sitemap -> out_xml_map();
		break;
}

die;
?>