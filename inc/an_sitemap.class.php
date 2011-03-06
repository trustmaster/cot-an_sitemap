<?php
// *********************************************
// *    Plugin AN Site Map                     *
// *       sitemap class                       *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
if (!defined('COT_CODE')) { die('Wrong URL.'); }

if (!defined('DS')) { define(DS, DIRECTORY_SEPARATOR); }
require_once cot_langfile('an_sitemap', 'plug');

require_once cot_incfile('page', 'module');
require_once cot_incfile('forums', 'module');

$an_sitemap_db_struct = $db_x . "ansitemap_struct";
$an_sitemap_db_add_urls = $db_x . "ansitemap_add_urls";

// Область, куда включается новая ссылка
$an_sitemap_stateVal = (array("no", "html", "xml_txt", "both"));
$an_sitemap_stateTexts = array();
$an_sitemap_stateTexts[] = $L['an_sitemap']['no'];
$an_sitemap_stateTexts[] = $L['an_sitemap']['to_HTML'];
$an_sitemap_stateTexts[] = $L['an_sitemap']['to_XML_TXT'];
$an_sitemap_stateTexts[] = $L['an_sitemap']['to_all_maps'];

// Частота изменения
$an_sitemap_freqVal = (array("never", "yearly", "monthly", "weekly", "daily", "hourly", "always"));
$an_sitemap_freqTexts = array();
$an_sitemap_freqTexts[] = $L['an_sitemap']['never'];
$an_sitemap_freqTexts[] = $L['an_sitemap']['yearly'];
$an_sitemap_freqTexts[] = $L['an_sitemap']['monthly'];
$an_sitemap_freqTexts[] = $L['an_sitemap']['weekly'];
$an_sitemap_freqTexts[] = $L['an_sitemap']['daily'];
$an_sitemap_freqTexts[] = $L['an_sitemap']['hourly'];
$an_sitemap_freqTexts[] = $L['an_sitemap']['always'];

// Приоритеты страниц
$an_sitemap_priorityVal = (array(0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0));

if (!class_exists(an_HTML)) require_once($cfg["plugins_dir"].DS."an_sitemap".DS."inc".DS."an_html.class.php");
if (!class_exists(an_Folder)) require_once($cfg["plugins_dir"].DS."an_sitemap".DS."inc".DS."an_filesystem.folder.class.php");

class an_sitemap {

    // class version
	var $ver = '1.0.1';
	
	// String
	// Ссылка на HTML карту
	var $html_link = '';
	
	// Integer
	// Количество ссылок в html карте
	var $html_urls_count = 0;
	
	// String
	// Массив XML-ссылок
	var $xml_links = array();
	
	// Integer
	var $xml_links_count = 0;
	
	// String
	// Индекс XML-карты
	var $xml_index = '';
	
	// String
	// Массив TXT-ссылок
	var $txt_links = array();
	
	// String
	var $error = '';
	
	// String
	var $message = '';
	
	// Array
	// Дерево категорий. Создано однажды, сохраняется сюда,
	// чтобы в рамках одного экземпляра класса, заново его не создавать
	var $sitemap = array();	
	
	// Array
	// Состояние для отображения в карте для каждого вхождения ("no", "html", "xml_txt", "both")
	var $state = array();
	
	/*
	* Path to your cache directory
	* eg. /www/website.com/cache
	* @var string
	*/
	protected $cache_path = '';

	//Configuration
	var $max_xml_urls = '';				// integer
	var $max_html_urls = '';			// integer
	var $max_txt_urls = '';				// integer
	var $enable_cache = '';				// 1 / 0 Использовать кеш
	var $cache_time = '';				// integer - время жизни кеша (в часах) (Def: 168 = 1 Week)
	var $add_pages = '';				// "no", "xml_txt"
	var $add_lists = '';				// "no", "html", "xml_txt", "both"
	var $add_empty_lists = '';			// "no", "html", "xml_txt", "both"
	var $page_last_mod_field = ''; 		// string
	var $page_last_mod_field_auto = '';	// 1 / 0 Заполнять поле последнего изменения страницы автоматически?
	var $add_forums = '';				// "no", "html", "xml_txt", "both"
	var $add_user_profs = '';			// "no", "xml_txt"
	var $add_users = '';				// "no", "html", "xml_txt", "both"
	var $freq_pages = '';				// "never", "yearly", "monthly", "weekly", "daily", "hourly", "always"
	var $freq_lists = '';
	var $freq_sections = '';
	var $freq_topics = '';
	var $freq_user_lists = '';
	var $freq_user_profiles = ''; 
	var $priority_pages = '';			// 0.1 - 1.5
	var $priority_lists = '';			// 0.1 - 1.5
	var $priority_sections = '';
	var $priority_topics = '';
	var $priority_user_lists = '';
	var $priority_user_profiles = '';
	var $show_num = '';					// 1 / 0 Показывать количество элементов рядом с названием категории
	
	// Constructor
	function __construct(){
		global $cfg;
		// loading config here
		$this->html_link = $cfg['mainurl'].'/'.cot_url('plug', 'e=an_sitemap', '', true);
		$this->xml_index = $cfg['mainurl'].'/'.cot_url('plug', 'r=an_sitemap&out=xml_index', '', true);
		$this->cache_path = $cfg["plugins_dir"].DS.'an_sitemap'.DS.'cache';
		require_once($cfg['plugins_dir'].DS.'an_sitemap'.DS.'inc'.DS.'config.php');
		foreach($config as $key => $value ) {
			if (isset($this->$key)) $this->$key = $value;
      	}
		unset($config);
		if (empty($this->cache_time)) $this->cache_time = 168;
		
		// Грузим количество XML_TXT ссылок
		if (file_exists($this->cache_path.DS.'xml.links_count.cache')){
			$this->xml_links_count = implode('', file($this->cache_path.DS.'xml.links_count.cache') ) ;
		}
		// Грузим количество HTML ссылок
		if (file_exists($this->cache_path.DS.'html.urls_count.cache')){
			$this->html_urls_count = implode('', file($this->cache_path.DS.'html.urls_count.cache') ) ;
		}
		// Ссылки на XML-карты сайта
		$totalparts = ceil($this->xml_links_count / $this->max_xml_urls);
		if ($totalparts == 0) $totalparts = 1;
		for($i = 1; $i<=$totalparts; $i++){
			$part = ($i > 1) ? '&pt='.$i : '';
			$this->xml_links[] = $cfg['mainurl'].'/'.cot_url('plug', 'r=an_sitemap&out=xml'.$part, '', true);
		}
		// Ссылки на TXT-карты сайта
		$totalparts = ceil($this->xml_links_count / $this->max_txt_urls);
		if ($totalparts == 0) $totalparts = 1;
		for($i = 1; $i<=$totalparts; $i++){
			$part = ($i > 1) ? '&pt='.$i : '';
			$this->txt_links[] = $cfg['mainurl'].'/'.cot_url('plug', 'r=an_sitemap&out=txt'.$part, '', true);
		}
	}
	
	// ----============= Admin Part ===============----
	
    /**
    * Show all configuration parameters
    * @param object - current admin template
    */
    function show_configuration(&$tpl) {
		global $db, $cfg, $L, $db_pages, $an_sitemap_stateVal, $an_sitemap_stateTexts, $an_sitemap_freqVal, $an_sitemap_freqTexts, $an_sitemap_priorityVal;
		
		require $cfg["plugins_dir"]."/an_sitemap/inc/config_def.php";
		
		$act = cot_import('act','G','TXT');
		if ($act == 'save') $this->save_configuration();
		if ($act == 'reset') $this->reset_configuration();
		
		// ==== Проверяем robots.txt ====
		$robots = $this->check_robots_txt();
		if ($robots->is_ok==0) {
			$robots = $this->update_robots($robots);
		} else unset ($robots->to_add);

		if (isset($robots->to_add) || isset($robots->to_delete)){
			if (isset($robots->to_add)){
				$tmp = '';
				foreach ($robots->to_add as $line) {
					$tmp .= 'Sitemap: '.htmlentities($line).'<br />';
				}
				$tpl -> assign(array('ADD_TO_ROBOTS' => $tmp));
			}
			if (isset($robots->to_delete)) {
				$new_robots = array();
				$tmp = '';
				foreach ($robots->to_delete as $index) {
					$tmp .= htmlentities($robots->new_robots[intval($index)]).'<br />';
				}
				$tpl -> assign(array('DELETE_FROM_ROBOTS' => $tmp));
			}
			
			$tpl -> parse("MAIN.CONFIG.ROBOTS");
		} // if (isset($robots->to_add) || isset($robots->to_delete)){
		// ==== Конец: Проверяем robots.txt ====
		
		// ==== Ссылки на генерируемые карты сайта:  ====
		$i = 1;
		foreach($this->xml_links as $link){
			$tpl -> assign(array(
				'CONFIG_XML_LINK' => $link,
				'CONFIG_XML_LINK_NUM' => $i,
			));
			$tpl -> parse("MAIN.CONFIG.XML_LINKS_ROW");
			$i++;
		}
		
		$i = 1;
		foreach($this->txt_links as $link){
			$tpl -> assign(array(
				'CONFIG_TXT_LINK' => $link,
				'CONFIG_TXT_LINK_NUM' => $i,
			));
			$tpl -> parse("MAIN.CONFIG.TXT_LINKS_ROW");
			$i++;
		}
		
		$tpl -> assign(array('CONFIG_XML_INDEX_LINK' => $this->xml_index));
		// ==== Конец: Ссылки на генерируемые карты сайта:  ====
		
		$values = (array("no", "xml_txt"));
		$texts = array();
		$texts[] = $L['an_sitemap']['no'];
		$texts[] = $L['an_sitemap']['to_XML_TXT'];
		
				$add_user_profs = an_selectbox($this->add_user_profs, "config_add_user_profs", $values, $texts );
		
		$add_pages = an_selectbox($this->add_pages, "config_add_pages", $an_sitemap_stateVal, $an_sitemap_stateTexts );
		
		$add_lists = an_selectbox($this->add_lists, "config_add_lists", $an_sitemap_stateVal, $an_sitemap_stateTexts );
		$add_empty_lists = an_selectbox($this->add_empty_lists, "config_add_empty_lists", $an_sitemap_stateVal, $an_sitemap_stateTexts );
		$add_forums = an_selectbox($this->add_forums, "config_add_forums", $an_sitemap_stateVal, $an_sitemap_stateTexts );
		$add_users = an_selectbox($this->add_users, "config_add_users", $an_sitemap_stateVal, $an_sitemap_stateTexts );
		
		$freq_pages = an_selectbox($this->freq_pages, "config_freq_pages", $an_sitemap_freqVal , $an_sitemap_freqTexts );
		$freq_lists = an_selectbox($this->freq_lists, "config_freq_lists", $an_sitemap_freqVal , $an_sitemap_freqTexts );
		$freq_sections = an_selectbox($this->freq_sections, "config_freq_sections", $an_sitemap_freqVal , $an_sitemap_freqTexts );
		$freq_topics = an_selectbox($this->freq_topics, "config_freq_topics", $an_sitemap_freqVal , $an_sitemap_freqTexts );
		$freq_user_lists = an_selectbox($this->freq_user_lists, "config_freq_user_lists", $an_sitemap_freqVal , $an_sitemap_freqTexts );
		$freq_user_profiles = an_selectbox($this->freq_user_profiles, "config_freq_user_profiles", $an_sitemap_freqVal , $an_sitemap_freqTexts );
				
		$page_fields = array();
		$sql = $db->query("SHOW COLUMNS FROM `$db_pages`");
		while ($row = $sql->fetch()){
			$page_fields[] = $row["Field"];
		}
		$page_last_mod_field = an_selectbox($this->page_last_mod_field, "config_page_last_mod_field", $page_fields );
		
		if (!isset($robots->to_add) && $robots->is_ok==1) $tpl -> assign(array('ROBOTS_OK' => 'OK'));
		$tpl -> assign(array(
			'CONFIG_FILE_WRITEABLE' => $this->configfile_writeable(),
			'CONFIG_FILE' => $cfg["plugins_dir"]."/an_sitemap/inc/config.php",
			'CONFIG_FORM_URL' => $cfg['mainurl']."/".cot_url('admin', "m=other&p=an_sitemap&task=config&act=save"),
			'CONFIG_MAX_XML_URLS' => $this->max_xml_urls,
			'CONFIG_MAX_XML_URLS_DEF' => $config["max_xml_urls"],
			'CONFIG_MAX_HTML_URLS' => $this->max_html_urls,
			'CONFIG_MAX_HTML_URLS_DEF' => $config["max_html_urls"],
			'CONFIG_MAX_TXT_URLS' => $this->max_txt_urls,
			'CONFIG_MAX_TXT_URLS_DEF' => $config["max_txt_urls"],
			'CONFIG_ENABLE_CACHE' => an_HTML::booleanlist('config_enable_cache', $this->enable_cache, $L['Yes'], $L['No']),
			'CONFIG_CACHE_TIME' => $this->cache_time,
			'CONFIG_CACHE_TIME_DEF' => $config["cache_time"],
			'CONFIG_ADD_PAGES' => $add_pages,
			'CONFIG_ADD_LISTS' => $add_lists,
			'CONFIG_ADD_EMPTY_LISTS' => $add_empty_lists,
			'CONFIG_PAGE_LAST_MOD_FIELD' => $page_last_mod_field,
			'CONFIG_PAGE_LAST_MOD_FIELD_AUTO' => an_HTML::booleanlist('config_page_last_mod_field_auto', $this->page_last_mod_field_auto, $L['Yes'], $L['No']),
			'CONFIG_ADD_FORUMS' => $add_forums,
			'CONFIG_ADD_USER_PROFS' => $add_user_profs,
			'CONFIG_ADD_USERS' => $add_users,
			'CONFIG_SHOW_NUM' => an_HTML::booleanlist('config_show_num', $this->show_num, $L['Yes'], $L['No']),
			'CONFIG_FREC_PAGES' => $freq_pages,
			'CONFIG_FREC_LISTS' => $freq_lists,
			'CONFIG_FREC_SECTIONS' => $freq_sections,
			'CONFIG_FREC_TOPICS' => $freq_topics,
			'CONFIG_FREC_URER_LISTS' => $freq_user_lists,
			'CONFIG_FREC_USER_PROFILES' => $freq_user_profiles,
			'CONFIG_PRIORITY_PAGES' => an_selectbox($this->priority_pages, "config_priority_pages", $an_sitemap_priorityVal ),
			'CONFIG_PRIORITY_LISTS' => an_selectbox($this->priority_lists, "config_priority_lists", $an_sitemap_priorityVal),
			'CONFIG_PRIORITY_SECTIONS' => an_selectbox($this->priority_sections, "config_priority_sections", $an_sitemap_priorityVal),
			'CONFIG_PRIORITY_TOPICS' => an_selectbox($this->priority_topics, "config_priority_topics", $an_sitemap_priorityVal),
			'CONFIG_PRIORITY_URER_LISTS' => an_selectbox($this->priority_user_lists, "config_priority_user_lists", $an_sitemap_priorityVal),
			'CONFIG_PRIORITY_USER_PROFILES' => an_selectbox($this->priority_user_profiles, "config_priority_user_profiles", $an_sitemap_priorityVal),
			'CONFIG_HTML_LINK' => $this->html_link,
			'CONGIG_ALL_DEF_URL' => $cfg['mainurl']."/".cot_url('admin', "m=other&p=an_sitemap&task=config&act=reset"),
			));
		$tpl -> parse("MAIN.CONFIG");
	}
	
	
	/**
	* Returns the "is_writeable" status of the configuration file
	* @param void
	* @returns int 1 when the configuration file is writeable, 0 when not
	*/
   function configfile_writeable() {
      global $cfg;
	  return is_writeable( $cfg["plugins_dir"]."/an_sitemap/inc/config.php" );
   }

