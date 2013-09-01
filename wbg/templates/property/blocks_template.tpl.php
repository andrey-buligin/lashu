<?php

global $_CFG;

//add repeatable dropdown with available blocks to show on current page
$this->textline('Page blocks');
$description = ' (e.g. "show / hide" custom blocks on article and text pages )';
$data = $this->checkbox("show_blocks", null).$description;
$this->make_container($data,"Show blocks", "style='background:#f2cf8f'");
$this->select("blocks_layout","Blocks layout:", array( 1 => 'wide left side', 2 => 'wide right side') , null, "style='width:150px'");
$blocks     = array();
$skinBlocks = $_CFG['blockManager']->getSkinBlocks();
foreach ( $skinBlocks as $blockId => $block)
{
    $blocks[$blockId] = str_replace('_', ' ', $block['title']);
}
$this->start_repeat_block("List of left hand side blocks", "Blocks");
    echo "Option eng:" . $this->select("blocks_left", null, $blocks);
$this->end_repeat_block(); 
$this->start_repeat_block("List of right hand side blocks", "Blocks");
    echo "Option eng:" . $this->select("blocks_right", null, $blocks);
$this->end_repeat_block();
?>