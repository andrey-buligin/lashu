<?php
/**
 * Eto modulj texlista obichnogo
 *
 */

if ($_CFG['user']['interface_language']==1){
	define("_TXL_ACTIVE_", "Dokuments aktīvs");
	define("_TXL_NOSAUKUMS_", "Nosaukums");
	define("_TXL_REDZTIKAIINS_", "Redzams tikai iekš inSite");
	define("_TXL_BTNSAVE_", "Saglabāt");
	define("_TXL_BTNAPPLY_", "Apstiprināt");
	define("_TXL_BTNCANCEL_", "Atcelt");
	define("_TXL_BTNEDTPL_", "Labot šablonu");

	define("_TXL_OWNER_", "Izveidoja");
	define("_TXL_CREATED_", "Izveidots");
	define("_TXL_TITLE_", "Nosaukums");
	define("_TXL_COPY_DATA_", "Kopēt/Pārnest");
	define("_TXL_ALERT1_", "Atzimējiet vienu vai vairākus dokumentus");
	define("_TXL_ISACTIVE_", "");

} else if ($_CFG['user']['interface_language']==2) {
	define("_TXL_ACTIVE_", "Документ активен");
	define("_TXL_NOSAUKUMS_", "Название");
	define("_TXL_REDZTIKAIINS_", "Видно только в inSite");
	define("_TXL_BTNSAVE_", "Сохранить");
	define("_TXL_BTNAPPLY_", "Подтвердить");
	define("_TXL_BTNCANCEL_", "Отменить");
	define("_TXL_BTNEDTPL_", "Редактировать шаблон");

	define("_TXL_OWNER_", "Создатель");
	define("_TXL_CREATED_", "Создан");
	define("_TXL_TITLE_", "Название");
	define("_TXL_COPY_DATA_", "Копировать/Перенести");
	define("_TXL_ALERT1_", "Выделите один или более документов");
	define("_TXL_ISACTIVE_", "");

} else {
	define("_TXL_ACTIVE_", "Document is active");
	define("_TXL_NOSAUKUMS_", "Title ");
	define("_TXL_REDZTIKAIINS_", "Visible only in inSite");
	define("_TXL_BTNSAVE_", "Save");
	define("_TXL_BTNAPPLY_", "Apply");
	define("_TXL_BTNCANCEL_", "Cancel");
	define("_TXL_BTNEDTPL_", "Edit template");

	define("_TXL_OWNER_", "creator");
	define("_TXL_CREATED_", "created");
	define("_TXL_TITLE_", "Title");
	define("_TXL_COPY_DATA_", "Copy/Move");
	define("_TXL_ALERT1_", "Select at last one document");
	define("_TXL_ISACTIVE_", "");}


/**
 * Podgruzhajem neobhodimije klassi.
 */
include_once ($_CFG['path_to_cms'].'core/libraries/my_list.class/extensions/_with_edit.php');

class _with_copy extends _with_edit {

	function _ext_actionButtons(){
		global $_CFG;
		$popup_edit_template = explode($_CFG['cms_name'],$this->template_file);
		return
		'<div style="padding:5px 0px 3px 0px;">
			<script>
			function delete_elements(){
				if (!confirm(" '.__MYL_C_DEL_.' ")) return false;
				document.forms["mainform"].action = "?id='.$_CFG['current_category']['id'].'";
				return true;
			}
			function copy_element(){
				$checked = 0;
				$elements = document.getElementsByTagName("input");
				for ($x=0;$x<$elements.length;$x++){
					if ($elements[$x].type=="checkbox" && $elements[$x].name=="check_element[]"){
						if ($elements[$x].checked == true){
							$checked = 1;
							break;
						}
					}

				}
				if (!$checked){
					alert("'._TXL_ALERT1_.'");
					return;
				}

				if (window.Popup){
					window.Popup.close();
				}
				window.Popup = window.open("../../modules/libraries/textlist.class/input/popup.copy_data.php?id="+'.$_CFG['current_category']['id'].',"","width=800px,height=500px,left=100px,top=100px");
			}
			function open_template_edit(){
				window.Popup = window.open("../templates/popup.edit_template.php?file='.$popup_edit_template[1].'&cat='.$_CFG['current_category']['id'].'","","width=800px,height=550px,left=100px,top=100px");
			}
			</script>
			<input type="submit" value=" '.__MYL_B_DEL_.' " class="button2" onclick="return delete_elements()" name="delete" style="color:red;float:right;margin:0px 2px">
			<input type="button" value=" '._TXL_BTNEDTPL_.' " class="button3" onclick="open_template_edit()"  style="float:right;margin:0px 0px">
			'.($this->add_enabled?'<input type="button" value=" '.__MYL_B_ADD_.' " class="button"  onclick="edit_element(0)" style="float:left">':'').'
			<input type="button" value=" '._TXL_COPY_DATA_.' " class="button2"  onclick="copy_element()" style="float:left;margin:0px 2px">
		</div><br>';
	}
}



