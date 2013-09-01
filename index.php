<?php
/**
 * Start file for parsing any (almost) Web-Gooroo public output
 *
 * !!! Menjaja chto-to tut pomni chto etot fail v RPC situacii includitsa v my_rpc/_get_module.php
 * 	i tam ruchkami generitsa imenno $_SERVER['REDIRECT_URL']
 *
 */

//======================================================================================
// [[[ Main includes

	if (!@include_once(dirname(__FILE__)."/wbg/config/config.php")){
		// Making install
		require_once(dirname(__FILE__).'/wbg/core/libraries/install_system/install.php');
		exit;
	}
	require_once($_CFG['path_to_cms']."core/libraries/output.class/output.class.php");

// ]]] Main includes
//======================================================================================
// [[[ Obrabotka URLa kotorij hochet poluchitj browser

	//If is active (website under construction page-> always redirect to it)
	$siteUnderConstructionNodeId = 17;
	if ( $websiteIsUnderConstruction = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_tree_categories WHERE id=$siteUnderConstructionNodeId AND enabled=1 AND active=1")) )
	{
	    $category = $websiteIsUnderConstruction;
	    //create holdingpage layout
	}
	else
	{
    	//obrabotka URL dlja
    	$catalogTitle = 'portfolio';

        if ( preg_match('/[site\/]+[lat|eng|rus]+\/'.$catalogTitle.'\/(.+?)/', @$_SERVER['REDIRECT_URL']) OR
    	     preg_match('/[site\/]+[lat|eng|rus]+\/(.+?)-B[0-9]+\.html/', @$_SERVER['REDIRECT_URL']) OR
             preg_match('/[site\/]+[lat|eng|rus]+\/'.$catalogTitle.'-C'.$_CFG['portfolio_folder_id'].'/', @$_SERVER['REDIRECT_URL']))
    	{
    	    $catsUrl = preg_replace('/[site\/]+[lat|eng|rus]+\/'.$catalogTitle.'/', '', $_SERVER['REDIRECT_URL']);
    		$cats = explode("/", $catsUrl);

            if ( preg_match('/[site\/]+[lat|eng|rus]+\/'.$catalogTitle.'-C'.$_CFG['portfolio_folder_id'].'/', @$_SERVER['REDIRECT_URL']) )
            {
                $lastCat = $_CFG['portfolio_folder_id'];
                $cats = Array();
            }
        	elseif ( !preg_match('/[site\/]+[lat|eng|rus]+\/(.+?)-B[0-9]+\.html/', @$_SERVER['REDIRECT_URL']) )
    		{
    			if (preg_match("/-P([0-9]+).html/", $catsUrl, $objId)) {
    				//bil ukazan object
    				$_GET['obj_id'] = $objId[1];
    				array_pop($cats);
    			}
    			array_shift($cats);
    			foreach ($cats as $key => $cat) {
    				if ($cat) {
    					$cat = preg_match("/-C([0-9]+)/", $cat, $catId);
                        if ( $catId ) {
                            $web->objCats[] = $catId[1];
                            $lastCat        = $catId[1];
                        }
    				}
    			}
    		}
            elseif (preg_match("/-B([0-9]+).html/", $catsUrl, $objId))
            {
				$blogId = $objId[1];
				if ($object = @mysql_fetch_assoc( mysql_query("SELECT * FROM _mod_textlist WHERE id=".$blogId)) )
				{
					$lastCat = $object['category_id'];
					$_GET['doc'] = $object['id'];
				}
    		}

    		if (!session_start()) session_start();
    		$_GET['portfolio_cats'] = $cats;
    		$_GET['wbg_cat'] = $lastCat;
    		if ( isset($_SESSION[$_CFG['path_url_full']]['last_category_lang']) )
    		    $_GET['lang'] = $_SESSION[$_CFG['path_url_full']]['last_category_lang'];
    	}

    	if ( !isset($_GET['wbg_cat']) )
    	{
    		$REQUEST_URI  = preg_replace("!^".$_CFG['path_url']."(.*)!si","$1", @$_SERVER['REDIRECT_URL']);
    		$REQUEST_URI  = preg_replace("![^/]+\\.(php|html|htm|php5)!si" , "" , $REQUEST_URI);

    		if (substr($REQUEST_URI,-1,1) != "/"){
    			$REQUEST_URI .= "/";
    		}

    		if ($REQUEST_URI == $_CFG['path_url'] OR $REQUEST_URI == '/'){ // Eto znachit uzer zashel na startovuju stranicu saita
    			$category = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_tree_categories WHERE id='".$_CFG['START_CAT']."'"));
    		} else {
    			$category = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_tree_categories WHERE dir='".$REQUEST_URI."'"));
    		}
    	} else {
    		$category = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_tree_categories WHERE id='".(int)$_GET['wbg_cat']."'"));
    	}
	}

// ]]] Obrabotka URLa kotorij hochet poluchitj browser
//======================================================================================
// [[[ Generim uzhe sam output

	$web = new output ($category, @$_GET['lang']);

	if (!defined("NO_OUTPUT")){ 	// Estj mehanizmi kotorije includjat etot index.php no im ne nuzhen output v standartnom vide
									// tak kak oni pered outputom naprimer dolzhni peredatj to-se v sistemu. Naprimer my_rpc/_get_module.php
		$web->make_output();
	}

// ]]] Generim uzhe sam output
//======================================================================================
?>