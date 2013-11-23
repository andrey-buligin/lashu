<!-- Contact Section -->
<div id="contacts" class="page">
<div class="container">
    <!-- Title Page -->
    <div class="row">
        <div class="span12">
            <div class="title-page">
                <h2 class="title">Get in Touch</h2>
                <h3 class="title-description">There are several ways to contact us</h3>
                <div class="page-description">
                    <?php WBG::message("contacts");?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Title Page -->
    
    <!-- Contact Form -->
    <div class="row">
    	<div class="span4">
        
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
					$header = "From: www.ladylash.co.uk <omgbeautybyhanna@gmail.com>\r\n";
					mail(WBG::message('mailto', null, 1), 'Contact form', print_r($_POST, 1), $header );
					//mail('surfer@inbox.lv', 'Contact form', print_r($_POST, 1), $header );
				?>
				<div id="error" class="valid">
					<strong>Thanks for submiting the form!</strong> I will get back to you soon.</li>
				</div>
			<?endif?>

        	<form id="contact-form" class="contact-form" method="post">
            	<p class="contact-name">
            		<input id="name" type="text" placeholder="Full Name" value="" name="name" />
                </p>
                <p class="contact-email">
                	<input id="email" type="text" placeholder="Email Address" value="" name="email" />
                </p>
                <p class="contact-message">
                	<textarea id="message" placeholder="Your Message" name="message" rows="10" cols="40"></textarea>
                </p>
                <p class="contact-submit">
                	<input id="contact-submit" class="submit" name="send" type="submit" value="Send Your Email" />
                </p>
                
                <div id="response">
                
                </div>
            </form>
         
        </div>   	

        <div class="span4">
        
        	<div id="googleMap">
	 			<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php WBG::message('googleMapLink');?>"></iframe>
				<div style="padding-bottom: 10px"><a target="_blank" href="<?php WBG::message('googleMapLinkToLargeMap');?>">View in a larger map</a></div>
        	</div>

        </div>
        
        <div class="span4">
        	<div class="row-fluid">
	        	<div class="span6 contact-details">
	                <?php
					global $_CFG;
					global $web;

					$contactsCatId = 9;

					include_once($_CFG['path_to_modules'].'components/validation.php');

					$data = @unserialize( file_get_contents( $_CFG['path_to_modules'].'input/onetext/__saved_data_'.$contactsCatId) );
					echo $data['text'];
					?>
	            </div>
	            <div class="span6 contact-details working-hours">
		        	<?php WBG::message('working_hours');?>
		        </div>
	        </div>
        </div>

    </div>
    <!-- End Services Form -->
</div>
</div>
<!-- End Contact Section -->


<!-- <form method="post" id="customForm" action="">
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
</article> -->
<?php

	/*$devFiles = array('plugins/validation.js', 'skins/hanna/contacts.js');
	$minFiles = 'skins/hanna/contacts.min.js';

	$_CFG['currentLayout']->requireJsFiles($devFiles, $minFiles);*/
?>