class textlist {

	var $sql_table; 		// Imja bazi dannih
	var $template_file; // Polnij putj k shablonu. Shablon v formate wbg_parse_template
	var $only_onetext = false; // Esli false - to vse kak obichno. esli true - to vmesto textlista u nas vvod toka 1 elementa
	var $highlight = 0;

	/**
	 * Eto massiv dlja sluchajev eli nuzhno rukami zanesti kakuju libo informaciju v polja kotorije
	 * iznachalno ne zadumani modulem textlist. Naprimer na TBLNNK takim javljaetsa prinadlezhnostj
	 * dokumenta konkretnomu deputatu. format - key = sql Cell , value - znachenije. ['name'] = "Vasja pupkins"
	 * @see add_on_save()
	 * @access PRIVATE
	 * @var array
	 */
	var $add_to_sql_string = array();

	/**
	 * Eto glavnaja funkcija. Ona opredeljajet chto deltaj i chto pokazivatj
	 *
	 */
	function show_textlist(){
		global $_CFG;

		/**
		 * Eto massiv kuda u nas skladivajutsa kod oshibki i text soobshenija ob oshibke
		 * esli mi uzajem proverku soderzhanija
		 */
		$ERROR = null;

		if (@$_POST['chk_el'] and @$_POST['delete']) {
			$ids = implode(",", $_POST['chk_el']);
			foreach ($_POST['chk_el'] as $value) {
				$document = mysql_fetch_assoc(mysql_query("SELECT ins_title FROM ".$this->sql_table." WHERE id='".$value."'"));
				WBG::save_to_log(3, $document['ins_title'], 4);
			}
			mysql_query("DELETE FROM ".$this->sql_table." WHERE id IN (".$ids.")");
		}


		if (@$_GET['edit']){
			$this->highlight = $_GET['edit'];
		}


		if (isset($_GET['move'])){
			for ($x = 0; $x<$_GET['count']; $x++){
				move_element($this->sql_table, @$_GET['dir'], @$_GET['move']);
				$this->highlight = $_GET['move'];
			}
		}


		if (isset($_GET['act'])){
			$document = mysql_fetch_assoc(mysql_query("SELECT active,ins_title FROM ".$this->sql_table." WHERE id=".$_GET['act']));
			$active = $document['active'] ? 0 : 1;
			$module_id = mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id=".$_CFG['current_category']['id']),0,0);
			mysql_query("UPDATE ".$this->sql_table." SET active=".$active." WHERE id=".$_GET['act']);
			WBG::save_to_log(7, $document['ins_title'], 4, (int)$_GET['act'], $module_id);
		}

		if (isSet($_POST['saved_data'])){ // Esli eto bil save dannih , to delajem SAVE
			$this->save_data($ERROR);
			if (@$ERROR){
				unset($_GET['saved']);
			}
		}

		if (!isset($_GET['edit']) or isset($_GET['from']) or isset($_GET['saved'])){ // Pokaz lista
			if (!$this->only_onetext){
				return $this->_txtlist_show_table();
			} else {
				$onetextID = @mysql_result(mysql_query("SELECT id FROM ".$this->sql_table." WHERE category_id=".$_CFG['current_category']['id']),0,0);
				$_GET['edit'] = $onetextID;
				return $this->show_form($onetextID, $ERROR);
			}
		} else {
			return $this->show_form($_GET['edit'], $ERROR);
		}

	}


