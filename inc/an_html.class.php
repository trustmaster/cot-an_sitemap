<?
// *********************************************
// *    HTML Helper                            *
// *       HTML class                          *
// *    Alex & Natty studio                    *
// *        http://portal30.ru                 *
// *                                           *
// *            © Alex & Natty Studio  2010    *
// *********************************************
if (!defined('COT_CODE')) { die('Wrong URL.'); }

// Класс в разработке
// Призван облегчить формирование HTML - элементов
// при работе с формами  и т.п.

// Версия 0.0.1


class an_HTML {

    // class version
	var $ver = '0.0.1';
	
	
	/**
	 * Make option for select and radio elements
	 * @param	string	The value of the option
	 * @param	string	The text for the option
	 * @param	string	The returned object property name for the value
	 * @param	string	The returned object property name for the text
	 * @return	object
	 */
	function option( $value, $text='', $value_name='value', $text_name='text', $disable=false )
	{
		$obj = new stdClass;
		$obj->$value_name	= $value;
		$obj->$text_name	= trim( $text ) ? $text : $value;
		$obj->disable		= $disable;
		return $obj;
	}
	
	/**
	* Generates an HTML radio list
	*
	* @param array An array of option objects
	* @param string The value of the HTML name attribute
	* @param string Additional HTML attributes for the <select> tag
	* @param mixed The key that is selected
	* @param string The name of the object variable for the option value
	* @param string The name of the object variable for the option text
	* @returns string HTML for the select list
	*/
	function radiolist( $arr, $name, $selected = null, $attribs = null, $key = 'value', $text = 'text',  $idtag = false, $translate = false )
	{
		reset( $arr );
		$html = '';

		if (is_array($attribs)) {
			$attribs = JArrayHelper::toString($attribs);
		 }

		$id_text = $name;
		if ( $idtag ) {
			$id_text = $idtag;
		}

		for ($i=0, $n=count( $arr ); $i < $n; $i++ )
		{
			$k	= $arr[$i]->$key;
			$t	= $translate ? JText::_( $arr[$i]->$text ) : $arr[$i]->$text;
			$id	= ( isset($arr[$i]->id) ? @$arr[$i]->id : null);

			$extra	= '';
			$extra	.= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected ))
			{
				foreach ($selected as $val)
				{
					$k2 = is_object( $val ) ? $val->$key : $val;
					if ($k == $k2)
					{
						$extra .= " selected=\"selected\"";
						break;
					}
				}
			} else {
				$extra .= ((string)$k == (string)$selected ? " checked=\"checked\"" : '');
			}
			$html .= "\n\t<input type=\"radio\" name=\"$name\" id=\"$id_text$k\" value=\"".$k."\"$extra $attribs />";
			$html .= "\n\t<label for=\"$id_text$k\">$t</label>";
		}
		$html .= "\n";
		return $html;
	}

	/**
	* Generates a yes/no radio list
	*
	* @param string The value of the HTML name attribute
	* @param string Additional HTML attributes for the <select> tag
	* @param mixed The key that is selected
	* @returns string HTML for the radio list
	*/
	function booleanlist( $name, $selected = null, $yes='yes', $no='no', $attribs = null, $id=false )
	{
		$arr = array(
			an_HTML::option('0', $no ),
			an_HTML::option('1', $yes)
		);
		return an_HTML::radiolist($arr, $name, (int) $selected, $attribs, 'value', 'text',  $id );
	}
	
} 
?>