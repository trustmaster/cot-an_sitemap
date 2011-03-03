<?PHP
// *********************************************
// *    Plugin AN Site Map                     *
// *      Russian Lang File                    *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
if (!defined('COT_CODE')) { die('Wrong URL.'); }

/**
 * Plugin Title & Subtitle
 */

$L['an_sitemap']['plu_title'] = $L['plu_title']	= 'Карта сайта';
$L['an_sitemap']['plu_subtitle']		= 'Основные разделы нашего сайта';
$L['an_sitemap']['plu_meta_keywords'] = "карта, сайт, карта сайта";

/**
 * Plugin Body
 */
$L['an_sitemap']['lists'] = 'Разделы сайта';
$L['an_sitemap']['forums'] = 'Форумы';
$L['an_sitemap']['users'] = 'Пользователи';
$L['an_sitemap']['user_list'] = 'Список пользователей';
$L['an_sitemap']['show_list'] = 'Развернутый список';

/**
 * User Part Errors and messages
 */
$L['an_sitemap']['err_unknown_state'] = "Неизвестный статус вывода ссылок карты сайта";
//$L['an_sitemap']['msg_save_config'] = "Конфигурация сохранена";

// ==== Паджинация ====
$L['plu_pagnav_prev'] = " &lt; ";
$L['plu_pagnav_next'] = " &gt; ";
$L['plu_pagnav_prev_desc'] = "Предыдущая страница";
$L['plu_pagnav_next_desc'] = "Следующая страница";
$L['plu_pagnav_first'] = "Первая";
$L['plu_pagnav_last'] = "Последняя";
$L['plu_pagnav_first_desc'] = "Первая страница";
$L['plu_pagnav_last_desc'] = "Последняя страница";
$L['plu_page_of'] = "Страница %1\$s из %2\$s";
$L['plu_pagnav_per_page'] = "На странице";
$L['plu_pagnav_per_page_all'] = "Все";

// ==== Конец: Паджинация ====

// ==== Тестовый интегратор ====
$L['plu']['test_name'] = "Тестовый интегратор";
$L['plu']['test_title1'] = "Элемент с внешним URL (интегратор)";
$L['plu']['test_title2'] = "Тестовый элемент с внутренним URL (интегратор)";
$L['plu']['test_title3'] = "Элемент второго уровня в тестовом интеграторе";
$L['plu']['test_title4'] = "Интегратор вложенный в категорию &laquo;Новости&raquo;";
$L['plu']['test_title5'] = "Интегратор вложенный в корень Разделов сайта :)";
// ==== Конец: Тестовый интегратор ====

/**
 * Admin Part
 */