	/**
	 * Eta funkcija vizivajetsa kogda uzer delajet crosslink. I on vobral crosslink na
	 * content. I u kategorii tam modulj imenno texslist. Togda vizivajetsa eta funkcija chtobi
	 * pokazatj spisok Elementov podgotovlennih dlja crosslinka
	 *
	 */
	function show_crosslink(){
		global $_CFG;
		include_once ($_CFG['path_to_cms'].'core/libraries/my_list.class/_with_select.php');

		$my_list = new _with_select();
		$my_list->sql_table = $this->sql_table;
		$my_list->sql_where = " category_id=".$_CFG['current_category']['id'];
		$my_list->nosort = true;
		if (isset($this->sql_order)){
			$my_list->sql_order = $this->sql_order;
		} else {
			$my_list->sql_order = "sort_id";
		}
		if (isset($this->sql_direction)){
			$my_list->sql_direction = $this->sql_direction;
		} else {
			$my_list->sql_direction = "1";
		}

		$my_list->unique_id = "textlist";

		$my_list->show_in_table("id","ID", null);
		$my_list->show_in_table("ins_title",_TXL_TITLE_, null, "nowrap");
		$my_list->show_in_table("doc_url", "URL", null, "nowrap");
		$my_list->show_in_table("content","Content", "_texlits_show_content","");
		$my_list->show_in_table("created",_TXL_CREATED_, "_texlits_get_datetime");
		$my_list->show_in_table("owner",_TXL_OWNER_, "_texlits_get_owner");

		$javascript = '
		<script>
		function _ml_withselect_onclick($id){
			if (confirm("Pārliecināti?")){
				window.opener.window.crosslink_insert("'.$_GET['field'].'", '.$_POST['id'].',"?doc="+$id);
				window.close();
			}
		}
		</script>';
		return $javascript.$my_list->show_table();

	}


	function _txtlist_show_table(){
		global $_CFG;
		// [[[ Pered pokazom nuzhno posmotretj nebilo li u nas MOVE ili COPY elementov

		$this->_make_copy_move();

		$my_list 							= new _with_copy();
		$my_list->sql_table 				= $this->sql_table;
		$my_list->sql_where 				= " category_id=".$_CFG['current_category']['id'];
		$my_list->nosort 					= true;

		$_CFG['url_to_textlist_class'] 		= dirname(str_replace($_CFG['path_to_cms'], $_CFG['url_to_cms'], __FILE__)).'/';
		$_CFG['path_to_textlist_class'] 	= dirname(__FILE__).'/';

		if (isset($this->sql_order)){
			$my_list->sql_order = $this->sql_order;
		} else {
			$my_list->sql_order = "sort_id";
		}
		if (isset($this->sql_direction)){
			$my_list->sql_direction = $this->sql_direction;
		} else {
			$my_list->sql_direction = "1";
		}

		$my_list->unique_id = "textlist";
		$my_list->template_table = file_get_contents(dirname(__FILE__).'/_list_template_table.tpl');

		$my_list->style_where["id"]["condition"] = "=='".$this->highlight."'";
		$my_list->style_where["id"]["insert"] = ' style="background:#ffe8c0"';


		$my_list->insert_cell("id","ID", null);
		$my_list->insert_cell("ins_title",_TXL_TITLE_, "cut_title", "nowrap");
		$my_list->insert_cell("doc_url", "URL", null, "nowrap");
		$my_list->insert_cell("content","Content", "_texlits_show_content","width='100%'");
		$my_list->insert_cell("created",_TXL_CREATED_, "_texlits_get_datetime");
		$my_list->insert_cell("owner",_TXL_OWNER_, "_texlits_get_owner");
		$my_list->insert_cell("active",_TXL_ISACTIVE_, "_textlist_set_active", "onclick='' nowrap");
		$my_list->insert_cell("sort_id","Sort", 'add_bullets', 'onclick="" nowrap');
		return $my_list->show_table();
	}