   /**
	* Returns the "is_readable" status of the configuration file
	* @param void
	* @returns boolean 1 when the configuration file is writeable, 0 when not
	*/
   function configfile_readable() {
   	  global $cfg;
      return is_readable( $cfg["plugins_dir"]."/an_sitemap/inc/config.php" );
   }
	
   /**
	* Restore default configuration
	* @param void
	*/
	function reset_configuration(){
   		global $cfg, $L;
      	
		$src = $cfg["plugins_dir"]."/an_sitemap/inc/config_def.php";
		$dest = $cfg["plugins_dir"]."/an_sitemap/inc/config.php";
		
	  	if (!is_readable( $src ) ){
			$this->error .= $L['an_sitemap']['err_read_def_config']."<br />";
			return false;
	  	}
	 	if (!@unlink( $dest )) {
			$this->error .= $L['an_sitemap']['err_write_def_config']."<br />";
			return false;
	 	}
	  	if (!@ copy($src, $dest)) {
			$this->error .= $L['an_sitemap']['err_write_def_config']."<br />";
			return false;
	  	}
		// reload config
		require( $src );

		foreach($config as $key => $value ) {
			if (isset($this->$key)) $this->$key = $value;
      	}
		unset($config);
		
		$this->message .= $L['an_sitemap']['msg_def_config_restored']."<br />";
		return true;
   }
	
	/*
	*	Save Configuration
	*/
	function save_configuration(){
		global $cfg, $L;
		
		//Принимаем конфигурацию:
		$out['max_xml_urls'] = cot_import('config_max_xml_urls','P','INT');
		$out['max_html_urls'] = cot_import('config_max_html_urls','P','INT');
		$out['max_txt_urls'] = cot_import('config_max_txt_urls','P','INT');
		$out['enable_cache'] = cot_import('config_enable_cache','P','INT');
		$out['cache_time'] = cot_import('config_cache_time','P','INT');
		$out['add_pages'] = cot_import('config_add_pages','P','ALP');
		$out['add_lists'] = cot_import('config_add_lists','P','ALP');
		$out['add_empty_lists'] = cot_import('config_add_empty_lists','P','ALP');
		$out['page_last_mod_field'] = cot_import('config_page_last_mod_field','P','ALP');
		$out['page_last_mod_field_auto'] = cot_import('config_page_last_mod_field_auto','P','ALP');
		$out['add_forums'] = cot_import('config_add_forums','P','ALP');
		$out['add_user_profs'] = cot_import('config_add_user_profs','P','ALP');
		$out['add_users'] = cot_import('config_add_users','P','ALP');
		$out['show_num'] = cot_import('config_show_num','P','INT');
		$out['freq_pages'] = cot_import('config_freq_pages','P','ALP');
		$out['freq_lists'] = cot_import('config_freq_lists','P','ALP');
		$out['freq_sections'] = cot_import('config_freq_sections','P','ALP');
		$out['freq_topics'] = cot_import('config_freq_topics','P','ALP');
		$out['freq_user_lists'] = cot_import('config_freq_user_lists','P','ALP');
		$out['freq_user_profiles'] = cot_import('config_freq_user_profiles','P','ALP');
		$out['priority_pages'] = cot_import('config_priority_pages','P','NUM');
		$out['priority_lists'] = cot_import('config_priority_lists','P','NUM');
		$out['priority_sections'] = cot_import('config_priority_sections','P','NUM');
		$out['priority_topics'] = cot_import('config_priority_topics','P','NUM');
		$out['priority_user_lists'] = cot_import('config_priority_user_lists','P','NUM');
		$out['priority_user_profiles'] = cot_import('config_priority_user_profiles','P','NUM');
		
		if (empty($out["max_xml_urls"]) && empty($out["max_html_urls"]) && empty($out["max_txt_urls"]) && empty($out["add_pages"]) && empty($out["add_lists"]) && empty($out["add_empty_lists"]) && empty($out["add_forums"])) return false;
		
		//Обновляем конфигурацию
		foreach($out as $key => $value ) {
			if (isset($this->$key)) $this->$key = $value;
      	}
		
		$header = "<?PHP\r\n";
		$header .= "// *********************************************\r\n";
		$header .= "// *    Plugin AN Site Map                     *\r\n";
		$header .= "// *      Configuration File                   *\r\n";
		$header .= "// *    Alex & Natty studio                    *\r\n";
		$header .= "// *        http://portal30.ru                 *\r\n";
		$header .= "// *                                           *\r\n";
		$header .= "// *            © Alex & Natty Studio  2010    *\r\n";
		$header .= "// *********************************************\r\n";
		$header .= "if (!defined('SED_CODE')) { die('Wrong URL.'); }\r\n\r\n";
		$footer = "\r\n\r\n?>";
		
		if ($this->configfile_writeable() == 0){
			$this->error .= $L['an_sitemap']['err_config_not_writable']."<br />";
			return false;
		}
		$output = '';
		foreach($out as $key => $value ) {
			$output .= '$config["'.$key.'"] = "'.$value.'";'." \r\n";
      	}
		
		$file = @fopen($cfg["plugins_dir"]."/an_sitemap/inc/config.php", 'w');
		if ($file){	
			fwrite($file, $header.$output.$footer);
			fclose($file);
			$this->message .= $L['an_sitemap']['msg_save_config']."<br />";
			return true;
		}else{	
			$this->error .= $L['an_sitemap']['err_save_config']."<br />";
			return false;
		}
	} // function save_configuration(){
	
	/**
    * Check robots.txt file to use width AN SiteMap
    */
	function check_robots_txt () {
		global $cfg;
		$robots = array();
		$robots = file ('robots.txt');
		$to_delete = array();
		$to_add = array();
		$is_ok = array();
		
		$root = $_SERVER['DOCUMENT_ROOT'];
		$rootarr = explode ('/',$root);
		$rootarray = array();
		if ($rootarr) {
			foreach ($rootarr as $r) {
				if ($r!='') $rootarray[]=$r;
			}
		}

		$path = PATH_SITE;
		$patharr = explode ('/',$path);
		$patharray = array();
		if ($patharr) {
			foreach ($patharr as $r) {
				if ($r!='') $patharray[]=$r;
			}
		}

		$segments = count($patharray) - count($rootarray);
		if ($segments !=0) {
			$folder = '/';
			for ($i = count($rootarray); $i<count($patharray); $i++) {
				$folder .= $patharray[$i].'/';
			}
		} else $folder = '/';

		$unsets = array();
		if ($robots) {
			$is_ok = 0;
			$i = 0;
			$found_xml = 0;
			$found_txt = 0;
			foreach ($robots as $line) {
				if ( mb_strpos(mb_strtolower($line), 'sitemap:') !== false && mb_strpos($line, $this->xml_index) !== false ){
					$line = trim(substr($line,8,mb_strlen($line)-8));
					$found_xml = 1;
				}elseif( mb_strpos(mb_strtolower($line), 'sitemap:') !== false && mb_strpos($line, $this->txt_links[0]) !== false ){
					$line = trim(substr($line,8,mb_strlen($line)-8));
					$found_txt = 1;
				}else {
					if ( mb_strpos(mb_strtolower($line), 'sitemap:') !== false){
						// Проверяем все записи Sitemap в robots.txt и отмечаем лишние
						foreach($this->xml_links as $xml_url){
							if (mb_strpos($line, $xml_url) === false){
								$to_delete[] = $i;
								$is_ok=-1;
							}
						}
					}
				}
				$i++;
			} // foreach ($robots as $line) {
		}
		
		//if ($found_xml == 1 && $found_txt == 1) $is_ok = 1;
		if ($found_xml == 1) $is_ok = 1;
		
		if ($is_ok==-1) $is_ok=0;

		if ($found_xml == 0) {
			$robots[] = 'Sitemap: '.$this->xml_index;
		}
		
		/*if ($found_txt == 0) {
			$robots[] = 'Sitemap: '.$this->txt_links[0];
		}*/

		$new_robots = $robots;
		$robots = '';
		if ($is_ok == 0 || $to_delete) $robots->new_robots = $new_robots;
		if ($found_xml == 0) $robots->to_add[] = $this->xml_index;
		//if ($found_txt == 0) $robots->to_add[] = $this->txt_links[0];
		if ($to_delete) $robots->to_delete = $to_delete;
		$robots->is_ok = $is_ok;
		return $robots;
	} // check_robots_txt ()
	
