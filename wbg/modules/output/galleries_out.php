<?php


/*=======================================================================*/

$return_from_module = '<div id="galleryContainer">
							<div style="padding:20px 0 0 25px">
								'.showGalleries().'
							</div>
						</div>';

/*=======================================================================*/
// [[[ galleries
				
	function showGalleries(){
		global $web;
		
		$cat     = $web->active_category;
		$gallery = '';
		$text    = '';
		$sql_res = mysql_query("SELECT * FROM _mod_galleries WHERE active=1 AND category_id=".$cat." ORDER BY sort_id ASC");
		while ($arr = mysql_fetch_assoc($sql_res)) {
			
			$content = unserialize($arr['content']);
			if ($content['imgSmall']){
				$alt = $content['title'];
				$gallery .= 
				'<li><a href="images/'.$content['imgBig']['src'].'" rel="gr" class="group" title="'.$alt.'">'.WBG_HELPER::insertImage($content['imgSmall'], '').'</a></li>'."\n";
			}		
			$js[] = "({url: 'images/".$content['imgSmall']['src']."', desc: '".$alt."'})";
		}
		
		if ($gallery) {
			
			$js = '<script type="text/javascript">
					var mycarousel_itemList = ['."\n".implode(",\n", $js)."\n];\n".'
					</script>';
//		$js = "<script type=\"text/javascript\">
//				var mycarousel_itemList = [
//			    {url: 'http://static.flickr.com/66/199481236_dc98b5abb3_s.jpg', title: 'Flower1'},
//			    {url: 'http://static.flickr.com/75/199481072_b4a0d09597_s.jpg', title: 'Flower2'},
//			    {url: 'http://static.flickr.com/57/199481087_33ae73a8de_s.jpg', title: 'Flower3'},
//			    {url: 'http://static.flickr.com/77/199481108_4359e6b971_s.jpg', title: 'Flower4'},
//			    {url: 'http://static.flickr.com/58/199481143_3c148d9dd3_s.jpg', title: 'Flower5'},
//			    {url: 'http://static.flickr.com/72/199481203_ad4cdcf109_s.jpg', title: 'Flower6'},
//			    {url: 'http://static.flickr.com/58/199481218_264ce20da0_s.jpg', title: 'Flower7'},
//			    {url: 'http://static.flickr.com/69/199481255_fdfe885f87_s.jpg', title: 'Flower8'},
//			    {url: 'http://static.flickr.com/60/199480111_87d4cb3e38_s.jpg', title: 'Flower9'},
//			    {url: 'http://static.flickr.com/70/229228324_08223b70fa_s.jpg', title: 'Flower10'}
//			];
//			</script>";

			return '<ul id="mycarousel" style="visibility:hidden" class="jcarousel-skin-my">'.$gallery.'</ul>'.$text;
			
		} else {
			return '<div style="font-size:14px; letter-spacing:3px; font-weight:bold; color:white">Sorry, gallery is empty!</div>';
		}
	}
	
// ]]] galleries
/*=======================================================================*/	
?>