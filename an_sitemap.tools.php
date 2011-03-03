<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */
// *********************************************
// *    Plugin AN Site Map                     *
// * 		admin part                         *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
if (!defined('COT_CODE')) { die('Wrong URL.'); }

define(PATH_SITE, dirname($_SERVER['SCRIPT_FILENAME']));				// Корень сайта
define(DS, DIRECTORY_SEPARATOR);										// Разделитель папок в пути к папке

require_once(cot_langfile('an_sitemap'));
require_once cot_incfile('an_sitemap', 'plug');
require_once cot_incfile('an_sitemap', 'plug', 'class');
$plugin_base_url = $cfg['mainurl'].getRelativeURL(dirname(__FILE__));	// URL папки с плагином
$plugin_check_ver_page = "<a href=\"http://portal30.ru/page.php?al=cotonti_an_sitemap\" target=\"_blank\" >".$L['an_sitemap']['check_new_ver']."</a>";

$config_url = cot_url('admin', "m=other&p=an_sitemap&task=config");
$srtucture_url = cot_url('admin', "m=other&p=an_sitemap&task=structure");
$add_links_url = cot_url('admin', "m=other&p=an_sitemap&task=addlinks");
$integrators_url = cot_url('admin', "m=other&p=an_sitemap&task=integrators");
$help_url = cot_url('admin', "m=other&p=an_sitemap&task=help");

$task = cot_import('task','G','TXT');
$act = cot_import('act','G','TXT');
if (empty($task)) $task = config;

$tpl = new XTemplate(cot_tplfile('an_sitemap.admin', 'plug'));
$sitemap = new an_sitemap();

switch($task){
	case 'config':
		$tpl -> assign(array('SECTION' => $L['an_sitemap']['config']));
		$sitemap -> show_configuration(&$tpl);
		break;
	
	case 'structure':
		$tpl -> assign(array('SECTION' => $L['an_sitemap']['srtucture']));
		$sitemap -> show_structure(&$tpl);
		break;

        case 'addlinks':
		$tpl -> assign(array('SECTION' => $L['an_sitemap']['add_links']));
		$sitemap -> show_add_url(&$tpl);
		break;
		
	case 'integrators':
		$tpl -> assign(array('SECTION' => $L['an_sitemap']['integrators']));
		$sitemap -> show_integrators(&$tpl);
		break;
	
	case 'help':
		$help_file = '';
		if(@file_exists($cfg["plugins_dir"]."/an_sitemap/lang/help.".$lang.".html")){
		 	$help_file = $cfg["plugins_dir"]."/an_sitemap/lang/help.".$lang.".html";
		}else{
		 	$help_file = $cfg["plugins_dir"]."/an_sitemap/lang/help.ru.html";
		}
		$help = implode('', file($help_file));
		$tpl->assign(array('SECTION' => $L['an_sitemap']['help']));
		
		$tpl->assign(array('HELP_BODY' => $help));
		$tpl->parse("MAIN.HELP");
		break;
	
	default:
		$error .= $L['an_sitemap']['err_unknown_task'];
		break;
	}
// ===== Menu =======
$tpl -> assign(array(
	'CONFIG_URL' => $config_url,
	'STRUCTURE_URL' => $srtucture_url,
        'ADD_LINKS_URL'  => $add_links_url,
	'INTEGRATORS_URL' => $integrators_url,
	'HELP_URL' => $help_url,
	));
$tpl -> parse("MAIN.MENU");
// ===== End: Menu =======

$error .= $sitemap->error;
$message .= $sitemap->message;
if (!empty($error)){
	$tpl -> assign(array('ERROR_BODY' => $error));
	$tpl -> parse("MAIN.ERROR");
}
if (!empty($message)){
	$tpl -> assign(array('MESSAGE_BODY' => $message));
	$tpl -> parse("MAIN.MESSAGE");
}

//$site_map_info = cot_infoget($cfg['plugins_dir']."/an_sitemap/an_sitemap.setup.php", 'SED_EXTPLUGIN');

$tpl -> assign(array(
	'AN_BUTTON' => "<a href=\"http://portal30.ru\" target=\"_blank\"><img src=\"http://portal30.ru/buniry/3d-88x31.gif\" alt=\"Web development\" border=\"0\" width=\"88\" height=\"31\"></a>",
	'SITE_MAP_VERSION' => $info["Version"],
	'CHECK_NEW_VERSION' => $plugin_check_ver_page,
	));
$tpl -> parse("MAIN");
$plugin_body .= $tpl -> text("MAIN");

?>