	/**
    * Update robots.txt to use width AN SiteMap
    */
	function update_robots (&$robots) {
		global $L;
		$new_robots = array();
		$i = 0;
		foreach ($robots->new_robots as $line) {
			$new_robots[$i] = $line;
			$i++;
		}
		
		// Пока пускай в Роботс ничего не удаляет 
		/*if ($robots->to_delete) {
			$arr = array();
			$arr = $robots->to_delete;
			sort($arr);
			$count = count($arr);
			for ($i=0; $i<$count;$i++) {
				$index = $arr[$count-$i-1].' ';
				unset ($new_robots[intval($index)]);
			}
		}*/
		$file = 'robots.txt';
		if (@$rob=fopen($file,'w+')) {
			foreach ($new_robots as $line) {
				fwrite($rob, trim($line)."\r\n");
			}
			fclose ($rob);
			unset($robots->to_add);
			//unset($robots->to_delete);
			$robots->is_ok = 1;
		}else{
			$this->error = $L['an_sitemap']['err_write_robots']."<br />";
		}
		return $robots;
	} // function update_robots ($robots) {
	
	/**
    * Show all structure parameters
	* @param object - current admin template
    */
	function show_structure(&$tpl){
		global $cfg, $L;
		
		$act = cot_import('act','G','TXT');
		if ($act == 'save') $this->save_structure();
		
		$page = cot_import('page','G','INT');
		$per_page = cot_import('perpage','G','TXT');
		if (empty($page)) $page = 1;
		if (!empty($per_page)){
			if ($per_page == 'all'){
				$per_page = 9999999;
			}
			$_SESSION['AN_SITEMAP_PERPAGE'] = $per_page;
		}else{
			$per_page = (!empty($_SESSION['AN_SITEMAP_PERPAGE'])) ? $_SESSION['AN_SITEMAP_PERPAGE'] : 20;
		}
		$first_item = ($page-1) * $per_page + 1;
		
		if (!empty($_SESSION['AN_SITEMAP_STRUCT_COUNT']) && ($first_item > $_SESSION['AN_SITEMAP_STRUCT_COUNT']) ){
			$first_item = 1;
			$page = 1;
		}
				
		$this->sitemap = array();
		// Рендерим категории
		$this->get_category_tree(1, true);
		
		// Рендерим форум
		$this->get_forums_tree(1);

		$counter = 0;
		foreach($this->sitemap as $area => $entries){
			$this->show_structure_area($tpl, $area, $counter, $per_page);
			$tpl->parse("MAIN.STRUCTURE.ELEMENTS");
		} // foreach($entries[$_root] as $code => $val){
		
		$_SESSION['AN_SITEMAP_STRUCT_COUNT'] = $counter;
		$tpl -> assign(array(
			'CONFIG_FORM_URL' => cot_url('admin', "m=other&p=an_sitemap&task=structure&act=save"),
			'CONFIG_TOTAL_ELEMENTS' => $counter,
			'CONFIG_PER_PAGE_ELEMENTS' => ($per_page == 9999999) ? $L['plu_pagnav_per_page_all'] : $per_page,
			'CONFIG_PAGENAV' => an_pagnav($page, $counter, $per_page, 'admin', "m=other&p=an_sitemap&task=structure",  'page', true),
			
		));
		$tpl -> parse("MAIN.STRUCTURE");
	}
	
