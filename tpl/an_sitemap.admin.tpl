<!-- BEGIN: MAIN -->
	
	<h1>{SECTION}</h1>
	
	<!-- BEGIN: ERROR -->
	<div class="error">{ERROR_BODY}</div>
	<!-- END: ERROR -->
	
	<!-- BEGIN: MESSAGE -->
	<div class="message">{MESSAGE_BODY}</div>
	<!-- END: MESSAGE -->

	<!-- BEGIN: MENU -->
	<div class="block">
	  <a href="{CONFIG_URL}"><img src="{PHP.plugin_base_url}/tpl/img/config.gif" align="absmiddle" border="0" /></a>
	  <a href="{CONFIG_URL}">{PHP.L.an_sitemap.config}</a> &nbsp;&nbsp;
	  <a href="{STRUCTURE_URL}"><img src="{PHP.plugin_base_url}/tpl/img/structure.gif" align="absmiddle"  border="0" /> </a> 
	  <a href="{STRUCTURE_URL}">{PHP.L.an_sitemap.srtucture}</a> &nbsp;&nbsp;
          <a href="{ADD_LINKS_URL}"><img src="{PHP.plugin_base_url}/tpl/img/url.gif" align="absmiddle"  border="0" /> </a>
	  <a href="{ADD_LINKS_URL}">{PHP.L.an_sitemap.add_links}</a> &nbsp;&nbsp;
	  <a href="{INTEGRATORS_URL}"><img src="{PHP.plugin_base_url}/tpl/img/addons.gif" align="absmiddle"  border="0" /> </a> 
	  <a href="{INTEGRATORS_URL}">{PHP.L.an_sitemap.integrators}</a> &nbsp;&nbsp;
	  <a href="{PHP.L.an_sitemap.google_help_url}" target="_blank"><img src="{PHP.plugin_base_url}/tpl/img/book.gif" align="absmiddle" border="0" /></a> 
	  <a href="{PHP.L.an_sitemap.google_help_url}" target="_blank">{PHP.L.an_sitemap.google_help}</a> &nbsp;&nbsp;
	  <a href="{HELP_URL}"><img src="{PHP.plugin_base_url}/tpl/img/help.gif" align="absmiddle" border="0" /></a> 
	  <a href="{HELP_URL}">{PHP.L.an_sitemap.help}</a>
	</div>
	<!-- END: MENU -->

		<!-- BEGIN: CONFIG -->
			<!-- BEGIN: ROBOTS -->
			<fieldset>
				<legend style="font-weight:bold">{PHP.L.an_sitemap.robots_file}</legend>
				<table class="cells">
					<!-- IF {ADD_TO_ROBOTS} -->
					<tr>
						<td width="20%">{PHP.L.an_sitemap.recomended_to_add} : </td>
						<td>{ADD_TO_ROBOTS}</td>
					</tr>
					<!-- ENDIF -->
					<!-- IF {DELETE_FROM_ROBOTS} -->
					<tr>
						<td width="20%">{PHP.L.an_sitemap.recomended_to_delete} : </td>
						<td>{DELETE_FROM_ROBOTS}</td>
					</tr>
					<!-- ENDIF -->
				</table>
			</fieldset>
			<p>&nbsp;</p>
			<!-- END: ROBOTS -->
		
		<fieldset>
			<legend style="font-weight:bold">{PHP.L.an_sitemap.sitemaps}</legend>
			<table class="cells">
				<tr>
					<td width="20%">
						{PHP.L.an_sitemap.HTML_link} : 
					</td>
					<td><a href="{CONFIG_HTML_LINK}" target="_blank">{CONFIG_HTML_LINK}</a></td>
				</tr>
				<tr>
					<td>{PHP.L.an_sitemap.XML_index}</td>
					<td><a href="{CONFIG_XML_INDEX_LINK}" target="_blank">{CONFIG_XML_INDEX_LINK}</a></td>
				</tr>
				
				<!-- BEGIN: XML_LINKS_ROW -->
				<tr>
					<td>{PHP.L.an_sitemap.XML_link}
						<!-- IF {CONFIG_XML_LINK_NUM} > 1 --># {CONFIG_XML_LINK_NUM}<!-- ENDIF --> : 
					</td>
					<td><a href="{CONFIG_XML_LINK}" target="_blank">{CONFIG_XML_LINK}</a></td>
				</tr>
				<!-- END: XML_LINKS_ROW -->
				
				<!-- BEGIN: TXT_LINKS_ROW -->
				<tr>
					<td>{PHP.L.an_sitemap.TXT_link}
						<!-- IF {CONFIG_TXT_LINK_NUM} > 1 --># {CONFIG_TXT_LINK_NUM}<!-- ENDIF --> : 
					</td>
					<td><a href="{CONFIG_TXT_LINK}" target="_blank">{CONFIG_TXT_LINK}</a></td>
				</tr>
				<!-- END: TXT_LINKS_ROW -->
				
				<!-- IF {ROBOTS_OK} == 'OK' -->
				<tr>
					<td>{PHP.L.an_sitemap.robots_file} : </td>
					<td><span style="color:green;">OK!</span></td>
				</tr>
				<!-- ENDIF -->
			</table>
		</fieldset>
		<p>&nbsp;</p>
		<!-- IF {CONFIG_FILE_WRITEABLE} == 1 -->
		<p style="text-align:center">{PHP.L.an_sitemap.file} : {CONFIG_FILE} - <span style="color:green; font-weight:bold">{PHP.L.an_sitemap.writeable}</span></p>
		<!-- ENDIF -->
		<!-- IF {CONFIG_FILE_WRITEABLE} == 0 -->
		<p style="text-align:center">{PHP.L.an_sitemap.file} : {CONFIG_FILE} - <span style="color:red; font-weight:bold">{PHP.L.an_sitemap.not_writeable}</span></p>
		<!-- ENDIF -->
		
		<form name="saveconfig" id="saveconfig" action="{CONFIG_FORM_URL}" method="post">
		<table class="cells">
			<tr>
				<td class="coltop" colspan="2">{PHP.L.an_sitemap.config_main}</td>
				<td class="coltop">{PHP.L.Reset}</td>
			</tr>
			<tr>
				<td style="width:25%;">{PHP.L.an_sitemap.max_xml_urls} : </td>
				<td style="width:68%;">
					<input type="text" maxlength="255" size="50" value="{CONFIG_MAX_XML_URLS}" name="config_max_xml_urls" id="config_max_xml_urls"><br /><span class="desc">{PHP.L.an_sitemap.max_xml_urls_desc}</span>
				</td>
				<td align="center"><a href="#" onclick="document.forms.saveconfig.config_max_xml_urls.value={CONFIG_MAX_XML_URLS_DEF}; return false;" >[R]</a></td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.max_html_urls} : </td>
				<td>
					<input type="text" maxlength="255" size="50" value="{CONFIG_MAX_HTML_URLS}" name="config_max_html_urls" id="config_max_html_urls">
				</td>
				<td align="center"><a href="#" onclick="document.forms.saveconfig.config_max_html_urls.value={CONFIG_MAX_HTML_URLS_DEF}; return false;" >[R]</a></td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.max_txt_urls} : </td>
				<td>
					<input type="text" maxlength="255" size="50" value="{CONFIG_MAX_TXT_URLS}" name="config_max_txt_urls" id="config_max_txt_urls"><br /><span class="desc">{PHP.L.an_sitemap.max_txt_urls_desc}</span>
				</td>
				<td align="center"><a href="#" onclick="document.forms.saveconfig.config_max_txt_urls.value={CONFIG_MAX_TXT_URLS_DEF}; return false;" >[R]</a></td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.use_cache} : </td>
				<td>{CONFIG_ENABLE_CACHE}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.cache_time} : </td>
				<td>
					<input type="text" maxlength="255" size="50" value="{CONFIG_CACHE_TIME}" name="config_cache_time" id="config_cache_time"><br />{PHP.L.an_sitemap.cache_time_desc}
				</td>
				<td align="center"><a href="#" onclick="document.forms.saveconfig.config_cache_time.value={CONFIG_CACHE_TIME_DEF}; return false;" >[R]</a></td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.add_pages} : </td>
				<td>{CONFIG_ADD_PAGES}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.add_lists} : </td>
				<td>{CONFIG_ADD_LISTS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.add_empty_lists} : </td>
				<td>{CONFIG_ADD_EMPTY_LISTS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.page_last_mod_field} : </td>
				<td>{CONFIG_PAGE_LAST_MOD_FIELD} &nbsp; {PHP.L.an_sitemap.page_last_mod_field_auto} {CONFIG_PAGE_LAST_MOD_FIELD_AUTO} <br />
				<span class="desc">{PHP.L.an_sitemap.page_last_mod_field_desc}</span></td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.add_forums} : </td>
				<td>{CONFIG_ADD_FORUMS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.add_user_profs} : </td>
				<td>{CONFIG_ADD_USER_PROFS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.add_users} : </td>
				<td>{CONFIG_ADD_USERS}<br /><span class="desc">{PHP.L.an_sitemap.add_users_desc}</span></td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.show_num} : </td>
				<td>{CONFIG_SHOW_NUM}<br /><span class="desc">{PHP.L.an_sitemap.show_num_desc}</span></td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td class="coltop" colspan="3">{PHP.L.an_sitemap.config_freq}</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.freq_pages} : </td>
				<td>{CONFIG_FREC_PAGES}<br /><span class="desc">{PHP.L.an_sitemap.freq_pages_desc}</span></td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.freq_lists} : </td>
				<td>{CONFIG_FREC_LISTS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.freq_sections} : </td>
				<td>{CONFIG_FREC_SECTIONS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.freq_topics} : </td>
				<td>{CONFIG_FREC_TOPICS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.freq_user_lists} : </td>
				<td>{CONFIG_FREC_URER_LISTS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.freq_user_profiles} : </td>
				<td>{CONFIG_FREC_USER_PROFILES}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td class="coltop" colspan="3">{PHP.L.an_sitemap.config_priority}</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.priority_pages} : </td>
				<td>{CONFIG_PRIORITY_PAGES}<br /><span class="desc">{PHP.L.an_sitemap.priority_pages_desc}</span></td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.priority_lists} : </td>
				<td>{CONFIG_PRIORITY_LISTS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.priority_sections} : </td>
				<td>{CONFIG_PRIORITY_SECTIONS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.priority_topics} : </td>
				<td>{CONFIG_PRIORITY_TOPICS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.priority_user_lists} : </td>
				<td>{CONFIG_PRIORITY_URER_LISTS}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>{PHP.L.an_sitemap.priority_user_profiles} : </td>
				<td>{CONFIG_PRIORITY_USER_PROFILES}</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" align="center"><input type="submit" class="submit" value="{PHP.L.Update}" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" class="" value="{PHP.L.an_sitemap.config_default}" onclick="if (confirm('{PHP.L.an_sitemap.config_default_confirm}')) window.location='{CONGIG_ALL_DEF_URL}'; return false; "></td>
			</tr>
		</table>
		</form>
		<!-- END: CONFIG -->
		
		<!-- BEGIN: STRUCTURE -->
		<form name="structure" id="structure" action="{CONFIG_FORM_URL}" method="post">
		<table class="cells">
			<tr>
				<td align="center" width="60px"><strong>{PHP.L.an_sitemap.code}</strong></td>
				<td align="center"><strong>{PHP.L.an_sitemap.name}</strong></td>
				<td align="center"><strong>{PHP.L.an_sitemap.count_elements}</strong></td>
				<td align="center"><strong>{PHP.L.an_sitemap.state}</strong></td>
				<td align="center"><strong>{PHP.L.an_sitemap.link}</strong></td>
			</tr>
			<!-- BEGIN: ELEMENTS -->
			<!-- IF {STRUCT_AREA_NAME} -->
			<tr>
				<td class="coltop" colspan="5">{STRUCT_AREA_NAME}</td>
			</tr>
			<!-- ENDIF -->
				<!-- BEGIN: ELEMENT_ROW -->
				<tr>
					<td>{STRUCT_CODE}</td>
					<td>{STRUCT_LEV}{STRUCT_NAME}</td>
					<td align="center">{STRUCT_ELEM_COUNT}</td>
					<td>{STRUCT_STATE}</td>
					<td><a href="{STRUCT_LINK}" target="_blank">{STRUCT_LINK_TEXT}</a></td>
				</tr>
				<!-- END: ELEMENT_ROW -->
			<!-- END: ELEMENTS -->
			<tr>
				<td colspan="5" align="center"><input type="submit" class="submit" value="{PHP.L.Update}" /></td>
			</tr>
		</table>
		</form>
		<p>{PHP.L.an_sitemap.total_elements}: {CONFIG_TOTAL_ELEMENTS}; {PHP.L.an_sitemap.per_page_elements}: {CONFIG_PER_PAGE_ELEMENTS}
		</p>
		<!-- IF {CONFIG_PAGENAV} -->
		<div class="paging">{CONFIG_PAGENAV}</div>
		<!-- ENDIF -->
		<!-- END: STRUCTURE -->

		<!-- BEGIN: ADD_URLS -->
		<script language="javascript">
			add_url_show = "{PHP.L.an_sitemap.add_url_show}";
			add_url_hide = "{PHP.L.an_sitemap.add_url_hide}";
			add_url_addnewentry = "{PHP.L.addnewentry}";
			add_url_conf_del_checked = "{PHP.L.an_sitemap.marked_del_confirm}";
			add_url_no_url_marked = "{PHP.L.an_sitemap.no_url_marked}";
		</script>
		<form name="additional_urls" id="additional_urls" action="{ADD_URLS_EDIT_FORM_URL}" method="post">
		<table class="cells">
			<tr>
				<td class="coltop" align="center" width="20px"><strong>№</strong></td>
				<td class="coltop" align="center" width="20px"><input type="checkbox" onclick="add_url_checkAll(this.form,'edit_url_check',this.checked);" value="" name="toggle" title="{PHP.L.an_sitemap.select_all}"></td>
				<td class="coltop" align="center">
					<a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_NAME_HREF}"><strong>{PHP.L.an_sitemap.name}</strong></a> / 
					<a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_LINK_HREF}"><strong>{PHP.L.an_sitemap.link}</strong></a></td>
				<td class="coltop" align="center"><a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_DESC_HREF}"><strong>{PHP.L.an_sitemap.description}</strong></a></td>
				<td class="coltop" align="center" width="50px">
					<a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_STATE_HREF}"><strong>{PHP.L.an_sitemap.state}</strong></a> /<br />
					<a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_CHANGE_FREQ_HREF}"><strong>{PHP.L.an_sitemap.change_freq_short}</strong></a> /<br />
					<a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_DATE_HREF}"><strong>{PHP.L.an_sitemap.last_mod_date}</strong></a>
				</td>
				<!--<td class="coltop" align="center"><a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_DATE_HREF}"><strong>{PHP.L.an_sitemap.last_mod_date}</strong></a></td>
				<td class="coltop" align="center"><a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_CHANGE_FREQ_HREF}"><strong>{PHP.L.an_sitemap.change_freq}</strong></a></td>
				<td class="coltop" align="center"><a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_PRIORITY_HREF}"><strong>{PHP.L.an_sitemap.priority}</strong></a></td>
				-->
				<td class="coltop" align="center" width="60px">
					<a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_ORDER_HREF}"><strong>{PHP.L.an_sitemap.order}</strong></a> /<br />
					<a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_PRIORITY_HREF}"><strong>{PHP.L.an_sitemap.priority}</strong></a></td>
				<td class="coltop" align="center" width="20px"><a title="{PHP.L.an_sitemap.order_by_href}" href="{ORDER_BY_ID_HREF}"><strong>ID</strong></a></td>
				<td class="coltop" align="center" width="30px"><strong>{PHP.L.Delete}</strong></td>
			</tr>
			
			<!-- BEGIN: ELEMENTS -->
					<!-- BEGIN: NO_ELEMENTS -->
					<tr>
						<td colspan="8" align="center"><strong>{PHP.L.None}</strong></td>
					</tr>
					<!-- END: NO_ELEMENTS -->
					<!-- BEGIN: ELEMENT_ROW -->
					<tr>
							<td>
								<input type="hidden" name="edit_url_id[{ADD_URLS_ROW_ID}]" value="{ADD_URLS_ROW_ID}" />
								{ADD_URLS_ROW_N}
							</td>
							<td>
								<input type="checkbox" value="{ADD_URLS_ROW_ID}" name="edit_url_check[]" class="edit_url_check"></td>
							<td><strong>{ADD_URLS_ROW_NAME}</strong> <br />
								<span class="desc">{PHP.L.Edit}:</span><br />
								<input type="text" class="text" name="edit_url_name[{ADD_URLS_ROW_ID}]" value="{ADD_URLS_ROW_NAME}" size="54" /><br />
								<input type="text" class="text" name="edit_url_link[{ADD_URLS_ROW_ID}]" value="{ADD_URLS_ROW_LINK}" size="54" /></td>
							<td width="190px"><textarea class="text" name="edit_url_desc[{ADD_URLS_ROW_ID}]"  rows="3" cols="27">{ADD_URLS_ROW_DESC}</textarea></td>
							<td>{ADD_URLS_ROW_STATE}<br />
								{ADD_URLS_ROW_CHANGE_FREQ}<br />
								<input type="text" class="text" name="edit_url_last_mod[{ADD_URLS_ROW_ID}]" value="{ADD_URLS_ROW_LASTMOD}" size="15" /></td>
							<td align="center">
								<input type="text" class="text" name="edit_url_order[{ADD_URLS_ROW_ID}]" value="{ADD_URLS_ROW_ORDER}" size="3" />
								<div class="desc" style="margin:0; padding: 4px 0 0 0;">{PHP.L.an_sitemap.priority}:</div>
								{ADD_URLS_ROW_PRIORITY}</td>
							<td align="center">{ADD_URLS_ROW_ID}</td>
							<td align="center" valign="middle" style="vertical-align:middle">
								<a href="{ADD_URLS_ROW_DEL}" title="{PHP.L.an_sitemap.del_url}: {ADD_URLS_ROW_NAME}" onclick="return confirm('{ADD_URLS_ROW_DEL_CONFIRM}')" ><img src="{PHP.plugin_base_url}/tpl/img/del.gif" align="absmiddle" border="0" /></a></td>
					</tr>
					<!-- END: ELEMENT_ROW -->
			<!-- END: ELEMENTS -->
			<!-- IF {ADD_URLS_TOTAL_ELEMENTS} > 0 -->
			<tr>
					<td colspan="8" align="center"><input type="submit" class="submit" value="{PHP.L.Update}" /></td>
			</tr>
			<!-- ENDIF -->
		</table>
		</form>
		<p>&nbsp;&nbsp;&nbsp;<img src="{PHP.plugin_base_url}/tpl/img/join2.gif" align="absmiddle" border="0" /> {PHP.L.an_sitemap.marked}: &nbsp; <a href="{ADD_URLS_DEL_GROUP}" title="{PHP.L.an_sitemap.del_url}: {ADD_URLS_ROW_NAME}" id="act_w_selected_urls"><img src="{PHP.plugin_base_url}/tpl/img/del.gif" align="absmiddle" border="0" /> {PHP.L.Delete}</a>
		</p>
		<p style="text-align:right">{PHP.L.an_sitemap.total_elements}: {ADD_URLS_TOTAL_ELEMENTS}; {PHP.L.an_sitemap.per_page_elements}: {ADD_URLS_PER_PAGE_ELEMENTS}
		</p>
		<p class="desc">{PHP.L.an_sitemap.add_urls_desc}</p>
		<!-- IF  {ADD_URLS_TOTAL_ELEMENTS} > 0 AND {ADD_URLS_PAGENAV} != '' -->
		<div class="paging">{ADD_URLS_PAGENAV}</div>
		<!-- ENDIF -->
		
		<div style="cursor:pointer; font-size:112%; font-weight:bold">
			<img src="{PHP.plugin_base_url}/tpl/img/new.gif" align="absmiddle" />
			<span id="add_new_url_header">{PHP.L.addnewentry}...</span>
		</div>
		<div id="add_new_url" style="display:{ADD_URL_DISPLAY}">
			<form name="add_url" id="add_url" action="{ADD_URLS_ADD_FORM_URL}" method="post">
				<table class="cells">
				<tr>
					<td style="width:160px;">{PHP.L.an_sitemap.link} :</td>
					<td><input type="text" class="text" name="add_url_link" value="{ADD_URL_LINK}" size="48"  /> </td>
					<td>{PHP.L.adm_required}<br /><span class="desc">{PHP.L.an_sitemap.link_desc}</span></td>
				</tr>
				<tr>
					<td style="width:160px;">{PHP.L.an_sitemap.name} :</td>
					<td><input type="text" class="text" name="add_url_name" value="{ADD_URL_NAME}" size="48" maxlength="255" /> </td>
					<td>{PHP.L.adm_required}<br /><span class="desc">{PHP.L.an_sitemap.name_desc}</span></td>
				</tr>
				<tr>
					<td>{PHP.L.an_sitemap.description} :</td>
					<td><textarea class="text" name="add_url_desc"  rows="8" cols="53">{ADD_URL_DESC}</textarea></td>
					<td><span class="desc">{PHP.L.an_sitemap.add_urls_desc}</span></td>
				</tr>
				<tr>
					<td>{PHP.L.an_sitemap.state} :</td>
					<td>{ADD_URL_STATE}</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>{PHP.L.an_sitemap.last_mod_date} :</td>
					<td><input type="text" class="text" name="add_url_last_mod" value="{ADD_URL_LASTMOD}" size="48" maxlength="128" /></td>
					<td>({PHP.L.an_sitemap.not_required})<br /><span class="desc">{PHP.L.an_sitemap.last_mod_desc}</span></td>
				</tr>
				<tr>
					<td>{PHP.L.an_sitemap.change_freq} :</td>
					<td>{ADD_URL_CHANGE_FREQ}</td>
					<td><span class="desc">{PHP.L.an_sitemap.freq_pages_desc}</span></td>
				</tr>
				<tr>
					<td>{PHP.L.an_sitemap.priority} :</td>
					<td>{ADD_URL_PRIORITY}</td>
					<td><span class="desc">{PHP.L.an_sitemap.priority_pages_desc}</span></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><input type="submit" class="submit" value="{PHP.L.Add}" /></td>
				</tr>
				</table>
			</form>
		</div>
		<!-- END: ADD_URLS -->
		
		<!-- BEGIN: INEGRATORS -->
		<form name="structure" id="structure" action="{CONFIG_FORM_URL}" method="post">
		<table class="cells">
			<tr>
				<td class="coltop" align="center" width="60px"><strong>{PHP.L.an_sitemap.code}</strong></td>
				<td class="coltop" align="center"><strong>{PHP.L.an_sitemap.name}</strong></td>
				<td class="coltop" align="center"><strong>{PHP.L.an_sitemap.description}</strong></td>
				<td class="coltop" align="center"><strong>{PHP.L.an_sitemap.state}</strong></td>
			</tr>

			<!-- BEGIN: INEGRATORS_ROW -->
			<tr>
				<td align="center">{INTEGRATOR_CODE}</td>
				<td><strong>{INTEGRATOR_NAME}</strong></td>
				<td>{INTEGRATOR_DESC}</td>
				<td>{INTEGRATOR_STATE}</td>
			</tr>
			<!-- END: INEGRATORS_ROW -->

			<tr>
				<td colspan="4" align="center"><input type="submit" class="submit" value="{PHP.L.Update}" /></td>
			</tr>
		</table>
		</form>
		<p>{PHP.L.an_sitemap.total_elements}: {CONFIG_TOTAL_ELEMENTS}; {PHP.L.an_sitemap.per_page_elements}: {CONFIG_PER_PAGE_ELEMENTS}
		</p>
		<!-- IF {CONFIG_PAGENAV} -->
		<div class="paging">{CONFIG_PAGENAV}</div>
		<!-- ENDIF -->
	<!-- END: INEGRATORS -->
	
	<!-- BEGIN: HELP -->
	<div>{HELP_BODY}</div>
	<!-- END: HELP -->
	
	<p>&nbsp;</p>
	<p style="text-align:center"><em>{PHP.L.an_sitemap.plugin_ver}:</em> <strong>{SITE_MAP_VERSION}</strong>. {CHECK_NEW_VERSION}</p>
	<p style="text-align:center">{AN_BUTTON}</p>
<!-- END: MAIN -->