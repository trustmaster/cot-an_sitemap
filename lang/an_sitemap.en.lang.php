<?PHP
// *********************************************
// *    Plugin AN Site Map                     *
// *      English Lang File                    *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
// Translated to Endlish by Trustmaster
if (!defined('COT_CODE')) { die('Wrong URL.'); }

/**
 * Plugin Title & Subtitle
 */

$L['an_sitemap']['plu_title'] = $L['plu_title']	= 'Site Map';
$L['an_sitemap']['plu_subtitle']		= 'Main Categories of Our Site';
$L['an_sitemap']['plu_meta_keywords'] = "map, site, site map";

/**
 * Plugin Body
 */
$L['an_sitemap']['lists'] = 'Categories';
$L['an_sitemap']['forums'] = 'Forums';
$L['an_sitemap']['users'] = 'Users';
$L['an_sitemap']['user_list'] = 'User list';
$L['an_sitemap']['show_list'] = 'Detailed list';

/**
 * User Part Errors and messages
 */
$L['an_sitemap']['err_unknown_state'] = "Unknown state of sitemap links output";
//$L['an_sitemap']['msg_save_config'] = "Configuration saved";

// ==== Pagination ====
$L['plu_pagnav_prev'] = " &lt; ";
$L['plu_pagnav_next'] = " &gt; ";
$L['plu_pagnav_prev_desc'] = "Previous page";
$L['plu_pagnav_next_desc'] = "Next page";
$L['plu_pagnav_first'] = "First";
$L['plu_pagnav_last'] = "Last";
$L['plu_pagnav_first_desc'] = "First page";
$L['plu_pagnav_last_desc'] = "Last page";
$L['plu_page_of'] = "Page %1\$s of %2\$s";
$L['plu_pagnav_per_page'] = "Per page";
$L['plu_pagnav_per_page_all'] = "All";

// ==== End: Pagination ====

// ==== Test integrator ====
$L['plu']['test_name'] = "Test integrator";
$L['plu']['test_title1'] = "Item with external URL (integrator)";
$L['plu']['test_title2'] = "Test item with internal URL (integrator)";
$L['plu']['test_title3'] = "Second level item in the test integrator";
$L['plu']['test_title4'] = "Integrator nested in category &laquo;News&raquo;";
$L['plu']['test_title5'] = "Integrator nested in site root :)";
// ==== End: Test integrator ====

/**
 * Admin Part
 */
