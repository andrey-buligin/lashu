<article class="clearfix">
<header><h1><?php echo WBG_HELPER::insertCatTitle() ?></h1></header>
<aside id="googleMap">
	<!-- <iframe width="350" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.uk/maps?hl=en&amp;sig=ycO&amp;ie=UTF8&amp;q=beauty++by+hanna&amp;fb=1&amp;gl=uk&amp;cid=0,0,18193410473570611342&amp;t=m&amp;ll=51.524125,-0.161533&amp;spn=0.009345,0.01502&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
	<div style="padding-bottom: 10px"><a target="_blank" href="http://maps.google.co.uk/maps?hl=en&amp;sig=ycO&amp;ie=UTF8&amp;q=beauty++by+hanna&amp;fb=1&amp;gl=uk&amp;cid=0,0,18193410473570611342&amp;t=m&amp;ll=51.524125,-0.161533&amp;spn=0.009345,0.01502&amp;z=15&amp;iwloc=A&amp;source=embed">View in a larger map</a></div>
	--><?php

		global $_CFG;
		global $web;

		include_once( $_CFG['path_to_modules'].'components/validation.php');

		$data = @unserialize( file_get_contents( $_CFG['path_to_modules'].'input/onetext/__saved_data_'.$web->active_category) );
		echo $data['text'];
	?>
</aside>


<?if( isset($_POST['send']) && (!validateName($_POST['name']) || !validateEmail($_POST['email']) || !validateMessage($_POST['message']) ) ):?>
		<div id="error">
			<ul>
				<?if(!validateName($_POST['name'])):?>
					<li><strong>Invalid Name:</strong> Please type name with more than 2 letters!</li>
				<?endif?>
				<?if(!validateEmail($_POST['email'])):?>
					<li><strong>Invalid E-mail:</strong> Please type name with more than 2 letters!</li>
				<?endif?>
				<?if(!validateMessage($_POST['message'])):?>
					<li><strong>Ivalid message:</strong> Please type a message with at least with 10 letters</li>
				<?endif?>
			</ul>
		</div>
	<?elseif(isset($_POST['send'])):?>
		<?php
			$header = "From: www.beautybyhanna.com <omgbeautybyhanna@gmail.com>\r\n";
			mail(WBG::message('mailto', null, 1), 'Contact form', print_r($_POST, 1), $header );
			//mail('surfer@inbox.lv', 'Contact form', print_r($_POST, 1), $header );
		?>
		<div id="error" class="valid">
			<strong>Thanks for submiting the form!</strong> I will get back to you soon.</li>
		</div>
<?endif?>

<form method="post" id="customForm" action="">
	<div>
		<label for="name">Name</label>
		<input id="name" name="name" type="text" />
		<span id="nameInfo"></span>
	</div>
	<div>
		<label for="email">E-mail</label>
		<input id="email" name="email" type="text" />
		<span id="emailInfo"></span>
	</div>
	<div>
		<label for="message">Message</label>
		<textarea id="message" name="message" cols="" rows=""></textarea>
	</div>
	<div>
		<input id="send" name="send" type="submit" value="Send" />
	</div>
</form>
</article>
<?php

	/*$devFiles = array('plugins/validation.js', 'skins/hanna/contacts.js');
	$minFiles = 'skins/hanna/contacts.min.js';

	$_CFG['currentLayout']->requireJsFiles($devFiles, $minFiles);*/
?>
