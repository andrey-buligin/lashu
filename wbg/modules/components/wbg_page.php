<?php 

class WBG_Page
{
   private $data = array();
   private $properties = array();
   
   function __construct( $pageId )
   {
       global $web;
       if ( isset( $web->category_data[$web->active_category] ) )
       {
           foreach ( $web->category_data[$web->active_category] as $name => $value )
           {
               $this->data[$name] = $value;
               if ( $name == 'properties' AND $value )
               {
                   $this->properties = unserialize( $value );
               }
           }
       }
   }
   
	/**
	 * Magick set method
	 * 
	 * @param string $param
	 * @param unknown_type $value
	 */
	public function __set( $param, $value )
	{
        $this->data[$param] = $value;
    }

    /**
     * Magick get method
     * 
     * @param string $param
     */
    public function __get( $param )
    {
        if ( array_key_exists( $param, $this->data ) )
        {
            return $this->data[$param];
        } else {
            //error logging;
        }
    }
    
    public function showBlocks()
    {
        if ( isset($this->properties['show_blocks']) )
            return $this->properties['show_blocks'];
        else 
            return $this->show_blocks;//not showing blocks by default.
    }
    
    public function getBlocksLayout()
    {
        if ( isset($this->properties['blocks_layout']) )
            return $this->properties['blocks_layout'];
    }
    
    public function getLeftBlocks()
    {
        if ( isset($this->properties['blocks_left']) )
            return $this->properties['blocks_left'];
    }
    
    public function getRightBlocks()
    {
        if ( isset($this->properties['blocks_right']) )
            return $this->properties['blocks_right'];
    }
    
}
?>