	/**
    * Вспомогательная функция
	* Рекурсивно ренрерит для вывода в структуру
	* отдельый раздел карты сайта (категории, форум и т.д.)
	* @param object - current admin template
    */
	function show_structure_area(&$tpl, $area, &$counter = 0, $per_page = 100, $root = '', $level = 1){
		global $L, $plugin_base_url;
		
		$page = cot_import('page','G','INT');
		if (empty($page)) $page = 1;
		
		$first_item = ($page-1) * $per_page + 1;
		if (!empty($_SESSION['AN_SITEMAP_STRUCT_COUNT']) && ($first_item > $_SESSION['AN_SITEMAP_STRUCT_COUNT']) ){
			$first_item = 1;
			$page = 1;
		}
		$last_item = $first_item + $per_page;
		
		$root = ($root == '') ? "ROOT" : $root ;
		$element_out = false;
		foreach($this->sitemap[$area][$root] as $code => $row){
			
			$lev = $level - 1;
			$lev = ($lev > 10) ? 10 : $lev ;
			$tmp = '';
			for ($i = 1; $i <= $lev; $i++){
				$tmp .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if ($tmp != '') $tmp .= "<img src=\"$plugin_base_url/tpl/img/join2.gif\" /> ";
			$lev = $tmp;
			$counter++;
			if ( ($first_item <= $counter) && ($counter < $last_item) ){
				$values = (array("no", "html", "xml_txt", "both"));
				$texts = array();
				$texts[] = $L['an_sitemap']['no'];
				$texts[] = $L['an_sitemap']['to_HTML'];
				$texts[] = $L['an_sitemap']['to_XML_TXT'];
				$texts[] = $L['an_sitemap']['to_all_maps'];
				
				$tpl -> assign(array(
					'STRUCT_CODE' => $code,
					'STRUCT_LEV' => $lev,
					'STRUCT_NAME' => htmlspecialchars($row['title']),
					'STRUCT_ELEM_COUNT' => (int)$row['count'],
					'STRUCT_STATE' => an_selectbox($this->get_state($area ,$code), "state[$area][$code]", $values, $texts ),
					'STRUCT_LINK' => htmlspecialchars($row['link']),
					'STRUCT_LINK_TEXT' => cot_cutstring($row['link'], 64),
					));
				$tpl->parse("MAIN.STRUCTURE.ELEMENTS.ELEMENT_ROW");
				$element_out = true;
			}
			if (isset($this->sitemap[$area][$code])){
				$this->show_structure_area($tpl, $area, $counter, $per_page, $code, $level+1);
			}
		}
		if ($root == "ROOT"){
			if ($element_out){
				$area_name = (isset($L['an_sitemap'][$area])) ? $L['an_sitemap'][$area] : $this->sitemap[$area]['_name_'];
				$area_name = htmlspecialchars($area_name);
				$tpl -> assign(array('STRUCT_AREA_NAME' => $area_name));
			}else{
				$tpl -> assign(array('STRUCT_AREA_NAME' => ''));
			}
		}
	}
	
	/**
    * Save all structure parameters
	* 
    */
	function save_structure(){
		global $db, $L, $an_sitemap_db_struct;
		
		$this->state = array();
		
		$states = cot_import('state', 'P', 'ARR');
		$ins = '';
		foreach($states as $area => $entries){
			foreach($entries as $code => $state){
				// TODO  Если не загружено в память
				$sql = $db->query("SELECT COUNT(*) FROM `$an_sitemap_db_struct` WHERE `area`='$area' AND `code`='$code'")->fetchColumn();
				if ($sql == '0'){
					if ($ins != '') $ins .= ", ";
					$ins .= "( '$area', '$code', '$state' )";
				}else{
					// TODO Если загружено в память и было изменено
					$db->query("UPDATE `$an_sitemap_db_struct` SET `state` = '$state' WHERE `area`='$area' AND `code`='$code'");
				}
			}
		}
		if (!empty($ins)){
			$sql = "INSERT INTO `$an_sitemap_db_struct` (`area`, `code`, `state`) VALUES $ins ;";
			$db->query($sql);
		}
		$this->message .= $L['an_sitemap']['msg_save_struct']."<br />";
		return true;
	}

    /**
    * Show all additional links
    * @param object - current admin template
    */
    function show_add_url(&$tpl){
    	global $db, $cfg, $an_sitemap_db_add_urls, $L, $an_sitemap_stateVal, $an_sitemap_stateTexts, $an_sitemap_freqVal, $an_sitemap_freqTexts, $an_sitemap_priorityVal;
		
		$act = cot_import('act','G','TXT');
		$newlink = array();
		$newlink['add_url_link'] = cot_import('add_url_link','P','TXT');
		$newlink['add_url_link'] = trim($newlink['add_url_link']);
		$newlink['add_url_name'] = cot_import('add_url_name','P','TXT');
		$newlink['add_url_name'] = trim(htmlspecialchars($newlink['add_url_name']));
		$newlink['add_url_desc'] = cot_import('add_url_desc','P','TXT');
		$newlink['add_url_desc'] = htmlspecialchars($newlink['add_url_desc']);
		$newlink['add_url_freq'] = cot_import('add_url_freq','P','ALP');
		$newlink['add_url_last_mod'] = cot_import('add_url_last_mod','P','TXT');
		$newlink['add_url_last_mod'] = trim(htmlspecialchars($newlink['add_url_last_mod']));
		$newlink['add_url_state'] = cot_import('add_url_state','P','ALP');
		$newlink['add_url_priority'] = cot_import('add_url_priority','P','NUM');
		if (empty($newlink['add_url_freq']) || $newlink['add_url_freq'] == '') $newlink['add_url_freq'] = "weekly";
		
		$order = cot_import('order','G','ALP');
		$order = trim(htmlspecialchars($order));
		if (empty($order) || $order == '') $order = 'order';
		
		$sort = cot_import('sort','G','ALP');
		$sort = trim(htmlspecialchars($sort));
		if (empty($sort) || $sort == '') $sort = 'ASC';
		
		// ==== Действия над ссылками ===
		if ($act == 'editall'){
			$this->update_all_additional_urls();
		}
		if ($act == 'addnew'){
			$this->add_new_additional_url($newlink);
		}
		if ($act == 'delurl'){
			$this->delete_additional_url();
		}
		if ($act == 'delgroup'){
			$this->delete_additional_urls_group();
		}
		// ==== Конец: Действия над ссылками ===
		
		// ==== Текущая страница ====
		$page = cot_import('page','G','TXT');
		if ($page != 'last' && $page != '') $page = (int)$page;
		$per_page = cot_import('perpage','G','TXT');
		if (empty($page) || $page == '') $page = 1;
		if (!empty($per_page)){
			if ($per_page == 'all'){
				$per_page = 9999999;
			}
			$_SESSION['AN_SITEMAP_PERPAGE'] = $per_page;
		}else{
			$per_page = (!empty($_SESSION['AN_SITEMAP_PERPAGE'])) ? $_SESSION['AN_SITEMAP_PERPAGE'] : 20;
		}
		$totallines = $db->query("SELECT COUNT(*) FROM $an_sitemap_db_add_urls")->fetchColumn();
		$totalpages = ceil($totallines / $per_page);
		if ($totalpages == 0) $totalpages = 1;
		if ($page == 'last') $page = $totalpages;
		if ($page > $totalpages) $page = $totalpages;
		$begin = ($page-1) * $per_page;
		//$first_item = ($page-1) * $per_page + 1;	
		// Конец: ==== Текущая страница ====
		
		//Выборка строк
		$sql = $db->query("SELECT * FROM $an_sitemap_db_add_urls ORDER BY `$order` $sort LIMIT $begin, $per_page");
		
		//Выводим ссылки
		$num = $begin;
		while($row = $sql->fetch()){
       		$num++;
			$tpl -> assign(array(
				'ADD_URLS_ROW_N' => $num,
				'ADD_URLS_ROW_ID' => $row['id'],
				'ADD_URLS_ROW_NAME' => htmlspecialchars($row['name']),
				'ADD_URLS_ROW_LINK' => htmlspecialchars($row['loc']),
				'ADD_URLS_ROW_DESC' => htmlspecialchars($row['description']),
				'ADD_URLS_ROW_STATE' => an_selectbox($row['state'], "edit_url_state[".$row['id']."]", $an_sitemap_stateVal, $an_sitemap_stateTexts ),
				'ADD_URLS_ROW_CHANGE_FREQ' => an_selectbox($row['changefreq'], "edit_url_freq[".$row['id']."]", $an_sitemap_freqVal, $an_sitemap_freqTexts ),
				'ADD_URLS_ROW_LASTMOD' => $row['lastmod'],
				'ADD_URLS_ROW_ORDER' => $row['order'],
				'ADD_URLS_ROW_PRIORITY' => an_selectbox($row['priority'], "edit_url_priority[".$row['id']."]", $an_sitemap_priorityVal),
				'ADD_URLS_ROW_DEL' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&act=delurl&urlid=".$row['id']."&order=".$order."&sort=".$sort."&page=".$page),
				'ADD_URLS_ROW_DEL_CONFIRM' => str_replace('{link_name}', htmlspecialchars($row['name']), $L['an_sitemap']['url_del_confirm']),
			 ));
        	$tpl -> parse("MAIN.ADD_URLS.ELEMENTS.ELEMENT_ROW");
		}
		
				
		if ($totallines == 0){
			$tpl -> parse("MAIN.ADD_URLS.ELEMENTS.NO_ELEMENTS");
		}
		
		$tpl -> parse("MAIN.ADD_URLS.ELEMENTS");
		
		if (empty($newlink['add_url_state']) || $newlink['add_url_state'] == '') $newlink['add_url_state'] = 'both';
		if (empty($newlink['add_url_priority']) || $newlink['add_url_priority'] == '') $newlink['add_url_priority'] = 0.5;
		
		// TODO сделать порядок сортировки в таблице (ASC / DESC)
		$tpl -> assign(array(
			'ADD_URLS_EDIT_FORM_URL' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&act=editall&order=".$order."&sort=".$sort."&page=".$page),
			'ORDER_BY_NAME_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=name&sort=".$sort."&page=".$page),
			'ORDER_BY_LINK_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=loc&sort=".$sort."&page=".$page),
			'ORDER_BY_DESC_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=description&sort=".$sort."&page=".$page),
			'ORDER_BY_STATE_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=state&sort=".$sort."&page=".$page),
			'ORDER_BY_CHANGE_FREQ_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=changefreq&sort=".$sort."&page=".$page),
			'ORDER_BY_DATE_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=lastmod&sort=".$sort."&page=".$page),
			'ORDER_BY_ORDER_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=order&sort=".$sort."&page=".$page),
			'ORDER_BY_PRIORITY_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=priority&sort=".$sort."&page=".$page),
			'ORDER_BY_ID_HREF' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&order=id&sort=".$sort."&page=".$page),
			'ADD_URLS_DEL_GROUP' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&act=delgroup&order=".$order."&sort=".$sort."&page=".$page),
			
			'ADD_URLS_ADD_FORM_URL' => cot_url('admin', "m=other&p=an_sitemap&task=addlinks&act=addnew&order=order&sort=".$sort."&page=last"),
			'ADD_URL_DISPLAY' => ($act == 'addnew') ? 'block' : 'none',
			'ADD_URL_LINK' => $newlink['add_url_link'],
			'ADD_URL_NAME' => $newlink['add_url_name'],
			'ADD_URL_DESC' => $newlink['add_url_desc'],
			'ADD_URL_STATE' => an_selectbox($newlink['add_url_state'], "add_url_state", $an_sitemap_stateVal, $an_sitemap_stateTexts ),
			'ADD_URL_CHANGE_FREQ' => an_selectbox($newlink['add_url_freq'], "add_url_freq", $an_sitemap_freqVal, $an_sitemap_freqTexts ),
			'ADD_URL_LASTMOD' => $newlink['add_url_last_mod'],
			'ADD_URL_PRIORITY' => an_selectbox($newlink['add_url_priority'], "add_url_priority", $an_sitemap_priorityVal),
			
			'ADD_URLS_TOTAL_ELEMENTS' => $totallines,
			'ADD_URLS_PER_PAGE_ELEMENTS' => ($per_page == 9999999) ? $L['plu_pagnav_per_page_all'] : $per_page,
			'ADD_URLS_PAGENAV' => an_pagnav($page, $totallines, $per_page, 'admin', "m=other&p=an_sitemap&task=addlinks&order=".$order."&sort=".$sort,  'page', true), 

        ));
        $tpl -> parse("MAIN.ADD_URLS");
    }
	
	/**
    * Add new additional link to database
    * @param array
	*	$newlink['add_url_link']
	*	$newlink['add_url_name']
	*	$newlink['add_url_desc']
	*	$newlink['add_url_freq']
	*	$newlink['add_url_last_mod']
	*	$newlink['add_url_state']
	*	$newlink['add_url_priority']
	*	$newlink['add_url_order']
	*
	* return new URL id в случае успеха (или false)
    */
    function add_new_additional_url(&$newlink){
		global $db, $cfg, $an_sitemap_db_add_urls, $L, $an_sitemap_priorityVal;
		
		$canSave = true;
		
		if (empty($newlink['add_url_link']) || $newlink['add_url_link'] == ''){
			$this->error .= $L['an_sitemap']['err_no_url']."<br />";
			$canSave = false;
		}
		
		if (empty($newlink['add_url_name']) || $newlink['add_url_name'] == ''){
			$this->error .= $L['an_sitemap']['err_no_name']."<br />";
			$canSave = false;
		}
		
		if(!in_array($newlink['add_url_priority'], $an_sitemap_priorityVal)){
			$this->error .= $L['an_sitemap']['err_bad_priority']."<br />";
			$canSave = false;
		}
		if (!$canSave) return false;
		
		// Определяем максимальное значение order
		$max_order = (int) $db->query("SELECT MAX(`order`) FROM `$an_sitemap_db_add_urls`")->fetchColumn();
		$max_order++;
		
		$sql = "INSERT INTO $an_sitemap_db_add_urls
			(`name`,
			`loc`,
			`priority`,
			`lastmod`,
			`changefreq`,
			`description`,
			`state`,
			`order`)
			VALUES
			('".$db->prep($newlink['add_url_name'])."',
			'".$db->prep($newlink['add_url_link'])."',
			".$newlink['add_url_priority'].",
			'".$db->prep($newlink['add_url_last_mod'])."',
			'".$db->prep($newlink['add_url_freq'])."',
			'".$db->prep($newlink['add_url_desc'])."',
			'".$db->prep($newlink['add_url_state'])."',
			".$max_order.")";
		$sql = $db->query($sql);
		$urlid = $db->lastInsertId();
		
		$this->message .= $L['an_sitemap']['msg_save_url']."<br />";
				
		return $urlid;
	}
	
	/**
    * Сохраняем отредактированный список дополнительных ссылок
 	* return true в случае успеха (или false)
    */
	function update_all_additional_urls(){
		global $db, $L, $an_sitemap_priorityVal, $an_sitemap_db_add_urls;
		
		$edit_url_id = cot_import('edit_url_id', 'P', 'ARR');
		$edit_url_name = cot_import('edit_url_name', 'P', 'ARR');
		$edit_url_link = cot_import('edit_url_link', 'P', 'ARR');
		$edit_url_desc = cot_import('edit_url_desc', 'P', 'ARR');
		$edit_url_state = cot_import('edit_url_state', 'P', 'ARR');
		$edit_url_freq = cot_import('edit_url_freq', 'P', 'ARR');
		$edit_url_last_mod = cot_import('edit_url_last_mod', 'P', 'ARR');
		$edit_url_order = cot_import('edit_url_order', 'P', 'ARR');
		$edit_url_priority = cot_import('edit_url_priority', 'P', 'ARR');
		
		foreach($edit_url_id as $i){
			$edit_url_name[$i] = trim(htmlspecialchars($edit_url_name[$i]));
			$edit_url_link[$i] = trim($edit_url_link[$i]);
			$edit_url_desc[$i] = htmlspecialchars($edit_url_desc[$i]);
			$edit_url_last_mod[$i] = trim(htmlspecialchars($edit_url_last_mod[$i]));
			
			$canSave = true;
		
			if (empty($edit_url_link[$i]) || $edit_url_link[$i] == ''){
				$this->error .= $L['an_sitemap']['err_edit_url_id'].": <strong>".$i."</strong>. ".$L['an_sitemap']['err_no_url']."<br />";
				$canSave = false;
			}
			
			if (empty($edit_url_name[$i]) || $edit_url_name[$i] == ''){
				$this->error .= $L['an_sitemap']['err_edit_url_id'].": <strong>".$i."</strong>. ".$L['an_sitemap']['err_no_name']."<br />";
				$canSave = false;
			}
			
			if(!in_array($edit_url_priority[$i], $an_sitemap_priorityVal)){
				$this->error .= $L['an_sitemap']['err_edit_url_id'].": <strong>".$i."</strong>. ".$L['an_sitemap']['err_bad_priority']."<br />";
				$canSave = false;
			}
			if (!$canSave) continue;
			
			$sql = "UPDATE `$an_sitemap_db_add_urls`
				SET `name`='".$db->prep($edit_url_name[$i])."',
					`loc`='".$db->prep($edit_url_link[$i])."',
					`priority`=".$edit_url_priority[$i].",
					`lastmod`='".$db->prep($edit_url_last_mod[$i])."',
					`changefreq`='".$db->prep($edit_url_freq[$i])."',
					`description`='".$db->prep($edit_url_desc[$i])."',
					`state`='".$db->prep($edit_url_state[$i])."',
					`order`='".(int)$edit_url_order[$i]."'
				WHERE id=$i LIMIT 1";

			$sql = $db->query($sql);
		}
		
		//TODO - перестроить order, чтобы шли по порядку 1, 2, 3 ... без повторений
		
		$this->message .= $L['Updated']."<br />";
		return true;
		
	}
	
	/*
	* Delete additional url
	* @param int additional url id
	*    Если id = 0, то он берется из $_POST['urlid']
	* return true в случае успеха (или false)	
	*/
	function delete_additional_url($id = 0){
		global $db, $L, $an_sitemap_db_add_urls;
		
		if ($id == 0){
			$id = cot_import('urlid','G','INT');
		}
		if (empty($id) || $id == 0){
			$this->error .= $L['an_sitemap']['err_operation']."<br />";
			return false;
		}
		$sql = "DELETE FROM `$an_sitemap_db_add_urls` WHERE `id`=$id LIMIT 1";
		$sql = cot_sql_query($sql);
		$tmp = $db->affectedRows;
		if ($tmp == 0){
			$this->error .= str_replace('{urlid}', $id, $L['an_sitemap']['err_url_not_deleted'])."<br />";
			return false;
		}else{
			$this->message .= str_replace('{urlid}', $id, $L['an_sitemap']['msg_url_deleted'])."<br />";
			return true;
		}
	}
	
	/*
	* Удаляем группу выделенных ссылок
	* return true в случае успеха (или false, если хоть один URL из группы не удален)	
	*/
	function delete_additional_urls_group(){
		$checks = cot_import('edit_url_check', 'P', 'ARR');
		$res = true;
		foreach($checks as $id){
			if (!$this->delete_additional_url($id)) $res = false;
		}
		
		return $res;
	}
	
    /**
    * Show all integrators parameters
    * @param object - current admin template
    */
    function show_integrators(&$tpl){
		global $cfg, $L;
		
		$act = cot_import('act','G','TXT');
		if ($act == 'save') $this->save_structure();
		
		$page = cot_import('page','G','INT');
		$per_page = cot_import('perpage','G','TXT');
		if (empty($page)) $page = 1;
		if (!empty($per_page)){
			if ($per_page == 'all'){
				$per_page = 9999999;
			}
			$_SESSION['AN_SITEMAP_PERPAGE'] = $per_page;
		}else{
			$per_page = (!empty($_SESSION['AN_SITEMAP_PERPAGE'])) ? $_SESSION['AN_SITEMAP_PERPAGE'] : 20;
		}
		$first_item = ($page-1) * $per_page + 1;
		if (!empty($_SESSION['AN_SITEMAP_INTEGRATORS_COUNT']) && ($first_item > $_SESSION['AN_SITEMAP_INTEGRATORS_COUNT']) ){
			$first_item = 1;
			$page = 1;
		}
		$last_item = $first_item + $per_page;
		
		$values = (array("no", "html", "xml_txt", "both"));
		$texts = array();
		$texts[] = $L['an_sitemap']['no'];
		$texts[] = $L['an_sitemap']['to_HTML'];
		$texts[] = $L['an_sitemap']['to_XML_TXT'];
		$texts[] = $L['an_sitemap']['to_all_maps'];
			
		// Грузим интеграторы
		$files = an_Folder::files($cfg["plugins_dir"], 'integrator.php', 1, true);
		$files = array_unique($files);
		foreach ($files as $file){
			$file_info = pathinfo($file);
			$param = explode('.', $file_info['basename']);
			$param = $param[0];
			include_once($file);
			$integrator = '';
			if (function_exists($param."_sitemap")){
				eval('$integrator = '.$param.'_sitemap($this->show_num);');
				if (is_array($integrator) ){
					$counter++;
					if ( ($first_item <= $counter) && ($counter < $last_item) ){
						$tpl -> assign(array(
							'INTEGRATOR_CODE' => $param,
							'INTEGRATOR_NAME' => $integrator[$param]['_name_'],
							'INTEGRATOR_DESC' => $integrator[$param]['_desc_'],
							'INTEGRATOR_STATE' => an_selectbox($this->get_state('integrators' ,$param), "state[integrators][$param]", $values, $texts ),
						));
						$tpl->parse("MAIN.INEGRATORS.INEGRATORS_ROW");
					}
				}
			}
		}
		
		$_SESSION['AN_SITEMAP_INTEGRATORS_COUNT'] = $counter;
		$tpl -> assign(array(
			'CONFIG_FORM_URL' => cot_url('admin', "m=other&p=an_sitemap&task=integrators&act=save"),
			'CONFIG_TOTAL_ELEMENTS' => $counter,
			'CONFIG_PER_PAGE_ELEMENTS' => ($per_page == 9999999) ? $L['plu_pagnav_per_page_all'] : $per_page,
			'CONFIG_PAGENAV' => an_pagnav($page, $counter, $per_page, 'admin', "m=other&p=an_sitemap&task=integrators",  'page', true),
			
		));
		$tpl -> parse("MAIN.INEGRATORS");
	}
	
	/**
	* В какой карте отображать (или нет) данный элемент
	* @param string $area - область (page,)
	* @param string $code
	* @returns string
	*/
	function get_state($area, $code){
		global $db, $an_sitemap_db_struct;
		
		if (empty($this->state[$area])){
			$sql = $db->query("SELECT `code`, `state`, `default` FROM `$an_sitemap_db_struct` WHERE `area`='$area'");
			while ($row = $sql->fetch()){
				$this->state[$area][$row['code']] = $row['state'];
			}
		}
		
		if ($code != 'ROOT'){
			if (!empty($this->state[$area][$code])) return $this->state[$area][$code];
			// Нельзя искать ближайшего родителя с установленным значением родителя
			// т.к. дерево еще не загружено :)
		}
		// Выводим настройку для самого раздела
		if ($area == 'integrators' ) return 'both';
		if ($area == 'lists' ) return $this->add_lists;
		if ($area == 'forums' ) return $this->add_forums;
			
		return false;
	}
	
	
	// ----============= ::: End: Admin Part ::: ===============----
	
	
	// ========== Pages and lists =============
	
	/**
	* Returns category tree
	* @param string $root - root category of the tree
	* @param int $show_num - include item count info
	* @param boolean $add_empty
	* @param boolean $access_enabled_only - проверить на права доступа и исключения
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
   function get_category_tree($show_num = 0, $add_empty = false, $access_enabled_only = false, $map_type = "both") {
	   global $db, $cot_cat, $db_structure, $db_auth, $an_sitemap_db_struct, $db_pages, $cfg;
	   
	   $denied = array();
	   $where = '';
		if ($access_enabled_only){
			if ($this->add_lists != $map_type && $this->add_lists != 'both') return false;

			// Check the categories with no read rights for quests 
			$sql = $db->query("SELECT auth_option, auth_rights FROM $db_auth WHERE auth_code='page' AND auth_groupid=1");
			while ($row = $sql->fetch())	{
				if($row['auth_rights']==0) $denied[] = $row['auth_option'];
			}
			
			// Выборка категорий запрещенных к добавлению в карту сайта:
			$sql = $db->query("SELECT code FROM $an_sitemap_db_struct WHERE area='lists' AND NOT (state='both' OR  state='$map_type')");
			while ($row = $sql->fetch()){
				$denied[] = $row['code'];
			}
			//$where = "WHERE structure_code NOT IN ('".implode("','", $denied)."')";
			$where = "WHERE page_state=0 AND page_cat NOT IN ('".implode("','", $denied)."')";
		}

	   	// Process The Counters 
		//$sql = $db->query("SELECT structure_code, structure_pagecount FROM $db_structure $where");
		$sql = $db->query("SELECT DISTINCT(page_cat), COUNT(*) FROM $db_pages $where GROUP BY page_cat");
		while ($row = $sql->fetch()){
			$pagecount[$row['page_cat']] = $row['COUNT(*)'];
		}
		/*while ($row = $sql->fetch()) {
			$pagecount[$row['structure_code']] = (int)$row['structure_pagecount']; 
		}*/
		$sql->closeCursor();

	   if (empty($this->sitemap['lists'])){
	   	   $this->sitemap['lists'] = array();
		   $k = 0;
		   foreach($cot_cat as $code => $val){
				$items_count = (int) $db->query("SELECT COUNT(*) FROM $db_pages p LEFT JOIN $db_structure s ON (p.page_cat = s.structure_code) WHERE s.structure_path LIKE '".$val['rpath'].".%' OR s.structure_path LIKE '".$val['rpath']."'")->fetchColumn();
				//$items_count = (int)sed_sql_result($sql, 0, "SUM(structure_pagecount)");
				
				if(in_array($code, $denied)) continue;
				if ( !$add_empty && $items_count <= 0) continue;
				
				// TODO под Siena переделать вывод ссылок с паджинацией т.к. она будет другой
				$totalpage = ceil($pagecount[$code] / $cfg['maxrowsperpage']);
				for ($i = 0; $i <= $totalpage; $i++){	
					if($i == 0){
						$param = 'c='.$code;
						$code1 = $code;
					}else{
						if ($map_type != "xml_txt") break;
						if ($i == $totalpage) break;
						$param = 'c='.$code."&d=".($i * $cfg['maxrowsperpage']);
						$code1 = $code."_".$i."_";
					}
					$anrow = array();
					$tmp = explode(".", $val['path']);
					$parent = (count($tmp) > 1) ? $tmp[count($tmp)-2] : "ROOT";
	
					$anrow['title'] = htmlspecialchars($val['title']);
					if ($show_num == 1) $anrow['count'] = $items_count;
					$anrow['link'] = cot_url('page', $param);
					if (!cot_url_check($anrow['link'])){
						$anrow['link'] = $cfg['mainurl']."/".$anrow['link'];
					}
					$anrow['priority'] = $this->priority_lists;
					$anrow['changefreq'] = $this->freq_lists;
					if (!empty($val['desc']) && $val['desc'] != '') $anrow['desc'] = htmlspecialchars($val['desc']);
									
					// Ищем дату последней страницы в этой категории (для xml_txt):
					if ($map_type == "xml_txt"){
						$tmp = (int) $db->query("SELECT MAX(page_date) FROM $db_pages WHERE `page_cat`='$code'")->fetchColumn();
						$anrow['lastmod'] = (empty($tmp) || $tmp == 0) ? date('Y-m-d\TH:i:s+00:00') : date('Y-m-d\TH:i:s+00:00', $tmp);
					}
					$this->sitemap['lists'][$parent][$code1]=$anrow;
					$k++;
				}
			}	// foreach($cot_cat as $code => $val){
			$this->sitemap['lists']['_count_'] = $k;
		}
		return $this->sitemap['lists'];
   }
	