	function _make_copy_move(){
		global $_CFG;

		if (!@$_POST['list_action']){
			return;
		}

		$module_id 		= @mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id=".$_CFG['current_category']['id']),0,0);
		$language_dest 	= @mysql_result(mysql_query("SELECT language FROM wbg_tree_categories WHERE id='".$_POST['list_value']."'"),0,0);


		if ($_POST['list_action'] == 'copy') {
			$last_sort_id = mysql_result(mysql_query("SELECT max(sort_id) FROM ".$this->sql_table." WHERE category_id=".(int)$_POST['list_value']),0,0);
			$_POST['chk_el'] = array_reverse($_POST['chk_el']);
			foreach ($_POST['chk_el'] as $value){
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".$this->sql_table." WHERE id=".$value));
				unset($data['id']);
				unset($sql_string);

				$data['category_id'] = (int)$_POST['list_value'];
				$data['owner'] = $_CFG['user']['id'];
				$data['created'] = time();
				$data['sort_id'] = ++ $last_sort_id;
				$data['lang'] = $language_dest;


				foreach ($data as $key2=>$value2){
					$sql_string[] = $key2."='".addslashes($value2)."'";
				}
				$sql_string = "INSERT INTO ".$this->sql_table." SET ".implode(",",$sql_string);
				mysql_query($sql_string);

				if (mysql_error()){echo "<br>".mysql_error()."<br>FILE:".__FILE__."<br>LINE:".__LINE__."<br>QUERY: ".$sql_string."<br>";}
				WBG::save_to_log(5, $data['ins_title'], 4, (int)$_POST['list_value']);
			}

		}
		if ($_POST['list_action'] == 'move') {
			$last_sort_id = mysql_result(mysql_query("SELECT max(sort_id) FROM ".$this->sql_table." WHERE category_id=".(int)$_POST['list_value']),0,0);
			foreach ($_POST['chk_el'] as $value){
				$sql_string = "UPDATE ".$this->sql_table." SET category_id=".(int)$_POST['list_value'].",sort_id=".(++$last_sort_id)." WHERE id=".$value;
				mysql_query($sql_string);
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".$this->sql_table." WHERE id=".$value));
				if (mysql_error()){echo "<br>".mysql_error()."<br>FILE:".__FILE__."<br>LINE:".__LINE__."<br>QUERY: ".$sql_string."<br>";}
				WBG::save_to_log(4, $data['ins_title'], 4, (int)$_POST['list_value']);
			}
		}
	}


