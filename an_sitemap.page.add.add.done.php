<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.add.done
[END_COT_EXT]

==================== */
// *********************************************
// *    Plugin AN Site Map                     *
// *      Page add                             *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *           ©  Alex & Natty Studio  2010    *
// *********************************************
if (!defined('COT_CODE')) { die("Wrong URL."); }

define(DS, DIRECTORY_SEPARATOR);								// Разделитель папок в пути к папке
require_once($cfg["plugins_dir"].DS."an_sitemap".DS."inc".DS."config.php");

// Заполняем поле последней модификации страницы
if ($config["page_last_mod_field_auto"] == 1){
	$sql = $db->query("UPDATE `$db_pages` SET `".$config["page_last_mod_field"]."`=".(int)$sys['now_offset']." WHERE page_id=$id");
}

?>