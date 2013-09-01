<?php
	
	
	/*************************************************************************************/
	
		function getDayOfWeek($date, $prefix = '') {
			$diena = date("N",$date);
			switch ($diena) {
			case 1 : {
				$diena = WBG::message("pirmdiena" , null, 1);
				break;
			}		
			case 2 : {
				$diena = WBG::message("otrdiena" , null, 1);
				break;
			}		
			case 3 : {
				$diena = WBG::message("tresdiena" , null, 1);
				break;
			}		
			case 4 : {
				$diena = WBG::message("ceturtdiena" , null, 1);
				break;
			}		
			case 5 : {
				$diena = WBG::message("peiktdiena" , null, 1);
				break;
			}		
			case 6 : {
				$diena = WBG::message("sestdiena" , null, 1);
				break;
			}		
			case 7 : {
				$diena = WBG::message("svetdiena" , null, 1);
				break;
			}
			}
			return $diena;
		}
	
	/*************************************************************************************/
	
		function initMonths($prefix = null) {
			$array_of_months = array(
				9  => WBG::message("septembris", null, 1),
				10 => WBG::message("oktobris", null, 1) ,
				11 => WBG::message("novembris", null, 1),
				12 => WBG::message("decembris", null, 1),
				1 => WBG::message("janvaris", null, 1),
				2 => WBG::message("februaris", null, 1),
				3 => WBG::message("marts", null, 1),
				4 => WBG::message("aprilis", null, 1),
				5 => WBG::message("majs", null, 1),
				6 => WBG::message("junijs", null, 1),
				7 => WBG::message("julijs", null, 1),
				8 => WBG::message("augusts", null, 1));	
			return $array_of_months;
		}
	
	/*************************************************************************************/
		
		function init_dienas() {

			$array_of_dienas = array(
				1 => WBG::message("pirmdiena", null, 1),
				2 => WBG::message("otrdiena", null, 1),
				3 => WBG::message("tresdiena", null, 1),
				4 => WBG::message("ceturtdiena", null, 1),
				5 => WBG::message("piektdiena", null, 1),
				6 => WBG::message("sestdiena", null, 1),
				7 => WBG::message("svetdiena", null, 1));
			return $array_of_dienas;
		}
	
	/*************************************************************************************/
?>