$L['an_sitemap']['config'] = "Настройки";
$L['an_sitemap']['config_main'] = "Основные настройки всех карт";
$L['an_sitemap']['config_freq'] = "Изменить настройки частоты для XML-карты";
$L['an_sitemap']['config_priority'] = "Изменить настройки приоритета";
$L['an_sitemap']['srtucture'] = "Структура";
$L['an_sitemap']['add_links'] = "Дополнительные ссылки";
$L['an_sitemap']['integrators'] = "Дополнения";
$L['an_sitemap']['google_help'] = "Описание sitemap.xml на Google";
$L['an_sitemap']['google_help_url'] = "http://www.google.com/support/webmasters/bin/topic.py?topic=8476";
$L['an_sitemap']['help'] = "Справка";
$L['an_sitemap']['sitemaps'] = "Карты сайта";
$L['an_sitemap']['HTML_link'] = "Ссылка на HTML карту";
$L['an_sitemap']['XML_link'] = "Ссылка на XML карту";
$L['an_sitemap']['TXT_link'] = "Ссылка на TXT карту";
$L['an_sitemap']['robots_file'] = "Файл robots.txt";
$L['an_sitemap']['recomended_to_add'] = "Рекомендуется добавить";
$L['an_sitemap']['recomended_to_delete'] = "Рекомендуется удалить";
/*$L['an_sitemap']['robots_desc'] = "Убедитесь, что Вы внесли необходимые изменения в файл <strong>.htaccess</strong>. <a href=\"/admin.php?m=other&p=an_sitemap&task=help\">Подробности в справке</a>.";*/
$L['an_sitemap']['max_xml_urls'] = "Максимальное число URL'ов на один XML файл карты сайта."; 
$L['an_sitemap']['max_xml_urls_desc'] = "<strong>ПРИМЕЧАНИЕ:</strong> Google разрешает не более 50 000 адресов URL на XML файл. Если ссылок будет больше указанного количества, то будет создано несколько частей карты. Каждая из этих частей будет перечислена в <strong>индексе XML-карты</strong>";
$L['an_sitemap']['max_txt_urls_desc'] = "<strong>ПРИМЕЧАНИЕ:</strong> Google разрешает не более 50 000 адресов URL на TXT файл. Если ссылок будет больше указанного количества, то будет создано несколько частей карты. Каждую из этих частей следует указать для роботов отдельно.";
$L['an_sitemap']['max_html_urls'] = "Количество ссылок на странице HTML карты сайта по-умолчанию."; 
$L['an_sitemap']['max_txt_urls'] = "Максимальное число URL'ов на один TXT файл карты сайта."; 
$L['an_sitemap']['use_cache'] = "Использовать кеш?";
$L['an_sitemap']['cache_time'] = "Время жизни кеша (в часах).";
$L['an_sitemap']['cache_time_desc'] = "Установите время жизни кеша в часах. По прошествии этого времени данные будут обновлены.";
$L['an_sitemap']['add_pages'] = "Включить страницы";
$L['an_sitemap']['add_lists'] = "Включить категории";
$L['an_sitemap']['add_empty_lists'] = "Показывать пустые категории страниц";
$L['an_sitemap']['add_forums'] = "Включить форумы";
$L['an_sitemap']['add_user_profs'] = "Включить профили пользователей";
$L['an_sitemap']['add_users'] = "Включить раздел пользователей";
$L['an_sitemap']['add_users_desc'] = "В HTML карту будет включена только ссылка на раздел пользователей";
$L['an_sitemap']['show_num'] = "Отображать количество элементов категории";
$L['an_sitemap']['show_num_desc'] = "Для HTML карты сайта. Рядом с названием категории, отобразит количество страниц. И т.д.";
$L['an_sitemap']['no'] = "Нет";
$L['an_sitemap']['to_HTML'] = "В HTML карту";
$L['an_sitemap']['to_XML_TXT'] = "В XML и TXT";
$L['an_sitemap']['to_all_maps'] = "Во все карты";
$L['an_sitemap']['freq_pages'] = "Частота обновления страниц";
$L['an_sitemap']['freq_pages_desc'] = "Вероятная частота изменения этой страницы. Это значение представляет общую информацию для поисковых роботов и может не точно указазывать, на сколько часто они обходят страницу. Это значение <strong>всегда</strong> нужно использовать описывая документы которые изменяются при каждом обращении. Это значение <strong>никогда</strong> не нужно использовать для описания архивных URL'ов.";
$L['an_sitemap']['freq_lists'] = "Частота обновления списков (Lists)";
$L['an_sitemap']['freq_sections'] = "Частота обновления разделов форума";
$L['an_sitemap']['freq_topics'] = "Частота обновления тем на форуме";
$L['an_sitemap']['freq_user_lists'] = "Частота обновления списка зарегестрированных пользователей";
$L['an_sitemap']['freq_user_profiles'] = "Частота обновления профилей пользователей";
$L['an_sitemap']['never'] = "Никогда";
$L['an_sitemap']['yearly'] = "Ежегодно";
$L['an_sitemap']['monthly'] = "Ежемесячно";
$L['an_sitemap']['weekly'] = "Еженедельно";
$L['an_sitemap']['daily'] = "Ежедневно";
$L['an_sitemap']['hourly'] = "Ежечасно";
$L['an_sitemap']['always'] = "Постоянно";
$L['an_sitemap']['priority_pages'] = "Приоритет страниц";
$L['an_sitemap']['priority_pages_desc'] = "Приоритет этого URL относительно других URL'ов на Вашем сайте. Допустимый диапазон значений — от 0,0 до 1,0. Это значение никак не скажется на страницах Вашего сайта относительно других страниц, оно только позволяет поисковому роботу узнать, какие из Ваших страниц Вы считаете наиболее важными и позволяет позволяет организовать обход страниц в удобном для Вас порядке.<br /><br />
По умолчанию значение для каждой страницы 0.5.";
$L['an_sitemap']['priority_lists'] = "Приоритет cписков страниц (Lists)";
$L['an_sitemap']['priority_sections'] = "Приоритет разделов форума";
$L['an_sitemap']['priority_topics'] = "Приоритет тем на форуме";
$L['an_sitemap']['priority_user_lists'] = "Приоритет списка зарегистрированных пользователей";
$L['an_sitemap']['priority_user_profiles'] = "Приоритет Профилей зарегистрированных пользователей";
$L['an_sitemap']['file'] = "Файл";
$L['an_sitemap']['writeable'] = "Доступен для записи";
$L['an_sitemap']['not_writeable'] = "Недоступен для записи";
$L['an_sitemap']['plugin_ver'] = "Версия плагина";
$L['an_sitemap']['check_new_ver'] = "Проверить новую версию";
$L['an_sitemap']['code'] = "Код";
$L['an_sitemap']['name'] = "Название";
$L['an_sitemap']['state'] = "Статус";
$L['an_sitemap']['link'] = "Ссылка";
$L['an_sitemap']['total_elements'] = "Всего элементов";
$L['an_sitemap']['per_page_elements'] = "Показать на странице";
$L['an_sitemap']['count_elements'] = "Элементов";
$L['an_sitemap']['config_default'] = "Восстановить все по умолчанию";
$L['an_sitemap']['config_default_confirm'] = "Восстановить всю конфигурацию по-умолчанию? Текущие настройки будут потеряны";
$L['an_sitemap']['description'] = "Описание";
$L['an_sitemap']['page_last_mod_field'] = "Поле с датой изменеия страницы";
$L['an_sitemap']['page_last_mod_field_desc'] = "Поле, содержащее дату модификации страницы в формате метки UNIX. Информация используется для формирования XML-карты сайта. По-умолчанию <strong>&laquo;page_date&raquo;</strong>. Но рекомендуется использовать дополнительное поле, в которое будет производиться запись временной метки автоматически при каждом сохранении страницы. Если включено авто заполнение этого поля, оно будет автоматически заполняться средствами этого плагина при каждом изменении страницы.";
$L['an_sitemap']['page_last_mod_field_auto'] = "Авто заполнения этого поля";
$L['an_sitemap']['order_by_href'] = 'Нажмите для сортировки по этому столбцу';
$L['an_sitemap']['order'] = 'Порядок';
$L['an_sitemap']['priority'] = "Приоритет";
$L['an_sitemap']['last_mod_date'] = "Дата изменения";
$L['an_sitemap']['add_urls_desc'] = "* <strong>Описание</strong> используется только для формирования HTML карты сайта и никак не влияет на постороение XML или TXT карты. <strong>Не более 255 символов.</strong>";
$L['an_sitemap']['change_freq'] = "Частота обновления";
$L['an_sitemap']['change_freq_short'] = "Частота обн.";
$L['an_sitemap']['last_mod_desc'] = 'Дата последнего изменения. Эта дата должна быть в формате <a href="http://www.w3.org/TR/NOTE-datetime" target="_blank">W3C Datetime.</a> Этот формат позволяет при необходимости опустить сегмент времени и использовать формат ГГГГ-ММ-ДД.';
$L['an_sitemap']['not_required'] = 'Необязательно';
$L['an_sitemap']['add_url_show'] = 'Показать форму добавления нового URL';
$L['an_sitemap']['add_url_hide'] = 'Скрыть форму добавления нового URL';
$L['an_sitemap']['link_desc'] = 'URL-адрес страницы. Этот URL-адрес должен начинаться с префикса (например, HTTP) и заканчиваться косой чертой, если Ваш веб-сервер требует этого. Длина этого значения не должна превышать 2048 символов.';
$L['an_sitemap']['name_desc'] = 'Название страницы. Выводится в HTML-карте сайта. Никак не влияет на XML и TXT карты.';
$L['an_sitemap']['del_url'] = 'Удалить URL';
$L['an_sitemap']['select_all'] = 'Выделить все';
$L['an_sitemap']['url_del_confirm'] = "Удалить ссылку: «{link_name}»? Данное действие нельзя отменить.";
$L['an_sitemap']['marked'] = "Отмеченные";
$L['an_sitemap']['marked_del_confirm'] = "Удалить все отмеченные ссылки? Данное действие нельзя отменить.";
$L['an_sitemap']['no_url_marked'] = "Не выделено ни одной ссылки.";
$L['an_sitemap']['XML_index'] = "Индекс XML-карты.";