	/**
	* Returns pages tree
	* Поскольку страницы в HTML карте выводятся как часть списка категорий
	*    то вложенность категрий при построении дерева учитывать не будем
	*    и в HTML карте родительским будет код категории
	* Для корректного отображения в XML и TXT родительским будет по-прежнему ROOT,
	*   иначе будет некорректный вывод
	* TODO - нормальное дерево с категориями в качестве родителя
	*
	* @param boolean $access_enabled_only - проверить на права доступа и исключения
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
	function get_pages_tree($access_enabled_only = false, $map_type = "xml_txt"){
		global $db, $db_pages, $an_sitemap_db_struct, $db_auth, $cfg, $row;
		
		$where = "";
		if ($access_enabled_only){
			$denied = array();
			if ($this->add_pages != $map_type && $this->add_pages != 'both') return false;
			// Check the categories with no read rights for quests //
			$sql = $db->query("SELECT auth_option, auth_rights FROM $db_auth WHERE auth_code='page' AND auth_groupid=1");
			while ($row = $sql->fetch())	{		
				if($row['auth_rights']==0) $denied[] = $row['auth_option'];
			}
			
			// Выборка категорий запрещенных к добавлению в карту сайта:
			$sql = $db->query("SELECT `code` FROM $an_sitemap_db_struct WHERE `area`='lists' AND NOT (`state`='both' OR `state`='$map_type')");
			while ($row = $sql->fetch()){
				$denied[] = $row['code'];
			}
			$where = "WHERE page_state=0 AND page_cat NOT IN ('".implode("','", $denied)."')";
		}
		$sql = $db->query("SELECT `page_id`, `page_title` as `title`, `page_desc` as `desc` ,`page_cat`, `page_alias`, `".$this->page_last_mod_field."`, (LENGTH(page_text) - LENGTH(REPLACE(page_text, '[newpage]', ''))) div LENGTH('[newpage]') + 1 AS `sub_count` FROM $db_pages $where ORDER BY page_cat");
		$i = 0;
		
		while ($row = $sql->fetch()){
			for ($k = 0; $k < (int)$row['sub_count']; $k++){
				$param = (empty($row['page_alias'])) ? "id=".$row['page_id'] : "al=".$row['page_alias'];
				$indx = $row['page_id'];
				if ($k > 0){
					if ($map_type == 'html') break;
					$param .= '&pg='.$k;
					$indx .= '_'.$k;
				}
				
				$row['link'] = cot_url('page', $param);
				if (!cot_url_check($row['link'])){
					$row['link'] = $cfg['mainurl']."/".$row['link'];
				}
				$row['desc'] = htmlspecialchars($row['desc']);
				$row['priority'] = $this->priority_pages;
				$row['changefreq'] = $this->freq_pages;
				$row['lastmod'] = (empty($row['page_date']) || $row['page_date'] == 0) ? date('Y-m-d\TH:i:s+00:00') : date('Y-m-d\TH:i:s+00:00', $row['page_date']);
				if ($map_type == 'html'){
					$this->sitemap['pages'][$row['page_cat']][$indx] = $row;
				}else{
					$this->sitemap['pages']['ROOT'][$indx] = $row;
				}
				$i++;
			}
		}
		$this->sitemap['pages']['_count_'] = $i;
		$sql->closeCursor();
	}
	
	// ========== END: Pages and lists =============
	
	// ========== Аdditional urls =============
	
	/**
	* Returns Additional urls tree
	* @param string $root - root category of the tree
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
   function get_additional_urls($map_type = "both") {
	   global $db, $an_sitemap_db_add_urls;
		
		switch($map_type){
			case 'both':
				$where = "WHERE `state`='html' OR `state`='xml_txt' OR `state`='both'";
				$select = "`id`, `name`, `description`, `loc`, `priority`, `lastmod`, `changefreq`";
				break;
			
			case 'html':
				$where = "WHERE `state`='html' OR `state`='both'";
				$select = "`id`, `name`, `description`, `loc`";
				break;
		
			case 'xml_txt':
				$where = "WHERE `state`='xml_txt' OR `state`='both'";
				$select = "`id`, `loc`, `priority`, `lastmod`, `changefreq`";
				break;
	
			default:
				$this->error .= $L['an_sitemap']['err_unknown_state'].": ".$map_type;
				return false;
				break;
			}

		
		//Выборка строк
		$sql = $db->query("SELECT $select FROM $an_sitemap_db_add_urls $where ORDER BY `order` ASC");
		$i = 0;
		while($row = $sql->fetch()){
			$url['link'] = $row["loc"];
			if ($row["name"]) $url['title'] = htmlspecialchars($row["name"]);
			if ($row["description"]) $url['desc'] = htmlspecialchars($row["description"]);
			if ($row["priority"]) $url['priority'] = $row["priority"];
			if ($row["changefreq"]) $url['changefreq'] = $row["changefreq"];
			if ($row["lastmod"]) $url['lastmod'] = $row["lastmod"];
			$this->sitemap['additional_urls']['ROOT'][$row['id']] = $url;
			
			$i++;
		}
		if ($i > 0) $this->sitemap['additional_urls']['_count_'] = $i;
		$sql->closeCursor();
	}
	// ========== END: Аdditional urls =============
	
	// ========== Forums =============
	
	/**
	* Returns forums tree
	* @param string $root - root section of the tree
	* @param int $show_num - include item count info
	* @param boolean $access_enabled_only - проверить на права доступа и исключения
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
	function get_forums_tree($show_num = 0, $access_enabled_only = false, $map_type = "both"){
		global $db, $db_forum_stats, $db_auth, $an_sitemap_db_struct, $cfg, $structure, $L;
		
		$k = 0;
		// Add the main page of forums forums.php for XML_TXT
		if ($map_type == "xml_txt"){
			$this->sitemap['forums']['ROOT']['_main_forums_page_']['link'] = cot_url('forums');
			if (!cot_url_check($this->sitemap['forums']['ROOT']['_main_forums_page_']['link'])){
				$this->sitemap['forums']['ROOT']['_main_forums_page_']['link'] = $cfg['mainurl']."/".$this->sitemap['forums']['ROOT']['_main_forums_page_']['link'];
			}
			$this->sitemap['forums']['ROOT']['_main_forums_page_']['priority'] = $this->priority_sections;
			$this->sitemap['forums']['ROOT']['_main_forums_page_']['changefreq'] = $this->freq_sections;
			$k++;
		}

		// Get forum stats
		$cat_top = array();
		$sql_forums = $db->query("SELECT * FROM $db_forum_stats WHERE 1 ORDER by fs_cat DESC");
		foreach ($sql_forums->fetchAll() as $row) {
			$cat_top[$row['fs_cat']] = $row;
		}

		// Forum structure
		if ($access_enabled_only){
			$denied = array();
			if ($this->add_forums != $map_type && $this->add_forums != 'both') return false;

			// Check the categories with no read rights for quests
			$sql = $db->query("SELECT `auth_option`, `auth_rights` FROM `$db_auth` WHERE `auth_code`='forums' AND `auth_groupid`=1");
			while ($row = $sql->fetch())	{
				if($row['auth_rights']==0) $denied[] = $row['auth_option'];
			}

			// Выборка разделов форума, запрещенных к добавлению в карту сайта:
			$sql = $db->query("SELECT code FROM $an_sitemap_db_struct WHERE area='forums' AND NOT (state='both' OR state='$map_type')");
			while ($row = $sql->fetch()){
				$denied[] = $row['code'];
			}
		}

		foreach ($structure['forums'] as $code => $row){
			if (!in_array($code, $denied)) {
				$parents = explode('.', $row['path']);
				$depth = count($parents);

				if ($depth == 1) {
					if ($map_type == "xml_txt") {
						// SEO: c=blablabla links are redundant, nofollow by search engines
						continue;
					}
					$parent = 'ROOT';
					$link_param = 'c=' . $code;
				} elseif ($depth == 2) {
					$parent = 'ROOT';
					$link_param = 'm=topics&s=' . $code;
				} else {
					$parent = $parents[$depth - 2];
					$link_param = 'm=topics&s=' . $code;
				}

				$totalpage = $depth == 1 ? 1 : ceil($cat_top[$code]['fs_topiccount'] / $cfg['forums']['maxtopicsperpage']);

				for ($i = 0; $i < $totalpage; $i++){
					if($i == 0){
						$param = $link_param;
						$icode = $code;
						$title = $row['title'];
					}else{
						if ($map_type != "xml_txt") break;
						$param = $link_param . "&d=";
						$param .= $cfg['easypagenav'] ? $i + 1 : $i * $cfg['forums']['maxtopicsperpage'];
						$icode = $code."_".$i;
						$title = $row['title'] . ' (' . $L['Page'] . ' ' . ($i + 1) . ')';
					}

					$this->sitemap['forums'][$parent][$icode]['title'] = $row['title'];
					$this->sitemap['forums'][$parent][$icode]['link'] = $cfg['mainurl'] . '/' . cot_url('forums', $param);
					if ($show_num == 1) $this->sitemap['forums'][$parent][$code]['count'] = $cat_top[$code]['fs_topiccount'];
					$this->sitemap['forums'][$parent][$icode]['priority'] = $this->priority_sections;
					$this->sitemap['forums'][$parent][$icode]['changefreq'] = $this->freq_sections;
					$this->sitemap['forums'][$parent][$icode]['lastmod'] = date('Y-m-d\TH:i:s+00:00', $cat_top[$code]['fs_lt_date']);

					if ($depth == 1) {
						$this->sitemap['forums']['ROOT'][$code]['topics'] = $cat_top[$code]['fs_topiccount'];
						$this->sitemap['forums']['ROOT'][$code]['posts'] = $cat_top[$code]['fs_postcount'];;
					}
				}

				if ($map_type == "xml_txt"){
					$this->sitemap['forums']['ROOT']['_main_forums_page_']['lastmod'] = max($this->sitemap['forums']['ROOT']['_main_forums_page_']['lastmod'], $cat_top[$code]['fs_lt_date']);
				}
				$k++;
			}
		}

		// Add the main page of forums forums.php for XML_TXT lastmod value
		if ($map_type == "xml_txt"){
			$this->sitemap['forums']['ROOT']['_main_forums_page_']['lastmod'] = (empty($this->sitemap['forums']['ROOT']['_main_forums_page_']['lastmod']) || $this->sitemap['forums']['ROOT']['_main_forums_page_']['lastmod'] == 0) ? date('Y-m-d\TH:i:s+00:00') : date('Y-m-d\TH:i:s+00:00', $this->sitemap['forums']['ROOT']['_main_forums_page_']['lastmod']);
		}
		$sql->closeCursor();
		$this->sitemap['forums']['_count_'] = $k;
		
		return $this->sitemap['forums'];
	} // function get_forums_tree()
	
	/**
	* Returns forum topics tree
	* На самом деле страницы пока складируются в ROOT. 
	* т.к. они выводятся только в списках XML_TXT
	* @param boolean $access_enabled_only - проверить на права доступа и исключения
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
	function get_forum_topics_tree($access_enabled_only = false, $map_type = "xml_txt"){
		global $db, $cfg, $L, $an_sitemap_db_struct, $db_structure, $db_forum_topics, $db_auth;
		$denied = array();
		$where = '';
		if ($access_enabled_only){
			if ($this->add_forums != $map_type && $this->add_forums != 'both') return false;

			// Check the categories with no read rights for quests 
			$sql = $db->query("SELECT auth_option, auth_rights FROM $db_auth WHERE auth_code='forums' AND auth_groupid=1");
			while ($row = $sql->fetch())	{
				if($row['auth_rights']==0) $denied[] = $row['auth_option'];
			}
			
			// Выборка категорий запрещенных к добавлению в карту сайта:
			$sql = $db->query("SELECT code FROM $an_sitemap_db_struct WHERE area='forums' AND NOT (state='both' OR state='$map_type')");
			while ($row = $sql->fetch()){
				$denied[] = $row['code'];
			}
			$where = "WHERE t.ft_cat NOT IN ('".implode("','", $denied)."') AND t.ft_mode=0";
		}
		$sql = $db->query("SELECT t.ft_id, t.ft_cat, t.ft_updated, t.ft_postcount FROM $db_forum_topics t
			LEFT JOIN $db_structure s ON (s.structure_area = 'forums' AND t.ft_cat = s.structure_code) $where ORDER BY t.ft_cat");
		$k = 0;
		
		while ($row = $sql->fetch())	{
			// TODO под Siena переделать вывод ссылок с паджинацией т.к. она будет другой
			$totalpage = ceil($row['ft_postcount'] / $cfg['forums']['maxpostsperpage']);
			for ($i = 0; $i < $totalpage; $i++){	
				if($i == 0){
					$param = "m=posts&q=".$row['ft_id'];
					$code = $row['ft_id'];
				}else{
					if ($map_type != "xml_txt") break;
					$param = "m=posts&q=".$row['ft_id']."&d=".($cfg['easypagenav'] ? $i + 1 : $i * $cfg['forums']['maxpostsperpage']);
					$code = $row['ft_id']."_".$i;
				}
				$row['link'] = $cfg['mainurl'] . '/' . cot_url('forums', $param);
				$row['priority'] = $this->priority_topics;
				$row['changefreq'] = $this->freq_topics;
				$row['lastmod'] = (empty($row['ft_updated']) || $row['ft_updated'] == 0) ? date('Y-m-d\TH:i:s+00:00') : date('Y-m-d\TH:i:s+00:00', $row['ft_updated']);
				$this->sitemap['topics']['ROOT'][$code] = $row;
				$k++;
			}
		}
		$this->sitemap['topics']['_count_'] = $k;
		$sql->closeCursor();
	}
	
	// ========== END: Forums =============
	
	// ========== Users =============
	/**
	* Returns user list for XML_TXT SiteMaps
	* @param boolean $access_enabled_only - проверить на права доступа и исключения
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
	function get_users_tree($access_enabled_only = false, $map_type = "xml_txt"){
		global $db, $db_users, $cfg;
		if ($access_enabled_only && !cot_auth('users', 'a', 'R')) return false;
		
		// TODO под Siena переделать вывод ссылок с паджинацией т.к. она будет другой
		$totalusers = $db->query("SELECT COUNT(*) FROM $db_users WHERE 1")->fetchColumn();
		$totalpage = ceil($totalusers / $cfg['maxusersperpage']);
		
		for ($i = 0; $i < $totalpage; $i++){	
			if($i==0){
				$param = '';
			}else{
				if ($map_type != "xml_txt") break;
				$param = "f=all&s=name&w=asc&d=".($i * $cfg['maxusersperpage']);
			}
			$this->sitemap['users']['ROOT'][$i]['link'] = cot_url( 'users', $param );
			if (!cot_url_check($this->sitemap['users']['ROOT'][$i]['link'])){
				$this->sitemap['users']['ROOT'][$i]['link'] = $cfg['mainurl']."/".$this->sitemap['users']['ROOT'][$i]['link'];
			}
			$this->sitemap['users']['ROOT'][$i]['priority'] = $this->priority_user_lists;
			$this->sitemap['users']['ROOT'][$i]['changefreq'] = $this->freq_user_lists;
		}
		$this->sitemap['users']['_count_'] = $totalpage;
	} 
	
	/**
	* Returns user profiles tree
	* На самом деле профили пока складируются в ROOT. 
	* т.к. они выводятся только в списках XML_TXT
	* @param boolean $access_enabled_only - проверить на права доступа и исключения
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
	function get_user_profs_tree($access_enabled_only = false, $map_type = "xml_txt"){
		global $db, $db_users, $cfg;
		if ($access_enabled_only && !cot_auth('users', 'a', 'R')) return false;
		
		$sql = $db->query("SELECT user_id, user_name, user_regdate FROM $db_users WHERE 1 ORDER BY user_id ASC");
		$k = 0;
		while ($row = $sql->fetch()){
			$val['user_name'] = htmlspecialchars($row['user_name']);
			$val['link'] = cot_url('users', 'm=details&id='.$row['user_id'].'&u='.$val['user_name']);
			if (!cot_url_check($val['link'])){
				$val['link'] = $cfg['mainurl']."/".$val['link'];
			}
			$val['priority'] = $this->priority_user_profiles;
			$val['changefreq'] = $this->frefreq_user_profiles;
			// За дату модификации профиля пока берем дату регистрации
			// Это не актуально, если у нас не соц.сеть :)
			$val['lastmod'] = (empty($row['user_regdate']) || $row['user_regdate'] == 0) ? date('Y-m-d\TH:i:s+00:00') : date('Y-m-d\TH:i:s+00:00', $row['user_regdate']);
			$this->sitemap['user_profs']['ROOT'][$row['user_id']] = $val;
			$k++;
		}
		$sql->closeCursor();
		$this->sitemap['user_profs']['_count_'] = $k;
	}
	
	// ========== END: Users =============
	
	// ========== Integrators =============
	/**
	* Returns integrators tree
	* @param string $root - root section of the tree
	* @param int $show_num - include item count info
	* @param boolean $access_enabled_only - проверить на права доступа и исключения
	* @param string $map_type - type of the site map ("html", "xml_txt", "both")
	* @returns array
	*/
	function get_integrators($show_num = 0, $access_enabled_only = false, $map_type = "both"){
		global $db, $cfg, $an_sitemap_db_struct;
		
		$denied = array();
		if ($access_enabled_only){
			// Выборка разделов форума, запрещенных к добавлению в карту сайта:
			$sql = $db->query("SELECT code FROM $an_sitemap_db_struct WHERE area='integrators' AND NOT (state='both' OR state='$map_type')");
			while ($row = $sql->fetch()){
				$denied[] = $row['code'];
			}
		}
		$files = an_Folder::files($cfg["plugins_dir"], 'integrator.php', 1, true);
		$files = array_unique($files);
		foreach ($files as $file){
			$file_info = pathinfo($file);
			$param = explode('.', $file_info['basename']);
			$param = $param[0];
			if(in_array($param, $denied)) continue;
			include_once($file);
			$tmp = '';
			if (function_exists($param."_sitemap")){
				eval('$tmp = '.$param.'_sitemap($this->show_num);');
				if(!is_array($tmp)) continue;	
				foreach($tmp as $key => $value){
					if ($key == $param){
						$this->sitemap[$param] =  $value;
					}else{
						$this->sitemap[$key] = array_extend($this->sitemap[$key], $value);
					}
				}
			}
		} // foreach ($files as $file){
		
	}
	// ========== End: Integrators  =============
	
