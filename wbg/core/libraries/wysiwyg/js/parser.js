//======================================================================================
// [[[ Settings

	var $TAGS_TO_REMOVE = new Array();
	var	$CUSTOM_TAGS_ATTR_ALLOWED 	= new Object();


	// Eto attributi kotorije mi voobshe ne chistim
	// !!!!!!! ; v nachale i konce stroki objazatelni
	var $ALLOWED_ATTRIBUTES_GLOBAL = ";rowspan;colspan;src;hspace;vspace;align;";

	// Eto Tagi kotorije nuzhno vichishatj
	$TAGS_TO_REMOVE.push("font");
	$TAGS_TO_REMOVE.push("o:p");

	// Eto attributi kotorije nuzhno ostavitj dlja opredelennih tegov
	$CUSTOM_TAGS_ATTR_ALLOWED.img 	= ";width;height;";
	$CUSTOM_TAGS_ATTR_ALLOWED.a 	= ";href;target;";



// ]]] Settings
//======================================================================================
// [[[ Glavnije funkcii

	function MyFilter() {
		mainframe = window.frames[0].window;
		if (mainframe.document.body.all){
			b=mainframe.document.body.all;
			for(i=b.length-1;i>=0;i--)
				if(b[i].scopeName!='HTML')
					b[i].removeNode();
		}
		parse_for_FF();
		re_render_document();
	}

	function re_render_document() {
		code = mainframe.document.body.innerHTML;
		mainframe.document.body.innerHTML = code;
	}

// ]]] Glavnije funkcii
//======================================================================================
// [[[ Sama Obrabotka

	function parse_for_FF(){
		$need_to_remove = new Array();
		$elements = mainframe.document.body.getElementsByTagName("*");
		var $counter = $elements.length;
		for (var $x=0; $x < $counter; $x++) {
			_remove_attributes($elements[$x]);

		}
		_parse_tables(mainframe.document.body.getElementsByTagName("TABLE"));
		_clear_tags($elements[$x]);
	}

	function _clear_tags($object){
		while($tag = $TAGS_TO_REMOVE.pop()){
			_clear_one_tag($tag);
		}
	}
	function _clear_one_tag($tagname){
		$elements = mainframe.document.body.getElementsByTagName($tagname);
		var $counter = $elements.length;
		for (var $x=0; $x < $counter; $x++) {
			var $newDiv = mainframe.document.createElement("SPAN");
			$newDiv.innerHTML = "wbgwbgwbgwbgwbgwbgwbgwbgwbg";

			var $tempHTML = $elements[$x].innerHTML;
			var $container = $elements[$x].parentNode;

			$container.replaceChild($newDiv, $elements[$x]);
			$container.innerHTML = $container.innerHTML.replace("<SPAN>wbgwbgwbgwbgwbgwbgwbgwbgwbg</SPAN>", $tempHTML);
			$container.innerHTML = $container.innerHTML.replace("<span>wbgwbgwbgwbgwbgwbgwbgwbgwbg</span>", $tempHTML);
			_clear_one_tag($tagname); // Posle zameni u nas nevhlebennij sdvig DOMA. poetomu prosto zanovo zapuskajem funkciju
			return;
		}
	}


	/**
	*	Otparshivajem tablici.
	*/
	function _parse_tables($tables){
		var $counter = $tables.length;
		for (var $x=0; $x < $counter; $x++) {
			//--------------------------------------------------------------------------------------
			// [[[ Removing COL

				_remove_tags($tables[$x], "COL");
				_remove_tags($tables[$x], "COLGROUP");

			// ]]] Removing COL
			//--------------------------------------------------------------------------------------

			$tables[$x].className = "wbgTable";
			$firstChild = $tables[$x];
			while($firstChild = $firstChild.firstChild){
				if (!$firstChild.tagName) { // Skipajem TEXT nodi v FF
					$firstChild = $firstChild.nextSibling;
				}
				if ($firstChild.tagName == "TR"){
					$firstChild.className = "wbgFirstRow";
					break;
				}
			}
		}
	}

	/**
	*	Ubivajet ukazannij tag. Sovsem.
	*	@param object $object. DOM objekt vnutri kotorogo nuzhno ubitj tagi
	*	@param string $tag. Sobstvenno tag kotorij nuzhno ubitj. "A" naprimer
	*/
	function _remove_tags($object, $tag){
		var $elements = $object.getElementsByTagName($tag);
		var $counter = $elements.length;
		for (var $x=0; $x < $counter; $x++) {
			$elements[$x].parentNode.removeChild($elements[$x]);
		}
	}

	/**
	*	Udaljajet attributi u objekta
	*	@param object $element. Dom objekt.
	*/
	function _remove_attributes($element){

		// Vse klassy nachinajushijesja na wysiwyg - sistemnije. Ih nuzhno ostavitj kak estj.
		$reg = new RegExp("^wysiwyg","gi");
		if ($reg.test($element.className)){
			return;
		}

		var $attributes_to_remove = new Array("className"); // ClassName - eto dlja IE. on ne chistit class

		// Opredeljajem tag i te attributi kotorije nuzhno ostavitj dlja etogo taga
		// Replace : na "" sdelan dlja Dolbannih IE tegov o:p naprimer , tak kak inache budet Js error
		eval("var $ALLOWED_ATTRIBUTES_FOR_TAG = $CUSTOM_TAGS_ATTR_ALLOWED."+$element.tagName.toLowerCase().replace(":",""));

		var $attributes = $element.attributes;
		var $a_counter 	= $attributes.length;
		if ($a_counter == 0) return;

		for (var $y=0; $y < $a_counter; $y++) {

			//--------------------------------------------------------------------------------------
			// [[[ Smotrim kakije attributi ostavitj

				var $reg = new RegExp(";"+($attributes[$y].name.toLowerCase())+";","gi");
				if ($reg.test($ALLOWED_ATTRIBUTES_GLOBAL)){continue;}
				if ($reg.test($ALLOWED_ATTRIBUTES_FOR_TAG)){continue;}

			// ]]] Smotrim kakije attributi ostavitj
			//--------------------------------------------------------------------------------------

			$attributes_to_remove.push($attributes[$y].name);
		}

		while($attribute = $attributes_to_remove.pop()){
			$element.removeAttribute($attribute);
		}
	}

// ]]] Sama Obrabotka
//======================================================================================