	/**
	*	@access PUBLIC
	*	Funkcija pokazivajet formu. Otrabativajet kogda uzer klikajet na dokument
	* 	@param integer $id -> Eto ID elementa formu kotorogo nado pokazatj
	*	@param array $ERROR -> massiv kuda klastsa errori budut
	*/
	function show_form($id, $ERROR = null){
		global $_CFG;
		// Dlja generacii formi iz shablona mi ispolzujem standartnij insite klass - wbg_parse_template
		include_once($_CFG['path_to_cms'].'core/libraries/wbg_parse_template.class/wbg_parse_template.class.php');
		$element_data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".$this->sql_table." WHERE id='".$id."'"));

		$element_data['doc_url'] 	= @str_replace('"',"&quot;",$element_data['doc_url']);
		$element_data['ins_title'] 	= @str_replace('"',"&quot;",$element_data['ins_title']);


		if (isSet($element_data['content'])){
			$content = unserialize($element_data['content']);
		} else {
			$content = '';
			if ($id == 0){ // Esli eto dobavlenije novogo elementa
				$element_data['active'] = 1;
			}
		}

		$header ='
		<div style="background:#C6C7C6;">
			<table cellspacing="2" cellpadding="2" border="0" style="color:#FFFFFF">
            	<tr>
            		<td>'._TXL_ACTIVE_.'</td>
					<td><input type="hidden" value="" name="ins_active"><input type="checkbox" value="1" name="ins_active" '.($element_data['active']?'checked':'').'></td>
            	</tr>
            	'.(!$this->only_onetext?'
            	<tr>
            		<td>'._TXL_NOSAUKUMS_.'</td>
					<td style="padding-left:6px">
						<input size="40" type="text" value="'.$element_data['ins_title'].'" name="ins_title" class="default"> ('._TXL_REDZTIKAIINS_.')
					</td>
            	</tr>':'<input type="hidden" name="ins_title" value="'.$element_data['ins_title'].'">').'
            	<tr>
            		<td>URL (if needed)</td>
					<td style="padding-left:6px">
						<input size="40" type="text" value="'.$element_data['doc_url'].'" name="doc_url" class="default">
					</td>
            	</tr>
            </table>
		</div>'.$this->_get_buttons2();

		$tpl = new wbg_parse_template ($content);
		$tpl->with_css = true;
		$OUT_form = '<form method="post" action="" id="my-edit-form"  enctype="multipart/form-data">'.($ERROR?'<div style="color:red;padding:5px">'.$ERROR.'</div>':'');
		$OUT_form .= $header;
		$OUT_form .= $tpl->make_parsing(file_get_contents($this->template_file));
		$OUT_form .=  '<input type="hidden" name="saved_data" value="1"></form>';
		$OUT_form .= $this->_get_buttons();
		$OUT_form .= '
		<script>
			$win_temp = window.document.location.href.split("?");
			function sendform(){
				window.document.getElementById("my-edit-form").action = $win_temp[0]+"?saved&'.$this->_txt_get_link().'";
				window.document.getElementById("my-edit-form").submit()
			}
			function applyform(){
				window.document.getElementById("my-edit-form").action = $win_temp[0]+"?apply&'.$this->_txt_get_link().'";
				window.document.getElementById("my-edit-form").submit();
			}
			function cancelform(){
				window.document.location.href=$win_temp[0]+"?from&'.$this->_txt_get_link().'"
			}
		</script>';
		return $OUT_form;
	}