/**
 * Admin Part Errors and messages
 */
$L['an_sitemap']['err_unknown_task'] = "Неизвестная задача";
$L['an_sitemap']['err_write_robots'] = "Ошибка записи в robots.txt. Внесите в него изменения вручную. См. примечание ниже.";
$L['an_sitemap']['err_config_not_writable'] = "Ошибка сохранения конфигурации. Файл недоступен для записи";
$L['an_sitemap']['msg_save_config'] = "Конфигурация сохранена";
$L['an_sitemap']['msg_save_struct'] = "Структура сохранена";
$L['an_sitemap']['msg_save_url'] = "URL добавлен";
$L['an_sitemap']['err_read_def_config'] = "Конфигурация по-умолчанию не восстановлена.<br />Ошибка чтения файла ".$cfg["plugins_dir"]."/an_sitemap/inc/config_def.php";
$L['an_sitemap']['err_write_def_config'] = "Конфигурация по-умолчанию не восстановлена.<br />Ошибка записи в файл ".$cfg["plugins_dir"]."/an_sitemap/inc/config.php";
$L['an_sitemap']['msg_def_config_restored'] = "Конфигурация по-умолчанию восстановлена";
$L['an_sitemap']['err_no_url'] = "Вы должны указать ссылку";
$L['an_sitemap']['err_no_name'] = "Вы должны указать название";
$L['an_sitemap']['err_bad_priority'] = "Неверное значение приоретета";
$L['an_sitemap']['err_edit_url_id'] = "Ошибка сохранения URL с ID:";
$L['an_sitemap']['err_operation'] = "Ошибка выполнения операции";
$L['an_sitemap']['msg_url_deleted'] = "URL id <strong>{urlid}</strong> удален";
$L['an_sitemap']['err_url_not_deleted'] = "URL id <strong>{urlid}</strong> НЕ удален. Ошибка удаления или он отсутствует в БД.";

/**
 * Plugin Config
 */

//$L['cfg_showcats'] = array('Показывать категории страниц');

?>