$L['an_sitemap']['config'] = "Settings";
$L['an_sitemap']['config_main'] = "Main settings for all maps";
$L['an_sitemap']['config_freq'] = "Change frequency settings for XML-map";
$L['an_sitemap']['config_priority'] = "Change priority settings";
$L['an_sitemap']['srtucture'] = "Structure";
$L['an_sitemap']['add_links'] = "Additional links";
$L['an_sitemap']['integrators'] = "Integrators";
$L['an_sitemap']['google_help'] = "sitemap.xml description on Google";
$L['an_sitemap']['google_help_url'] = "http://www.google.com/support/webmasters/bin/topic.py?topic=8476";
$L['an_sitemap']['help'] = "Help";
$L['an_sitemap']['sitemaps'] = "Site Maps";
$L['an_sitemap']['HTML_link'] = "HTML sitemap link";
$L['an_sitemap']['XML_link'] = "XML sitemap link";
$L['an_sitemap']['TXT_link'] = "TXT sitemap link";
$L['an_sitemap']['robots_file'] = "robots.txt file";
$L['an_sitemap']['recomended_to_add'] = "Recommended to add";
$L['an_sitemap']['recomended_to_delete'] = "Recommended to delete";
/*$L['an_sitemap']['robots_desc'] = "Make sure you have modified <strong>.htaccess</strong>. <a href=\"/admin.php?m=other&p=an_sitemap&task=help\">Details in Help</a>.";*/
$L['an_sitemap']['max_xml_urls'] = "Max URLs per XML sitemap file."; 
$L['an_sitemap']['max_xml_urls_desc'] = "<strong>NOTE:</strong> Google allows 50 000 URLs max. per XML file. If there are more links than specified here, several sitemap parts will be created. Each of these parts will be listed in <strong>XML-sitemap index</strong>";
$L['an_sitemap']['max_txt_urls_desc'] = "<strong>ПРИМЕЧАНИЕ:</strong> Google allows 50 000 URLs max. per TXT file. If there are more links than specified here, several sitemap parts will be created. Each of these parts should be specified in robots.txt.";
$L['an_sitemap']['max_html_urls'] = "Number of links per HTML sitemap page by default."; 
$L['an_sitemap']['max_txt_urls'] = "Max. URLs per TXT sitemap."; 
$L['an_sitemap']['use_cache'] = "Use cache?";
$L['an_sitemap']['cache_time'] = "Cache lifetime (hours).";
$L['an_sitemap']['cache_time_desc'] = "Please set cache lifetime in hours. When cache lifetime expires, cache gets updated.";
$L['an_sitemap']['add_pages'] = "Include pages";
$L['an_sitemap']['add_lists'] = "Include categories";
$L['an_sitemap']['add_empty_lists'] = "Display empty page categories";
$L['an_sitemap']['add_forums'] = "Include forums";
$L['an_sitemap']['add_user_profs'] = "Include user profiles";
$L['an_sitemap']['add_users'] = "Include users list";
$L['an_sitemap']['add_users_desc'] = "HTML sitemap will only include main users list link";
$L['an_sitemap']['show_num'] = "Display number of items in a category";
$L['an_sitemap']['show_num_desc'] = "For HTML sitemap. Displays number of pages near the category name, etc.";
$L['an_sitemap']['no'] = "No";
$L['an_sitemap']['to_HTML'] = "in HTML map";
$L['an_sitemap']['to_XML_TXT'] = "in XML and TXT";
$L['an_sitemap']['to_all_maps'] = "in all maps";
$L['an_sitemap']['freq_pages'] = "Page update frequency";
$L['an_sitemap']['freq_pages_desc'] = "Probable frequency of page update. This value provides general information for search robots and makes an approximate assumption how often they should crawl the page. This value <strong>must</strong> be used for documents that change on every visit. This value must <strong>never</strong> be used for archive URLs.";
$L['an_sitemap']['freq_lists'] = "Category lists update frequency";
$L['an_sitemap']['freq_sections'] = "Forum sections update frequency";
$L['an_sitemap']['freq_topics'] = "Forum topics update frequency";
$L['an_sitemap']['freq_user_lists'] = "Users list update frequency";
$L['an_sitemap']['freq_user_profiles'] = "User profile update frequency";
$L['an_sitemap']['never'] = "Never";
$L['an_sitemap']['yearly'] = "Yearly";
$L['an_sitemap']['monthly'] = "Monthly";
$L['an_sitemap']['weekly'] = "Weekly";
$L['an_sitemap']['daily'] = "Daily";
$L['an_sitemap']['hourly'] = "Hourly";
$L['an_sitemap']['always'] = "Always";
$L['an_sitemap']['priority_pages'] = "Page priority";
$L['an_sitemap']['priority_pages_desc'] = "Priority of this URL related to other URLs on your site. Values range from 0,0 to 1,0. This value does not affect your pages, it just lets the robots know which pages you think are more important and should be indexed first.<br /><br />
By default all pages have the priority of 0.5.";
$L['an_sitemap']['priority_lists'] = "Category lists priority";
$L['an_sitemap']['priority_sections'] = "Forum sections priority";
$L['an_sitemap']['priority_topics'] = "Forum topics priority";
$L['an_sitemap']['priority_user_lists'] = "Users list priority";
$L['an_sitemap']['priority_user_profiles'] = "User profiles priority";
$L['an_sitemap']['file'] = "File";
$L['an_sitemap']['writeable'] = "Is Writable";
$L['an_sitemap']['not_writeable'] = "Is Not Writable";
$L['an_sitemap']['plugin_ver'] = "Plugin version";
$L['an_sitemap']['check_new_ver'] = "Check for newer ver";
$L['an_sitemap']['code'] = "Code";
$L['an_sitemap']['name'] = "Name";
$L['an_sitemap']['state'] = "State";
$L['an_sitemap']['link'] = "Link";
$L['an_sitemap']['total_elements'] = "Total items";
$L['an_sitemap']['per_page_elements'] = "Display per page";
$L['an_sitemap']['count_elements'] = "Items";
$L['an_sitemap']['config_default'] = "Set all to Defaults";
$L['an_sitemap']['config_default_confirm'] = "Restore the default configuration? All current settigs will be lost";
$L['an_sitemap']['description'] = "Description";
$L['an_sitemap']['page_last_mod_field'] = "Field with page modification date";
$L['an_sitemap']['page_last_mod_field_desc'] = "A field containing page modification date in UNIX timestamp format. Inforation is used in XML sitemap. Default is <strong>&laquo;page_date&raquo;</strong>. But we recommend adding an extra field which will be updated every time the page is updated. If auto-update is turned on, it will be automatically updated by this plugin.";
$L['an_sitemap']['page_last_mod_field_auto'] = "Date field auto-update";
$L['an_sitemap']['order_by_href'] = 'Click to order by this column';
$L['an_sitemap']['order'] = 'Order';
$L['an_sitemap']['priority'] = "Priority";
$L['an_sitemap']['last_mod_date'] = "Modification date";
$L['an_sitemap']['add_urls_desc'] = "* <strong>Description</strong> used only in HTML sitemap, does not affect XML or TXT maps. <strong>255 characters max.</strong>";
$L['an_sitemap']['change_freq'] = "Update frequency";
$L['an_sitemap']['change_freq_short'] = "Upd. freq.";
$L['an_sitemap']['last_mod_desc'] = 'Last modification date. This date must be in <a href="http://www.w3.org/TR/NOTE-datetime" target="_blank">W3C Datetime</a> format. This format allows to omit time segment and use YYYY-MM-DD format if necessary.';
$L['an_sitemap']['not_required'] = 'Optional';
$L['an_sitemap']['add_url_show'] = 'Show new URL adding form';
$L['an_sitemap']['add_url_hide'] = 'Hide new URL adding form';
$L['an_sitemap']['link_desc'] = 'Page URL. This URL must start with prefix (e.g. HTTP) and end with slash, if your webserver requires it. Value length is limited to 2048 characters.';
$L['an_sitemap']['name_desc'] = 'Page title. Displayed in HTML sitemap. Does not affect XML or TXT sitemaps.';
$L['an_sitemap']['del_url'] = 'Delete URL';
$L['an_sitemap']['select_all'] = 'Select all';
$L['an_sitemap']['url_del_confirm'] = "Remove link: «{link_name}»? This action cannot be rolled back.";
$L['an_sitemap']['marked'] = "Selected";
$L['an_sitemap']['marked_del_confirm'] = "Remove all selected links? This action cannot be rolled back.";
$L['an_sitemap']['no_url_marked'] = "No link has been selected.";
$L['an_sitemap']['XML_index'] = "XML Sitemap Index.";


