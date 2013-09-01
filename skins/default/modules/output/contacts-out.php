<h1 class="page-title"><?php echo WBG_HELPER::insertCatTitle() ?></h1>
<?php

	global $_CFG;
	global $web;

	include_once( $_CFG['path_to_modules'].'components/validation.php');

	$data = @unserialize( file_get_contents( $_CFG['path_to_modules'].'input/onetext/__saved_data_'.$web->active_category) );
	if ($data['text'])
	{
		$imageMap = WBG_HELPER::insertImage($data['text_img'], ' class="f-left" ');
		echo WBG_HELPER::transferToXHTML('
			<div class="page-text clear-block">
				'.($data['title'] ? '<h2>'.$data['title'].'</h2>': '').'
				'.($data['text_img'] ? WBG_HELPER::insertImage($data['text_img'], 'class="f-left"', null, 1) : '').
				$data['text'].'
			</div>');
	}
?>

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
		<?php mail('surfer@inbox.lv', 'Contact form', print_r($_POST, 1));?>
		<div id="error" class="valid">
			<strong>Thanks for submiting the form!</strong> I will get back to you soon.</li>
		</div>
<?endif?>

<form method="post" id="customForm" action="">
	<div>
		<label for="name">Name</label>
		<input id="name" name="name" type="text" />
		<span id="nameInfo">Your name</span>
	</div>
	<div>
		<label for="email">E-mail</label>
		<input id="email" name="email" type="text" />
		<span id="emailInfo">Valid E-mail address</span>
	</div>
	<div>
		<label for="message">Message</label>
		<textarea id="message" name="message" cols="" rows=""></textarea>
	</div>
	<div>
		<input id="send" name="send" type="submit" value="Send" />
	</div>
</form>
<script type="text/javascript" src="js/validation.js"></script>