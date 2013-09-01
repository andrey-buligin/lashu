<?php
$this->smalltext("title","Title",60);
$this->datums("date","Date");
$this->smalltext("time","Time", 10);

$this->textarea("lead","Lead text",70,3,90,10);
$this->wysiwyg("lead",600,500);
$this->image("lead_img","Image for list","text/", "Any x Any:1;200x:1:text/");//346x216pxl
$this->textarea("text","Text",90,10, 90, 10);
$this->wysiwyg("text",600,500);
$this->image("text_img","Image for text","text/", "Any x Any:1;350x:1:text/");
$this->textarea("embed","Embed",50,4,90,10);

$this->textline('Images gallery');
$this->spacer();
@$this->image_block("images", "Images", "text_gallery/", 2);
$this->spacer();

$this->textline('Resources');
$this->smalltext("tags","Tags",60);
$this->start_repeat_block("Related links", "Link name / Link code / Link type / How to open");
echo $this->smalltext("linkTitle",null,20);
echo $this->smalltext("LinkCode",null,20);
echo $this->crosslink_alone("LinkType");
echo $this->select("LinkTarget",null,array("1"=>"_blank","2"=>"_self"),null,"style='width:80px'");
$this->end_repeat_block();
$this->fileblock("docs","Related files","text/");