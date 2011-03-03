<!-- BEGIN: MAIN -->
<div class="mboxHD">
	<a href="{PHP.cfg.mainurl}" title="{PHP.skinlang.header.Home}">
    	<img src="skins/{PHP.skin}/img/system/icon-home.gif" alt="{PHP.cfg.maintitle}" align="absmiddle" width="16" height="16" />
	</a>&nbsp;{PHP.cfg.separator}
	{PLUGIN_TITLE}
</div>
<h1>{PLUGIN_TITLE}</h1>
{PLUGIN_SUBTITLE}

	<!-- BEGIN: LIST -->

	<!-- BEGIN: CATEGORIES -->
		<!-- IF {AREA_NAME} -->
		<h2>{AREA_NAME}</h2>
		<!-- ENDIF -->
	
		<!-- BEGIN: CATEGORIES_ROW -->
			<div class="an_sitemap_level_{ROW_LEVEL}">
				<a href="{ROW_LINK}" target="{ROW_TARGET}" title="{ROW_DESC}">{ROW_TITLE}
					<!-- IF {ROW_ITEM_COUNT} != '' -->
					&nbsp;({ROW_ITEM_COUNT})
					<!-- ENDIF -->
				</a> 
				<!-- BEGIN: ELEMENT -->
				&nbsp; &nbsp; <span class="desc" style="cursor:pointer"  onclick="$('#an_sitemap_element_{ROW_ITEM_NUMBER}').slideToggle();"><em>{PHP.L.an_sitemap.show_list}</em></span>
				<div id="an_sitemap_element_{ROW_ITEM_NUMBER}" class="an_sitemap_level_{ELEMENT_ROW_LEVEL}" style="margin-top:3px;margin-bottom:5px; display:none">
					<!-- BEGIN: ELEMENT_ROW -->
					<a href="{ELEMENT_ROW_LINK}" target="{ELEMENT_ROW_TARGET}" title="{ELEMENT_ROW_DESC}">{ELEMENT_ROW_TITLE}</a><br />
					<!-- END: ELEMENT_ROW -->
					
				</div>
				<!-- END: ELEMENT -->
			</div>
		<!-- END: CATEGORIES_ROW -->
	
	<!-- END: CATEGORIES -->

	<!-- END: LIST -->

<!-- IF {PLUGIN_PAGENAV} -->
	<p>&nbsp;</p>
	<div class="paging">{PLUGIN_PAGENAV}</div>
<!-- ENDIF -->

<!-- END: MAIN -->
