<?php 

	class voting {
		
		static function get_voting($table, $id) {
			$count = 0;
			$voting = 0;
			$mysql_res = mysql_query("SELECT * FROM _mod_votings WHERE doc_id=".$id." AND sql_table = '".$table."'");
			while ($arr = mysql_fetch_assoc($mysql_res)) {
				$voting = $voting+$arr['voting'];
				$count++;
			}
			if ($count) {
				$vertejums = number_format($voting/$count, 2);
			} else {
				$vertejums = 0;
			}
			return $vertejums;
		}
		
		static function get_visual_voting($voting) {
			$voting = ceil($voting);
			$return = '';
			if ($voting) {
				for ($i = 0; $i < $voting; $i++) {
					$return .= '<img src="images/building/nota.gif">';
				}
				return $return;
			}
		}
		
		static function set_voting($table, $id, $mark, $user = 0) {
			mysql_query("INSERT INTO _mod_votings VALUES (0, '".$table."', '".$id."', ".$user.", ".$mark.", ".time().", '".$_SERVER['REMOTE_ADDR']."')");
		}
		
		function has_voted($table, $id, $user_id = null, $ip = null){
			if ($user_id) {
				return @mysql_result(mysql_query("SELECT id FROM _mod_votings WHERE sql_table='".$table."' AND doc_id=".$id." AND user_id=".$user_id),0,0);
			} else {
				return @mysql_result(mysql_query("SELECT id FROM _mod_votings WHERE sql_table='".$table."' AND doc_id=".$id." AND ip=".$ip),0,0);
			}
		}
		
		static function draw_vote_form(){
			return '<form method="post" action="" name="" id="voting_form">
						<div id="hidden_descript" style="top:0px;left:0px;display:none">...</div>
						<input id="vertejums" name="vertejums" value="1" style="display: none;" type="text">
						<div>'.WBG::message("ocenitj_recept", null,1).':<img id="video_rating_star_1" src="images/building/nota_unact.gif" class="ratingStar" onclick="selectStars(1)" onmouseover="highlightStars(1);" onmouseout="unhighlightStars();"><img id="video_rating_star_2" src="images/building/nota_unact.gif" class="ratingStar" onclick="selectStars(2)" onmouseover="highlightStars(2);" onmouseout="unhighlightStars();"><img id="video_rating_star_3" src="images/building/nota_unact.gif" class="ratingStar" onclick="selectStars(3)" onmouseover="highlightStars(3);" onmouseout="unhighlightStars();"><img id="video_rating_star_4" src="images/building/nota_unact.gif" class="ratingStar" onclick="selectStars(4)" onmouseover="highlightStars(4);" onmouseout="unhighlightStars();"><img id="video_rating_star_5" src="images/building/nota_unact.gif" class="ratingStar" onclick="selectStars(5)" onmouseover="highlightStars(5);" onmouseout="unhighlightStars();"><input name="balsojums" class="meklet" value="'.WBG::message("ocenitj", null,1).'" style="margin-left: 20px;"  align="absmiddle" type="submit"></div>
					</form>
					<script>
							var texts_for_notes = new Array();
							texts_for_notes[1] = "'.WBG::message("ocenka_1", null,1).'";
							texts_for_notes[2] = "'.WBG::message("ocenka_2", null,1).'";
							texts_for_notes[3] = "'.WBG::message("ocenka_3", null,1).'";
							texts_for_notes[4] = "'.WBG::message("ocenka_4", null,1).'";
							texts_for_notes[5] = "'.WBG::message("ocenka_5", null,1).'";
					</script>';
		}
	}
?>