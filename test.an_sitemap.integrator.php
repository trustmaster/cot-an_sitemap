<?php
/* ====================
AN Sitemap test integrator
==================== */
// *********************************************
// *    Plugin AN Site Map                     *
// *       Test integrator                     *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
defined('COT_CODE') or die('Wrong URL.');

// Параметр указывает на необходимость включить количество элементов
function test_sitemap($show_num = 0){
	global $L, $cfg;
	
	// Подключить языковой файл, если необходимо
	// require_once(cot_langfile('ваш_плагин'));
	
	$out = array();
	
	$out['test']['_name_'] = $L['plu']['test_name'];			  	// Название интегратора.
	$out['test']['_desc_'] = 'test Site Map Integrator for some plugin';  // Описание интегратора для панели администратора
	$out['test']['_count_'] = 1;			// Общее количество элементов	(ссылок)
	
	// Массив элементов в корне
	$out['test']['ROOT']['1']['title'] = $L['plu']['test_title1'];
	$out['test']['ROOT']['1']['link'] =  "http://portal30.Ru";		// Внешняя ссылка (роботы внешние ссылки в XML-карте считают ошибкой)
	if ($show_num == 1) $out['test']['ROOT']['1']['count'] = "1";	// Включаем количество элементов, если нужно
	$out['test']['ROOT']['1']['target'] = "_blank";					// Открыть в новом окне
	$out['test']['ROOT']['1']['priority'] = 0.5 ;					// Приоретет страницы для XML-карты (необязательно)
	$out['test']['ROOT']['1']['changefreq'] = 'monthly' ;			// Частота изменения страницы для XML-карты (необязательно)
	$out['test']['ROOT']['1']['lastmod'] = date('Y-m-d\TH:i:s+00:00');// Дата последней модификации страницы для XML-карты (необязательно)
	
	$out['test']['ROOT']['2']['title'] = $L['plu']['test_title2'];
	$out['test']['ROOT']['2']['link'] =  $cfg['mainurl'].'/'.cot_url('users');   // Внутренние ссылки должны содежать полный URL
	if ($show_num == 1) $out['test']['ROOT']['2']['count'] = "30";
	//...
	/*
	$out['test']['ROOT'][code]['title'] = "...";
	$out['test']['ROOT'][code]['link'] =  "1111";
	$out['test']['ROOT'][code]['count'] = "2222";
	*/
	// Массив элементов, вложенных в первый раздел
	$out['test']['1']['q']['title'] = $L['plu']['test_title3'];
	$out['test']['1']['q']['link'] =  $cfg['mainurl'].'/'.cot_url('plug', 'e=tags');
	if ($show_num == 1) $out['test']['1']['q']['count'] = "30";
	//...
	/*
	$out['test'][1][code]['title'] = "...";
	$out['test'][1][code]['link'] =  "1111";
	$out['test'][1][code]['count'] = "2222";
	*/
	
	// А так можно встроиться, например в категории страниц
	// Встроились в корень
	$out['lists']['ROOT']['code']['title'] = $L['plu']['test_title5'];
	$out['lists']['ROOT']['code']['link'] =  $cfg['mainurl'].'/'.cot_url('plug', 'e=tags');
	if ($show_num == 1) $out['lists']['ROOT']['code']['count'] = "1";
	
	// А теперь в новости (второй параматр - код категории)
	$out['lists']['news']['code']['title'] = $L['plu']['test_title4'];
	$out['lists']['news']['code']['link'] =  $cfg['mainurl'].'/'.cot_url('plug', 'e=tags');
	//$out['lists']['4']['code']['count'] = "2222";  				// Не стали указывать количество вообще
	
	return ($out);
}

?>