	/*
	* Загружает данные из кеша и сохраняет в $this->sitemap
	* вернет true в случае успеха иначе false
	*/
	protected function load_from_cache($area){
		$cache_file = $this->cache_path.DS.$area.'.cache';
		if (strlen($area)<=0 || !file_exists($cache_file)) return false;
		$file_time = filectime($cache_file);
		$now = time();
		$diff = ($now-$file_time);
		if ($diff <= ($this->cache_time * 3600) ){
			$this->sitemap = unserialize(implode('', file($cache_file) ) );
			return true;
		} else {
			@unlink($cache_file);
			return false;
		}
		return false;
		
	}
	
	/*
	* Write Data to Cache
	* @param string - тип карты сайта
	*/
	protected function write_to_cache($area){
		// Проверяем наличие папки для кеша
		if (!is_file($this->cache_path)){
			// attempt to make the dir
			@mkdir($this->cache_path, 0777);
		}
		
		if (strlen($area)<=0) return false;
		
		$cache_file = $this->cache_path.DS.$area.'.cache';
		$file = @fopen($cache_file, 'w');
		if ($file){	
			fwrite($file, serialize($this->sitemap));
			fclose($file);
			return true;
		}

		return false;
	}
	
	// ========== HTML sitemap =============
	/*
	* Вспомогательная функция.
	* Рекурсивно проходим дерево карты сайта
	*   и выводим элементы в HTML карту
	* @param object $tpl   - current template
	* @param string $area  - site map area
	* @param int $counter  - URL counter
	* @param int $page     - текущая страница карты
	* @param int $per_page - количество ссылок на страницу
	* @param int $root      - Корневой элемент
	* @param int $level     - Уровень вложенности в родительский элемент
	*  
	*  TODO Не проходить весь массив карты, а только до последнего необходимого URL
	*/
	function show_html_area(&$tpl, $area, $page, $per_page = 100, &$counter = 0, $root = '', $level = 1){
		global $L;

		$root = ($root == '') ? 'ROOT' : $root ;
		if (!is_array($this->sitemap[$area][$root])) return false;

		$first_item = ($page-1) * $per_page + 1;
		if ($first_item > $this->html_urls_count ){
			$first_item = 1;
			$page = 1;
		}
		$last_item = $first_item + $per_page;
		
		$result = '';
		$element_out = false;
		foreach($this->sitemap[$area][$root] as $code => $row){
			if (!is_array($row)) continue;
			if (empty($row['link']) || $row['link'] == '' ) continue;
			$counter++;
			
			//if ($counter >= $last_item) return $result;
			if ( ($first_item <= $counter) && ($counter < $last_item) ){
				
				$row['title'] = htmlspecialchars($row['title']);
				$row['title'] = str_replace("&amp;", "&", $row['title']);
				$row['target'] = (!empty($val['target'])) ? $row['target'] : '';
				$tpl-> assign(array(
					"ROW_TITLE" => $row['title'],
					"ROW_DESC" => $row['desc'],
					"ROW_ICON" => $row['icon'],
					"ROW_ITEM_COUNT" => (string)$row['count'],
					"ROW_LINK" => $row['link'],
					"ROW_TARGET" => $row['target'],
					"ROW_ODDEVEN" => cot_build_oddeven($counter),
					"ROW_ITEM_NUMBER" =>$counter,
					"ROW_LEVEL" => ($level > 10) ? 'x' : $level,
				));
				// Если выводится категория, то вывести ее страницы:
				if ($area == 'lists'){
					if (!empty($this->sitemap['pages'][$code]) && count($this->sitemap['pages'][$code] > 0)) {
						foreach($this->sitemap['pages'][$code] as $element){
							$tpl-> assign(array(
								"ELEMENT_ROW_TITLE" => $element['title'],
								"ELEMENT_ROW_LINK" => $element['link'],
								"ELEMENT_ROW_DESC" => $element['desc'],
								"ELEMENT_ROW_TARGET" => $element['target'],
								"ELEMENT_ROW_LEVEL" => ($level > 9) ? 'x' : $level + 1,
							));
							$tpl->parse("MAIN.LIST.CATEGORIES.CATEGORIES_ROW.ELEMENT.ELEMENT_ROW");
						}
						$tpl->parse("MAIN.LIST.CATEGORIES.CATEGORIES_ROW.ELEMENT");
					}
				} // if ($area == 'lists'){
				$tpl->parse("MAIN.LIST.CATEGORIES.CATEGORIES_ROW");
				$element_out = true;
				
			} // if ( ($first_item <= $counter) && ($counter < $last_item) ){
			
			if (isset($this->sitemap[$area][$code])){
				$this->show_html_area($tpl, $area, $page, $per_page, $counter, $code, $level+1);
			}
			
		} // foreach($this->sitemap[$area][$root] as $code => $row){
		if ($root == "ROOT"){
			if ($element_out){
				$area_name = (isset($L['an_sitemap'][$area])) ? $L['an_sitemap'][$area] : $this->sitemap[$area]['_name_'];
				$area_name = htmlspecialchars($area_name);
				$tpl -> assign(array('AREA_NAME' => $area_name));
			}else{
				$tpl -> assign(array('AREA_NAME' => ''));
			}
		}
	}
	