	/**
	 * Funkcija generirujet javascript v kotorom lezhat buttoni kotorije pojavljajutsa
	 * pri vkljuchenii rezhima redaktirovanija dokumenta. pojavljajutsa v parent Freime.
	 *
	 * @return HTML_code
	 */
	function _get_buttons(){
		return
		'<script>
			function init2(){

				$string = \'<input type="button" value="'._TXL_BTNSAVE_.'" class="button" onclick=window.frames[1].window.sendform()> \';
				'.(!$this->only_onetext ?'
				$string += \'<input type="button" value="'._TXL_BTNAPPLY_.'" class="button" onclick=window.frames[1].window.applyform()> \';
				$string += \'<input type="button" value="'._TXL_BTNCANCEL_.'" class="button" onclick=window.frames[1].window.cancelform()> \';
				':'').'
				window.parent.window.document.getElementById(\'work-area-save\').innerHTML = $string;
			}
		</script>';
	}
	function _get_buttons2(){
		return '
		<div style="text-align:right;margin-top:2px">
			<input type="button" value="'._TXL_BTNSAVE_.'" class="button" onclick=sendform()>
			'.(!$this->only_onetext ?'
			<input type="button" value="'._TXL_BTNAPPLY_.'" class="button" onclick=applyform()>
			<input type="button" value="'._TXL_BTNCANCEL_.'" class="button" onclick=cancelform()>
			':'').'
		</div>';
	}

	/**
	*	@access PUBLIC
	*	Funkcija sohranjajet dannije prishedshije iz formi
	*	@param array $ERROR -> massiv kuda klastsa errori budut
	*/
	function save_data(&$ERROR){
		global $_CFG;
		include_once($_CFG['path_to_cms'].'core/libraries/wbg_parse_template.class/wbg_parse_template.class.php');
		$tpl = new wbg_parse_template ();
		$tpl->get_elements_before_save(file_get_contents($this->template_file));
		$tpl->serialize_data = true;
		$save_array = $tpl->get_data_for_save($_POST, $ERROR);


		$sql_string = "
			category_id= '".$_CFG['current_category']['id']."',
			ins_title 	='".$_POST['ins_title']."',
			doc_url 	='".$_POST['doc_url']."',
			content 	='".$save_array."',
			active 		='".($_POST['ins_active']?1:0)."'";

		/**
		*	Dobavljajem dannije kotorije u nas dobavleni ruchkami
		* 	opisanije peremennoj pri ee objavlenii vidno. (sm vishe)
		*/
		foreach($this->add_to_sql_string as $key=>$value){
			$sql_string .= ",".$key."='".$value."'";
		}

		if ($_GET['edit'] == 0 ){ // Dobavlenije novoij zapisi
			global $_CFG;
			$sql_string .= ",owner='".$_CFG['user']['id']."'";
			$sql_string .= ",created='".time()."'";
			$sort_id = mysql_result(mysql_query("select max(sort_id) from ".$this->sql_table." where category_id = '".$_CFG['current_category']['id']."'"),0,0)+1;
			$sql_string .= ",sort_id='".$sort_id."'";
			$language = mysql_result(mysql_query("select language  from wbg_tree_categories where id=".$_CFG['current_category']['id']),0,0);
			$sql_string .= ",lang='".$language."'";
			mysql_query("INSERT INTO ".$this->sql_table." SET ".$sql_string);
			$_GET['edit'] = mysql_insert_id();
			$module_id = mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id=".$_CFG['current_category']['id']),0,0);
			WBG::save_to_log(1, $_POST['ins_title'], 4, $_CFG['current_category']['id'], $module_id);
		} else {
			mysql_query("UPDATE ".$this->sql_table." SET ".$sql_string." WHERE id=".$_GET['edit']);
			$module_id = mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id=".$_CFG['current_category']['id']),0,0);
			WBG::save_to_log(2, $_POST['ins_title'], 4, $_CFG['current_category']['id'], $module_id);
		}

		echo mysql_error();
	}

	/**
	*	@access PUBLIC
	*	Funkija  dovabljejet elementi ih znachenija kotorije pri SAVE elementa pojdut tozhe v bazu
	*	@param string $sql_field -> eto nazvanije cella kuda pojdet $content
	*	@param strgin $content -> eto dannije kotorije pojdut v tablicu
	*/
	function add_on_save($sql_field, $content){
		$this->add_to_sql_string[$sql_field] = $content;
	}

	/**
	*	@access PUBLIC
	*	Funkcija prosto sozdajet bazu dannih.
	*	@param string $module_name -> nazvanije modulja kotorij installit
	*/
	function install_database($module_name){
		//mysql_query('DROP TABLE IF EXISTS '.$module_name.';');
		mysql_query("
			CREATE TABLE ".$module_name." (
			  id int(10) unsigned NOT NULL auto_increment,
			  category_id int(10) unsigned NOT NULL default '0',
			  sort_id int(10) unsigned default NULL,
			  ins_title varchar(255) NOT NULL default '',
			  content text,
			  lang tinyint(3) unsigned NOT NULL default '0',
			  created int(10) unsigned default '0',
			  owner varchar(50) default '0',
			  active tinyint(1) unsigned NOT NULL default '0',
			  PRIMARY KEY  (id),
			  UNIQUE KEY id (id),
			  KEY id_2 (id),
			  KEY category_id (category_id),
			  KEY active (active),
			  KEY lang (lang)
			)");
	}

	/**
	*	@access private
	*	Funkcija generit chastj linka
	*	@param array $except -> te peremennije v GETe kotorije nado iskljuchitj.
	*	@param array $left -> te peremennije v GETe kotorije nado ostavitj. Esli peredano , to ubirajetsa vse ktome left
	*/
	function _txt_get_link($except = null, $left = null){
		$link = null;
		if ($left){
			foreach($left as $key=>$value){
				$link .= '&'.$value.'='.$_GET[$value];
               }
			return $link;
		}

		foreach ($_GET as $key=>$value){
			if ($key=="delete") continue; // Delete ubirajem poljubomu , na vsjakij sluchaj.
			if (@in_array($key,$except)) continue;
			$link .= '&'.$key.'='.$value;
		}
		return $link;
	}
}


//====================================================
// [[[ Uzerskije funkcii

	function _texlits_get_owner($x){
		static $users;
		if (!$users) {
			$sql_res = mysql_query("SELECT id,login FROM wbg_users");
			while ($arr = mysql_fetch_assoc($sql_res)) {
				$users[$arr['id']] = $arr['login'];
			}
		}
		return @$users[$x];
	}

	function _texlits_get_datetime($value){
		return date("d.m.Y",$value);
	}

	function _texlits_show_content($value){
		$return = null;
		if (!$value) return;
		$data = unserialize($value);
		if (!is_array($data)) return;
		foreach($data as $key=>$value){
			if ($key == "ins_title" or $key=="ins_active" or $key=="saved_data" or $key=="doc_url" ) continue;
			if (is_array($value)) continue;
			$return .= " ".$value;
        }
		$text = str_replace("<","&lt;",mb_substr($return,0,50, 'utf8'));
		return $text? $text." ... ":'';
	}

	function _textlist_set_active($x, $data){
		global $_CFG;
		return '<input type="checkbox" '.($x?'checked':'').' value="1" name="active" style="margin:0px" onclick="self.location.href=\'?id='.$_CFG['current_category']['id'].'&act='.$data['id'].'\'">';

	}

	function add_bullets($sort_id, $full_data){
	    static $js;
		static $counter = 0;
	    global $_CFG;
	    $counter ++;

	    $return =  '<a href="#" title="'.$counter.'" onmouseover="this.onclick=m_e" f="'.$full_data['id'].'" d="1"><img src="'.$_CFG['url_to_skin'].'my_list/images/icn-movedown.gif" border="0"/></a>';
	    $return .= '<a href="#" title="'.$counter.'" onmouseover="this.onclick=m_e" f="'.$full_data['id'].'" d="0"><img src="'.$_CFG['url_to_skin'].'my_list/images/icn-moveup.gif" border="0"/></a>';

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


	function cut_title($x) {
		if (mb_strlen($x, "utf-8") > 50) {
			return mb_substr($x, 0, 50, "utf-8").'.....';
		} else {
			return $x;
		}

	}

	function move_element($table, $direction, $element_id){
	    if (!$element_id) return;

	    if ($direction){
	        $order = "DESC";
	        $znak = "<";
	    } else {
	        $order = "ASC";
	        $znak = ">";
	    }
	    $current_obj = mysql_fetch_assoc(mysql_query("SELECT id,sort_id,category_id FROM ".$table." WHERE id=".$element_id));

	    $SQL_str = "SELECT id,sort_id FROM ".$table." WHERE sort_id" . $znak . $current_obj['sort_id'] . " AND category_id=".$current_obj['category_id']." ORDER BY sort_id ".$order." LIMIT 1";
	    $other_obj = mysql_fetch_assoc(mysql_query($SQL_str));

	    if (!$other_obj) return ;
	    mysql_query("UPDATE ".$table." SET sort_id=".$other_obj['sort_id']." WHERE id=".$current_obj['id']."");
	    mysql_query("UPDATE ".$table." SET sort_id=".$current_obj['sort_id']." WHERE id=".$other_obj['id']."");
	}

// ]]] Uzerskije funkcii
//====================================================


?>