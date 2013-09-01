<?php
$this->textline("Banner");
$this->spacer();
?>
<?php $this->smalltext("title","Title:","60","50")?>
<?php $this->crosslink("link","Links:")?>
<?php $this->select("target","Target:",array("_blank"=>"Opens new page","_self"=>"Opens in same page"),null,"style='width:150px'");?>
<?php $this->image("foto","Image:","banners/")?>
<?php

//	$products = array();
//	$sql_res = mysql_query("SELECT * FROM _mod_products WHERE active=1 ORDER BY title_eng");
//	while ($arr = mysql_fetch_assoc($sql_res)) {
//		$products[$arr['id']] = $arr['title_eng'];
//	}
//	$this->select("product" , "Product", $products);

?>