/**
 * Admin Part Errors and messages
 */
$L['an_sitemap']['err_unknown_task'] = "Unknown task";
$L['an_sitemap']['err_write_robots'] = "Could not write robots.txt. Please modify it manually. See the note below.";
$L['an_sitemap']['err_config_not_writable'] = "Could not save configuration file. The file is not writable";
$L['an_sitemap']['msg_save_config'] = "Configuration has been saved";
$L['an_sitemap']['msg_save_struct'] = "Structure has been saved";
$L['an_sitemap']['msg_save_url'] = "URL has been added";
$L['an_sitemap']['err_read_def_config'] = "Could not restore default configuration.<br />Could not read file ".$cfg["plugins_dir"]."/an_sitemap/inc/config_def.php";
$L['an_sitemap']['err_write_def_config'] = "Could not restore default configuration.<br />Could not write file ".$cfg["plugins_dir"]."/an_sitemap/inc/config.php";
$L['an_sitemap']['msg_def_config_restored'] = "Default configuration has been restored";
$L['an_sitemap']['err_no_url'] = "You should specify a link";
$L['an_sitemap']['err_no_name'] = "You should specify a name";
$L['an_sitemap']['err_bad_priority'] = "Wrong priority value";
$L['an_sitemap']['err_edit_url_id'] = "Could not save URL with ID:";
$L['an_sitemap']['err_operation'] = "Operation failed";
$L['an_sitemap']['msg_url_deleted'] = "URL id <strong>{urlid}</strong> has ben removed";
$L['an_sitemap']['err_url_not_deleted'] = "URL id <strong>{urlid}</strong> has NOT been removed. Removal error or it is missing in the DB.";

/**
 * Plugin Config
 */

//$L['cfg_showcats'] = array('Show page categories');

?>