	/**
	* Renders HTML Sitemap
	* @param &$template - xTemplate object
	*/
	function html_sitemap_out(&$tpl){
		global $db, $L, $db_users;
			
		$this->sitemap = array();
		$this->html_urls_count = 0;
		
		// ==== Грузим данные для карты ====
		
		$cahe_loaded = false;
		if ($this->enable_cache && !empty($this->cache_path)){
			$cahe_loaded = $this->load_from_cache('html');
			//Загрузить количество ссылок
			if (file_exists($this->cache_path.DS.'html.links_count.cache')){
				$this->html_urls_count = implode('', file($this->cache_path.DS.'html.links_count.cache') ) ;
			}
		}

		if (!$cahe_loaded || empty($this->sitemap)){
			// Собираем категории
			if ($this->add_lists == 'html' || $this->add_lists == 'both'){
				$add_empty_cats = ($this->add_empty_lists == "html" || $this->add_empty_lists == "both") ?  true : false;
				$this->get_category_tree($this->show_num, $add_empty_cats, true, 'html');
			}
			
			// Собираем страницы все, что можно :)
			if ($this->add_pages == 'html' || $this->add_pages == 'both'){
				$this->get_pages_tree(true, 'html');
			}
			
			// Собираем дополнительные ссылки
			$this->get_additional_urls('html');
			
			// Собираем интеграторы
			$this->get_integrators($this->show_num, true, 'html');
	
			// Собираем форум
			if ($this->add_forums == 'html' || $this->add_forums == 'both'){
				$this->get_forums_tree($this->show_num, true, 'html');
			}
			// Собираем Список пользователей
			if ( ($this->add_users == 'html' || $this->add_users == 'both') && cot_auth('users', 'a', 'R')){
				$this->sitemap['users']['ROOT'][1]['title'] = $L['an_sitemap']['user_list'];
				$this->sitemap['users']['ROOT'][1]['link'] = cot_url('users');
				$this->sitemap['users']['_name_'] = $L['an_sitemap']['users'];
				$this->sitemap['users']['_count_'] = 1;
				if ($this->show_num == 1){
					$this->sitemap['users']['ROOT'][1]['count'] = $db->query("SELECT COUNT(*) FROM $db_users")->fetchColumn();
				}
			}
			if ($this->enable_cache && !empty($this->cache_path)){
				$this->write_to_cache('html');
			}
			$this->html_urls_count = 0;
			foreach($this->sitemap as $area => $entries){
				if ($area != 'pages') $this->html_urls_count += $this->sitemap[$area]['_count_'];
			}
			// Cохраним количество ссылок
			$file_name = $this->cache_path.DS.'html.links_count.cache';
			$file = @fopen($file_name, 'w');
			if ($file){
				fwrite($file, ($this->html_urls_count));
				fclose($file);
			}
			
		}
		// ==== Конец: Грузим данные для карты ====
		
		// ==== Паджинация ====
		$page = cot_import('page','G','INT');
		$per_page = cot_import('perpage','G','TXT');
		if (empty($page)) $page = 1;
		if (!empty($per_page)){
			if ($per_page == 'all'){
				$per_page = 9999999;
			}
			$_SESSION['AN_SITEMAP_PERPAGE'] = $per_page;
		}else{
			$per_page = (!empty($_SESSION['AN_SITEMAP_PERPAGE'])) ? $_SESSION['AN_SITEMAP_PERPAGE'] : $this->max_html_urls;
		}
		// ==== Конец: Паджинация ====
		
		// Выводим элементы заполненой карты сайта
		$counter = 0;
		foreach($this->sitemap as $area => $entries){
			// Выводим все разделы карты кроме страниц, страницы выводятся в категориях (lists)
			if ($area != 'pages'){
				$this->show_html_area($tpl, $area, $page, $per_page, $counter);
				$tpl->parse("MAIN.LIST.CATEGORIES");
			}
		}
		
		if ($this->html_urls_count == 0 ) $this->html_urls_count = $counter;
		$tpl->parse("MAIN.LIST");

		// Паджинация
		$tpl->assign(array(
			"PLUGIN_PAGENAV" => an_pagnav($page, $this->html_urls_count, $per_page, 'plug', "e=an_sitemap",  'page', true),
		));

	} // function html_sitemap_out(){
	
