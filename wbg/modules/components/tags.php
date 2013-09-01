<?php 

global $_CFG;

Class Tags
{
	var $TAG_TABLE;
	
	function __construct()
	{
		global $_CFG;
		$this->TAG_TABLE = "_mod_tags";
	}
	
	function createTags( $tags, $table, $objId )
	{
		$tags  = $this->stringToArray( $tags );
		if (is_array($tags))
		{
			foreach ($tags as $tag) {
				$query = "INSERT INTO ".$this->TAG_TABLE." SET  tag	  = '".mysql_escape_string($tag)."',
																sql_table = '".mysql_escape_string($table)."', 
																obj_id = ".mysql_escape_string($objId);
				mysql_query( $query );
			}
		}
	}
	
	function stringToArray( $tagString )
	{
		$tagArray = explode(",", $tagString);
		if ( $tagArray AND !empty($tagArray[0]))
		{
			foreach ($tagArray as $index => $tag) {
				$tagArray[$index] = trim(strip_tags($tag));
			}
			return $tagArray;
		}
	}
	
	function updateTags( $oldTags, $NewTags, $table, $objIdss)
	{
		$oldTagsArr = $this->stringToArray( $oldTags );
		$newTagsArr = $this->stringToArray( $NewTags );
		$query = mysql_escape_string("UPDATE ".$this->TAG_TABLE." WHERE sql_table='".$table."' AND obj_id=".$objId);
		mysql_query( $query );
	}
	
	function deleteTagsByObjId( $table, $objId ) 
	{
		$query = "DELETE FROM ".$this->TAG_TABLE." WHERE sql_table='".$table."' AND obj_id=".$objId;
		$res   = mysql_query( $query );
	}
	
	function deleteTag( $tag = '', $table = '', $objId = '' ) 
	{
		$query = "DELETE FROM ".$this->TAG_TABLE." WHERE tag='".$objId."'";
		if ( $table ) $query .= " AND sql_table='".$table."'";
		if ( $objId ) $query .= " AND obj_id='".$objId."'";
		mysql_query( $query );
	}
	
	function getTagsCloud( $table, $limit = 30 )
	{
		$cloud = array();
		$cloudOut= '';
		$maximum = 0;
		
		$query = "SELECT count(*)as counter,tag FROM ".$this->TAG_TABLE." WHERE sql_table='".$table."' GROUP BY tag ORDER BY counter DESC LIMIT ".$limit;
		$res   = mysql_query( $query );
		while ( $row = mysql_fetch_assoc( $res ))
		{
			$tag 	 = $row['tag'];
    		$counter = $row['counter'];
		    if ($counter > $maximum) $maximum = $counter;
		    $cloud[] = array('tag' => $tag, 'counter' => $counter);
		}
		shuffle( $cloud );
		
		foreach ($cloud as $k) // start looping through the tags
		{
		    $percent = floor(($k['counter'] / $maximum) * 100);
		   
		    if ($percent <20)
		    {
		        $class = 'smallest';
		    } elseif ($percent>= 20 and $percent <40) {
		        $class = 'small';
		    } elseif ($percent>= 40 and $percent <60) {
		        $class = 'medium';
		    } elseif ($percent>= 60 and $percent <80) {
		        $class = 'large';
		    } else {
		        $class = 'largest';
		    }
		   
		    $cloudOut .= '<span class="'.$class.'"><a href="'.WBG::crosslink(WBG::mirror( 46 )).'?tag='.urlencode($k['tag']).'">'.$k['tag'].'</a></span>'."\n";
		}

		return $cloudOut;
	}
	
	function getTagCount( $tag )
	{
		$query = "SELECT count(*) FROM ".$this->TAG_TABLE." WHERE tag LIKE '%".$tag."%'";
		$res   = mysql_result(mysql_query( $query ), 0, 0);
		return $res;
	}
	
	function getObjectsByTag( $tag )
	{
		$fetchedObjects = array();
		$query = "SELECT * FROM ".$this->TAG_TABLE." WHERE tag LIKE '%".$tag."%'";
		$res   = mysql_query( $query );
		while ($arr = mysql_fetch_assoc($res)) {
			$fetchedObjects[] = $arr;
		}
		return $fetchedObjects;
	}
}

?>