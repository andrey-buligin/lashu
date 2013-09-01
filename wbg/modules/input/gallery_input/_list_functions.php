<?php 

	function _textlist_get_owner($x){
		static $users;
		if (!$users) {
			$sql_res = mysql_query("SELECT id,login FROM wbg_users");
			while ($arr = mysql_fetch_assoc($sql_res)) {
				$users[$arr['id']] = $arr['login'];
			}
		}
		return @$users[$x];
	}

	function _textlist_get_datetime($value){
		return date("d.m.Y",$value);
	}

	function _textlist_show_content($value){
		$return = null;
		if (!$value) return;
		$data = unserialize($value);
		if (!is_array($data)) return;
		if (@$data['date']) {
			$return .= date("d.m.Y", $data['date']);
		}	
		if (@$data['time']) {
			$return .= ' '.$data['time'];
		}
		//$text = str_replace("<","&lt;",mb_substr($return,0,50, 'utf8'));
		return trim($return);
	}

	function _textlist_set_active($x, $data){
		global $_CFG;
		return '<input type="checkbox" '.($x?'checked':'').' value="1" name="active" style="margin:0px" onclick="self.location.href=\'http://'.$_CFG['path_url_full'].'wbg/core/categories/iframe_categories.php?id='.$_CFG['current_category']['id'].'&act='.$data['id'].'\'">';
	}

	function _textlist_add_bullets($sort_id, $full_data){
	    static $js;
		static $counter = 0;
	    global $_CFG;
	    $counter ++;

	    $return =  '<a href="#" title="'.$counter.'" onmouseover="this.onclick=m_e" f="'.$full_data['id'].'" d="1"><img src="'.$_CFG['url_to_skin'].'my_list/images/icn-moveup.gif" border="0"/></a>';
	    $return .= '<a href="#" title="'.$counter.'" onmouseover="this.onclick=m_e" f="'.$full_data['id'].'" d="0"><img src="'.$_CFG['url_to_skin'].'my_list/images/icn-movedown.gif" border="0"/></a>';

	    if (!$js){
	           $js =
	        '<script>'.
	            'function m_e($event){
	            	var $counter = 1;
	            	if (window.event){
	            		$event = window.event;
	            	}
	            	if ($event.ctrlKey){
	            		$counter = prompt("How much times to make move", "1");
	            	}
	            	$id = this.getAttribute("f");
	            	$direction = this.getAttribute("d");
	                document.location.href="'.$_SERVER['PHP_SELF'].'?id='.$_CFG['current_category']['id'].'&move="+$id+"&dir="+$direction+"&count="+$counter;
	                return false;
	            };'.
	        '</script>';
	        $return .= $js;
	    }
	    return $return;
	}

	function _textlist_cut_title($x) {
		if (mb_strlen($x, "utf-8") > 50) {
			return mb_substr($x, 0, 50, "utf-8").'.....';
		} else {
			return $x;
		}

	}

?>