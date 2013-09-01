<?php
$this->textline('Page title and meta data :: Search Engine Optimisation (SEO)');
$this->tr('', " All mentioned fields are used for certain page SEO improvement. 
				More detailed description you provide in these fields -<br/> 
				better Search Engine Results Page(SERP) you can get.
				Not providing all these fields is a missed opportunity<br/>to get your page displayed on first pages of Search Engines like Google, Yahoo");
$this->insert_after_object = " Page Title is also displayed in browser's top bar";
$this->smalltext("title", "Page Title", 62);
$this->textarea("desciption", "Meta Desciption", 60, 5);
$this->textarea("keywords", "Meta Keywords", 60, 5);
?>