	// ========== END: HTML sitemap =============
	
	// ==========   XML  sitemap   =============
	
	/**
	* Renders XML Sitemap
	* @param void
	*/
	function out_xml_map(){
		$page = cot_import('pt','G','INT');
		if (empty($page)) $page = 1;
		
		$this->get_xml_txt_data();
		
		$sitemap = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		// Выводим элементы заполненой карты сайта
		$counter = 0;
		foreach($this->sitemap as $area => $entries){
			if (!is_array($entries)) continue;
			$sitemap .= $this->out_xml_map_area($area, $page, $counter);
		}
		
		$sitemap .= "\n</urlset>";
		
		return $sitemap;
	}
	
	/*
	* Вспомогательная функция.
	* Рекурсивно проходим дерево карты сайта
	* и добавляем элементы в XML карту
	* @param string $area - site map area
	* @param int $page - текущая часть XML-карты
	* @param int $counter - URL counter
	* @param string $roor - Корневой элемент
	*/
	function out_xml_map_area($area, $page, &$counter = 0, $root = ''){
		$root = ($root == '') ? 'ROOT' : $root ;
		
		if (!is_array($this->sitemap[$area][$root])) return false;
		
		$first_item = ($page-1) * $this->max_xml_urls + 1;
		if ($first_item > $this->xml_links_count ){
			$first_item = 1;
			$page = 1;
		}
		$last_item = $first_item + $this->max_xml_urls;
		
		$result = '';
		foreach($this->sitemap[$area][$root] as $code => $row){
			if (!is_array($row)) continue;
			if (empty($row['link']) || $row['link'] == '' ) continue;
			$counter++;
			
			if ($counter >= $last_item) return $result;
			if ( ($first_item <= $counter) && ($counter < $last_item) ){
				$row['priority'] = (!empty($row['priority'])) ? $row['priority'] : 0.5 ;
				$row['changefreq'] = (!empty($row['changefreq'])) ? $row['changefreq'] : 'monthly' ;
				$row['lastmod'] = (!empty($row['lastmod'])) ? $row['lastmod'] : date('Y-m-d\TH:i:s+00:00');
				
				$result .= "\n<url>\n";
				$result .= "  <loc>".$row['link']."</loc>\n";
				$result .= "  <priority>".$row['priority']."</priority>\n";
				$result .= "  <lastmod>".$row['lastmod']."</lastmod>\n";
				$result .= "  <changefreq>".$row['changefreq']."</changefreq>\n";
				$result .= "</url>";
			
				if (isset($this->sitemap[$area][$code])){
					$result .= $this->out_xml_map_area($area, $page, $counter, $code);
				}
				
			}	// if ( ($first_item <= $counter) && ($counter < $last_item) ){
		} // foreach($this->sitemap[$area][$root] as $code => $row){
		return $result;
	}
	
	/**
	* Renders XML Sitemap Index
	* @param void
	*/
	// TODO поддержка тега <lastmod>
	function out_xml_index(){
		global $cfg;
		if ($this->xml_links_count == 0) $this->get_xml_txt_data();
		if ($this->xml_links_count == 0) return false;
		
		$totalparts = ceil($this->xml_links_count / $this->max_xml_urls);
		if ($totalparts == 0) $totalparts = 1;
		
		$sitemap = '<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		 
		 for($i = 1; $i<=$totalparts; $i++){
			 $part = ($i > 1) ? '&pt='.$i : '';
			 $sitemap .= "\n<sitemap>
\n";
			 $sitemap .= "  <loc>".$cfg['mainurl'].'/'.cot_url('plug', 'r=an_sitemap&out=xml'.$part)."</loc>\n";
			 $sitemap .= "</sitemap>";
		 }
		 
		 $sitemap .= "\n</sitemapindex>";
		
		return $sitemap;
		
	}
	
	/*
	* Собираем и кешируем данные для xml и txt карты
	* @param void
	*/
	function get_xml_txt_data(){
		$this->sitemap = array();
		$this->xml_links_count = 0;
		
		$cahe_loaded = false;
		if ($this->enable_cache && !empty($this->cache_path)){
			$cahe_loaded = $this->load_from_cache('xml');
			//Загрузить количество ссылок
			if (file_exists($this->cache_path.DS.'xml.links_count.cache')){
				$this->xml_links_count = implode('', file($this->cache_path.DS.'xml.links_count.cache') ) ;
			}
		}
		if (!$cahe_loaded || empty($this->sitemap)){
			// Собираем страницы все, что можно :)
			if ($this->add_pages == 'xml_txt' || $this->add_pages == 'both'){
				$this->get_pages_tree(true, 'xml_txt');
			}
						
			// Собираем дополнительные ссылки
			$this->get_additional_urls('xml_txt');
			
			// Собираем категории
			if ($this->add_lists == 'xml_txt' || $this->add_lists == 'both'){
				$add_empty_cats = ($this->add_empty_lists == "xml_txt" || $this->add_empty_lists == "both") ?  true : false;
				$this->get_category_tree($this->show_num, $add_empty_cats, true, 'xml_txt');
			}
			
			// Собираем  интеграторы
			$this->get_integrators($this->show_num, true, 'xml_txt');
	
			// Собираем  форумы
			if ($this->add_forums == 'xml_txt' || $this->add_forums == 'both'){
				$this->get_forums_tree(0, true, 'xml_txt');
				$this->get_forum_topics_tree(true);
			}
			
			// Собираем  раздел пользователей
			if ( ($this->add_users == 'xml_txt' || $this->add_users == 'both') && cot_auth('users', 'a', 'R')){
				$this->get_users_tree(true);
			}
			
			// Собираем  профилей пользователей
			if ( ($this->add_user_profs == 'xml_txt' || $this->add_user_profs == 'both') && cot_auth('users', 'a', 'R')){
				$this->get_user_profs_tree(true);
			}
			if ($this->enable_cache && !empty($this->cache_path)){
				$this->write_to_cache('xml');
			}
			foreach($this->sitemap as $key => $area){
				$this->xml_links_count += $this->sitemap[$key]['_count_'];
			}
			// Cохраним количество ссылок
			$file_name = $this->cache_path.DS.'xml.links_count.cache';
			$file = @fopen($file_name, 'w');
			if ($file){
				fwrite($file, ($this->xml_links_count));
				fclose($file);
			}
		} // if (!$cahe_loaded
		
		return true;
	}
	// ========== END: XML sitemap =============
	
	// ==========  TXT sitemap =============
	
	/**
	* Renders TXT Sitemap
	* @param void
	*/
	function out_txt_map(){
		$page = cot_import('pt','G','INT');
		if (empty($page)) $page = 1;
		
		$this->get_xml_txt_data();
		
		// Выводим элементы заполненой карты сайта
		$counter = 0;
		foreach($this->sitemap as $area => $entries){
			if (!is_array($entries)) continue;
			$sitemap .= $this->out_txt_map_area($area, $page, $counter);
		}
		
		return $sitemap;
	}
	
	/*
	* Вспомогательная функция.
	* Рекурсивно проходим дерево карты сайта
	* и добавляем элементы в TXT карту
	* @param string $area - site map area
	* @param int $page - текущая часть TXT-карты
	* @param int $counter - URL counter
	* @param string $roor - Корневой элемент
	*/
	function out_txt_map_area($area, $page, &$counter, $root = ''){
		$root = ($root == '') ? "ROOT" : $root ;
		if (!is_array($this->sitemap[$area][$root])) return false;
		
		$first_item = ($page-1) * $this->max_txt_urls + 1;
		if ($first_item > $this->xml_links_count ){
			$first_item = 1;
			$page = 1;
		}
		$last_item = $first_item + $this->max_txt_urls;
		
		$result = '';
		foreach($this->sitemap[$area][$root] as $code => $row){
			if (!is_array($row)) continue;
			if (empty($row["link"]) || $row["link"] == '' ) continue;
			$counter++;
			
			if ($counter >= $last_item) return $result;
			if ( ($first_item <= $counter) && ($counter < $last_item) ){
				$result .= str_replace('&amp;', '&', $row['link'])."\n";
				if (isset($this->sitemap[$area][$code])){
					$result .= $this->out_txt_map_area($area, $page, $counter, $code);
				}
			}
		} // foreach($this->sitemap[$area][$root] as $code => $row){
		return $result;
	}
	// ========== END: TXT sitemap =============
	
}  //class an_sitemap {
?>