// *********************************************
// *    Plugin:  "AN Site Map"                 *
// *      Java Script                          *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *          (c) Alex & Natty Studio  2010    *
// *********************************************

//Языковые переменные. Значения будут выставлены в файле шаблона 
var add_url_show = '';
var add_url_hide = '';
var add_url_addnewentry = '';
var add_url_conf_del_checked = '';
var add_url_no_url_marked = '';

/*
* Отметить все чекбоксы (checkbox) в группе.
* Все чекбоксы имеют имя типа cbName[]
* @param object oForm - форма
* @param string cbName - имя группы чекбоксов
* @param boolean checked
*/
function add_url_checkAll(oForm, cbName, checked){
	if (!oForm[cbName+"[]"].length){
		oForm[cbName+"[]"].checked = checked;
	}else{
		for (var i=0; i < oForm[cbName+"[]"].length; i++) oForm[cbName+"[]"][i].checked = checked;
	}
}

$(function() {
		   
	// Показать скрыть форму добавления URL
	$("#add_new_url_header").click(function(){
		var state = $('#add_new_url').css( 'display' );
		$("#add_new_url").slideToggle();
		if (state == 'none'){
			$("#add_new_url_header").html(add_url_addnewentry + ":");
			$("#add_new_url_header").attr( "title", add_url_hide );
			add_new_url = 1;
		}else{
			$("#add_new_url_header").html(add_url_addnewentry + "...");
			$("#add_new_url_header").attr( "title", add_url_show );
			add_new_url = 0;
		}
		return false;
	});
	
	// Ссылка - выделенные удалить
	$("#act_w_selected_urls").click(function(){
		// проверяем, есть хоть один выделенный URL
		var tmp = false;
		if (!document.additional_urls["edit_url_check[]"].length){
			if (document.additional_urls["edit_url_check[]"].checked) tmp = true;
		}else{
			for (var i=0; i < document.additional_urls["edit_url_check[]"].length; i++){
				if (document.additional_urls["edit_url_check[]"][i].checked) tmp = true;
			}
		}
		if (!tmp){
			alert(add_url_no_url_marked);
			return false;
		}
		
		if (confirm(add_url_conf_del_checked)){
			document.additional_urls.action = $("#act_w_selected_urls").attr( "href" );
			document.additional_urls.submit();
		}
		return false;
	});
	
});