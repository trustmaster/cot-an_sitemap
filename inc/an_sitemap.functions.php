<?php
// *********************************************
// *    Plugin AN Site Map                     *
// *        Functions                          *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
if (!defined('COT_CODE')) { die('Wrong URL.'); }

// По пути к папке на сервере, вернет ее URL
if (!function_exists(getRelativeURL)){
	function getRelativeURL($path){
		$npath = str_replace('\\', '/', $path);
		$ret = str_replace($_SERVER['DOCUMENT_ROOT'], '', $npath);
        if ($ret[0] != '/') $ret = '/'.$ret;
		return $ret;
	}
}

/**
 * Renders a dropdown
 *
 * @param string $check Seleced value
 * @param string $name Dropdown name
 * @param array $values Options available
 * @param array $texts text for Options to display
 * @param boolean $inc_empty включить пустую опцию в список
 * @param string $param дополнительные параметры для тега  <select>
 * @return string
 */
function an_selectbox($check, $name, $values, $texts = '', $inc_empty=false, $param = ''){
	$check = trim($check);
	
	if ($texts == '') $texts = $values;
	$result .=  "<select name=\"$name\" id=\"$name\" $param size=\"1\">";
	if($inc_empty){
		$selected = (empty($check) || $check=="00") ? "selected=\"selected\"" : '';
		$result .=  "<option value=\"\" $selected>---</option>";
	}
	foreach ($values as $k => $x){
		$x = trim($x);
		$selected = ($x == $check) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$x\" $selected>".htmlspecialchars($texts[$k])."</option>";
	}
	$result .= "</select>";
	return($result);
}

if(!function_exists("an_pagnav")) {
	/*
	* Паджинация версия функции 1.0.1
	* @param int $current - номер текущей страницы
	* @param int $totalitems - всего элементов
	* @param int $perpage - элементов на страницу
	* @param string $modname - обязательный, имя файла модуля для первого параметра ф-ции cot_url (например: "plug")
	* @param string $cot_url_params - второй параметр для ф-ции cot_url (например: "e=games&cat=1")
	* @param boolean $per_page_sel - выводить возможность выбора количества элементов нв странице
	* $characters - параметр передающий номер страницы, будет добавлен к $cot_url_params
	*/
	function an_pagnav($current, $totalitems, $perpage = 10, $modname = '', $cot_url_params = '',  $characters = 'd', $per_page_sel = false){
		global $L, $cfg;
		$each_side = 3;		// Links each side
		if ( ($totalitems <= $perpage) && !$per_page_sel) return;
		if ($modname == '') return;
		if ($current > 1){
			$prev = $current - 1;
			if ($prev < 1) { $prev = 1; }
			$prev = "<span class=\"pagenav_prev\"><a href=\"".cot_url($modname, $cot_url_params."&".$characters.'='.$prev)."\" title=\"".$L['plu_pagnav_prev_desc']."\">".$L['plu_pagnav_prev']."</a></span>";
		}else{
			$prev = '';
		}
		$totalpages = ceil($totalitems / $perpage);
		if (($current) < $totalpages){
			$next = $current + 1;
			$next = "<span class=\"pagenav_next\"><a href=\"".cot_url($modname, $cot_url_params."&".$characters.'='.$next)."\" title=\"".$L['plu_pagnav_next_desc']."\">".$L['plu_pagnav_next']."</a></span>";
		}

		$currentpage = $current;
		if(($each_side * 2) >= $totalpages) {
			for ($k = 1; $k <= $totalpages; $k++){
				//$l = $k * $perpage;
				if ($k==$currentpage){
					$pages .= "<span class=\"pagenav_current\">".($k)."</span>"; 
				}else{
					$pages .= "<span class=\"pagenav_pages\"><a href=\"".cot_url($modname, $cot_url_params."&".$characters.'='.$k)."\">".($k)."</a></span>"; 
				}
			}
		}else{
			if ($currentpage > $each_side){
				$first = "<span class=\"pagenav_first\"><a href=\"".cot_url($modname, $cot_url_params."&".$characters.'=1')."\" title=\"".$L['plu_pagnav_first_desc']."\">".$L['plu_pagnav_first']."</a></span>";
			}
		 	if ($currentpage < $totalpages-$each_side){	
				$last = $totalpages;
				$last = "<span class=\"pagenav_last\"><a href=\"".cot_url($modname, $cot_url_params."&".$characters.'='.$last)."\" title=\"".$L['plu_pagnav_last_desc']."\">".$L['plu_pagnav_last']."</a></span>";
			}
				
			$start = $currentpage - $each_side;
			$end = $currentpage + $each_side;
			if ($end < $each_side*2 + 1) $end = $each_side*2 + 1;
			if ($end > $totalpages) $end = $totalpages;
			if ( ($end - $start) < $each_side*2) $start = $end - $each_side*2;
			if($start < 1) $start = 1;
			
			for($k = $start; $k <= $end; $k++){
				if ($k==$currentpage){
					$pages .= "<span class=\"pagenav_current\">".($k)."</span>"; 
				}else{
					$pages .= "<span class=\"pagenav_pages\"><a href=\"".cot_url($modname, $cot_url_params."&".$characters.'='.$k)."\">".($k)."</a></span>"; 
				}
			}
		}
		if ($per_page_sel){
			$values = array(5, 10 , 15, 20, 25, 30, 40, 50, 60, 70, 80, 90, 100, 'all');
			$texts = array(5, 10 , 15, 20, 25, 30, 40, 50, 60, 70, 80, 90, 100, $L['plu_pagnav_per_page_all']);
			$per_page_url = $cfg['mainurl']."/".cot_url($modname, $cot_url_params."&".$characters.'=1');
			$per_page_param = "onchange='window.location=\"".$per_page_url."&perpage=\" + this.options[this.selectedIndex].value; return false;'";
			$sel = ($perpage > 100) ? 'all' : $perpage;
		}
		$pagnav = "<span class=\"pagenav_pages\">".sprintf($L['plu_page_of'], $currentpage, $totalpages)."</span>";
		if ($per_page_sel){
			$pagnav .=  "<span class=\"pagenav_pages\">".$L['plu_pagnav_per_page'].":</span>".an_selectbox($sel, "perpage", $values, $texts, false, $per_page_param );
		}
		$pagnav .= $first;
		$pagnav .= $prev;
		if ($totalpages > 1){
			$pagnav .= $pages;
			$pagnav .= $next;
			$pagnav .= $last;
		}
		return($pagnav);
	}
}
/* "Extend" recursively array $a with array $b values
 * (no deletion in $a, just added and updated values)
 */
function array_extend($a, $b) {
    foreach($b as $k=>$v) {
        if( is_array($v) ) {
            if( !isset($a[$k]) ) {
                $a[$k] = $v;
            } else {
                $a[$k] = array_extend($a[$k], $v);
            }
        } else {
            $a[$k] = $v;
        }
    }
    return $a;
}

?>