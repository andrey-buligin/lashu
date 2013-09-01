<?php
function wbg_get_top_nav(&$active_category, &$MAINMENU, &$SUBMENU, &$active_id) {
		global $_CFG;
		$X 	= 0;

		foreach ($_CFG['sections'] as $key=>$value) {
			if ($key == "wbg_starts") continue;

			if (isset($_CFG['subsections'][$key])) { // Eto submenu znachit

				$parent_id = $INDEX[$_CFG['subsections'][$key]];


				if ($active_category == $key){
					$active_id = $INDEX[$_CFG['subsections'][$key]];
					$MAINMENU[] = '<script>$default_opened_submenu_id = '.$active_id.';</script>';
					$class = ' class="active"';
				} else {
					$class = '';
				}

				$SUBMENUS[$parent_id][] = '<a href="'.$_CFG['url_to_cms'].'?section='.$key.'&lang='.$_CFG['language'].'"'.$class.'>'.$value['name'].'</a>';

			} else {

				$X++;
				if (!$active_category){
					$active_category = $key;
				}
				$INDEX[$key] = $X;
				$link = ' onclick="document.location.href=\''.$_CFG['url_to_cms'].'?section='.$key.'&lang='.$_CFG['language'].'\';"';
				if ($active_category == $key){
					$MAINMENU[] = '<div class="active"><div id="n'.$X.'" class="lvl1"'.$link.'><img src="images/top-icn-categories.gif" style="vertical-align:middle"/>'.$value['name'].'</div></div>';
					$MAINMENU[] = '<script>$default_opened_submenu_id = '.$X.';</script>';
					$active_id = $X;
				} else {
					$MAINMENU[] = '<div id="n'.$X.'" class="lvl1"'.$link.'>'.$value['name'].'</div>'."\n";
				}

				if (isset($_CFG['sublinks'][$key])){
					foreach ($_CFG['sublinks'][$key]['titles'] as $id=>$value) {
						$SUBMENUS[$X][] = '<a href="'.$_CFG['url_to_cms'].'?section='.$key.$_CFG['sublinks'][$key]['links'][$id].'">'.$value.'</a>';
					}
				}
			}
		}

		$MAINMENU = array_reverse($MAINMENU);
		$MAINMENU = implode("", $MAINMENU);

		for ($x=1; $x <= $X; $x++) {
			$SUBMENU .= '<div id="sub-'.$x.'" style="display:none">'.@implode('<img src="images/spacer.gif"/>', $SUBMENUS[$x]).'</div>'."\n";
		}

	}

?>