<?PHP
// *********************************************
// *    Plugin AN Site Map                     *
// *      Configuration File                   *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
if (!defined('COT_CODE')) { die('Wrong URL.'); }

$config["max_xml_urls"] = "50000"; 
$config["max_html_urls"] = "20"; 
$config["max_txt_urls"] = "50000";
$config["enable_cache"] = "1"; 
$config["cache_time"] = "168"; 
$config["add_pages"] = "xml_txt"; 
$config["add_lists"] = "both"; 
$config["add_empty_lists"] = "no"; 
$config["page_last_mod_field"] = "page_date"; 
$config["page_last_mod_field_auto"] = "0"; 
$config["add_forums"] = "both"; 
$config["add_user_profs"] = "xml_txt"; 
$config["add_users"] = "both"; 
$config["show_num"] = "1"; 
$config["freq_pages"] = "weekly"; 
$config["freq_lists"] = "weekly"; 
$config["freq_sections"] = "monthly"; 
$config["freq_topics"] = "weekly"; 
$config["freq_user_lists"] = "monthly"; 
$config["freq_user_profiles"] = "monthly"; 
$config["priority_pages"] = "0.5"; 
$config["priority_lists"] = "0.5"; 
$config["priority_sections"] = "0.5"; 
$config["priority_topics"] = "0.5"; 
$config["priority_user_lists"] = "0.5"; 
$config["priority_user_profiles"] = "0.5"; 


?>