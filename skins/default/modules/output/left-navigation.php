<?php

//======================================================================================
// [[[ Konfiguracija

    global $web;
	$CFG['start_level'] 	= 1; // Eto s kakogo urovnja mi nachinajem otrabativatj derevo. 0 - samij pervij
	$CFG['levels_total'] 	= 1; // Eto naskoljko mi uglubimsa v derevo. minimalno 1 urovenj
	
// ]]] Konfiguracija
//======================================================================================
// [[[ Logika
	
	//pokazivaem navigaciju
	$root_category = $web->active_tree[1];
	$HTML_out = NAV_Generate_HTML($root_category, $CFG['start_level'], $CFG['levels_total'], true);	
	if ($HTML_out) {
		$return_from_module = '<div id="navigation-left"><ul class="menu">'.$HTML_out.'</ul>'."\n</div>";
	}

// ]]] Logika
//======================================================================================
?>