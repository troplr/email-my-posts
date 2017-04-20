<?php
/**
 * Plugin Name: Email My Posts
 * Plugin URI: https://troplr.com/
 * Description: Allow users to share/email post via wp_mail. 
 * Version: 1.0.1
 * Author: Troplr
 * Author URI: https://troplr.com
 * Requires at least: 4.5
 * Tested up to: 4.7
 *
 * Text Domain: troplr
 *
 */

require_once('titan-framework/titan-framework-embedder.php');


add_action( 'tf_create_options', 'emp_ppstemail' );
function emp_ppstemail() {
// Initialize Titan & options here
 $titan = TitanFramework::getInstance( 'pst-email' );

 $panel = $titan->createAdminPanel( array(
'name' => 'Email My Posts',
) );

$generalTab = $panel->createTab( array(
'name' => 'Settings',
) );

$optionset = $panel->createTab( array(
'name' => 'Button Design',
) );

$optionset->createOption(  array(
'name' => 'Select Button Size',
'id' => 'my_layout',
'type' => 'radio-image',
'options' => array(
'large' => plugin_dir_url( __FILE__ ) . '/images/button1.png',
'small' => plugin_dir_url( __FILE__ ) . '/images/small.png',
'xtras' => plugin_dir_url( __FILE__ ) . '/images/xtras.png',
'blk' => plugin_dir_url( __FILE__ ) . '/images/block.png',
),
'default' => 'small',
) );

$optionset->createOption( array(
'name' => 'Button Alignment',
'id' => 'btn_algn',
'options' => array(
'1' => 'Right',
'2' => 'Left',
'3' => 'Center',
),
'type' => 'radio',
'default' => '2',
) );

$optionset->createOption(  array(
'name' => 'Button Text',
'id' => 'btn_text',
'type' => 'text',
'default' => 'Email this post',
) );

$optionset->createOption( array(
'name' => 'Button Background Color',
'id' => 'btn_background_color',
'type' => 'color',
'desc' => 'Pick a color',
'default' => '#555555',
) );

$optionset->createOption( array(
'name' => 'Button Border Color',
'id' => 'btn_border_color',
'type' => 'color',
'desc' => 'Pick a color',
'default' => '#555555',
) );



// Create options in My General Tab
$generalTab->createOption(  array(
'name' => 'Your email id',
'id' => 'myemail_id',
'type' => 'text',
'desc' => 'Make sure the email is from your same domain to avoid being marked as spam.'
) );


$generalTab->createOption( array(
'name' => 'Email Footer Message',
'id' => 'email_footermsg',
'type' => 'editor',
'desc' => 'This text will be shown as link back/signature below the content on the email sent',
'default' => 'Post shared via example.com'
) );

$generalTab->createOption( array(
'name' => 'Email success message',
'id' => 'email_success',
'type' => 'text',
'desc' => 'Success Message',
'default' => 'Thankyou for sharing the article'
) );

$optionset->createOption( array(
'name' => '',
'id' => 'pay',
'type' => 'note',
'desc' => 'You may want to support my development: <a target="_blank" href="https://paypal.me/sandeeptete">Pay a tip</a>'
) );

$generalTab->createOption( array(
'name' => '',
'id' => 'pays',
'type' => 'note',
'desc' => 'You may want to support my development: <a target="_blank" href="https://paypal.me/sandeeptete">Pay a tip</a>'
) );


$generalTab->createOption( array(
'type' => 'save'
) );

$optionset->createOption( array(
'type' => 'save'
) );

}



add_action('wp_head','emp_pstemailpost',10);
function emp_pstemailpost()
{
$titan = TitanFramework::getInstance( 'pst-email' );
$myemail_id = $titan->getOption( 'myemail_id' );


	
 // do conditional stuff here



	


}
add_action('wp_head','emp_conff',10);
function emp_conff(){
	?>
	
 <style>
            #progress { 
                display: none;
                color: green; 
            }
        </style>   

<?php
}


add_action('wp_head','emp_btn_bg_color',10);
function emp_btn_bg_color(){
	$titan = TitanFramework::getInstance( 'pst-email' );
	$btn_background_color = $titan->getOption( 'btn_background_color' );
	$btn_border_color = $titan->getOption( 'btn_border_color' );
?>
<style type="text/css">
	.btn-primary{
		background: <?php echo $btn_background_color;?>!important;
		border-color:<?php echo $btn_border_color;?>!important;
	}
	.modal-dialog {
    width: 600px;
    margin: 100px auto!important;
}
</style>
<?php
}






add_filter('wp_mail_from', 'emp_ppt_email_from');
	 
	function emp_ppt_email_from() {
	$titan = TitanFramework::getInstance( 'pst-email' );
	$myemail_id = $titan->getOption( 'myemail_id' );

	return $myemail_id;
}


add_filter('the_content', 'emp_wpptemail_before_after');
function emp_wpptemail_before_after($content) {
		$titan = TitanFramework::getInstance( 'pst-email' );
		$my_layout = $titan->getOption('my_layout');
		$btn_text = $titan->getOption('btn_text');
		$btn_algn = $titan->getOption('btn_algn');
if ($my_layout == large) {
	if ( is_singular( $post_types = 'post' ) ) {
    
    $aftercontent = '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">'
  		.$btn_text.
		'</button>';
    $content .= '<p>'.$aftercontent.'</p>';
    }
    return $content;
}

elseif ($my_layout == small) {
	if ( is_singular( $post_types = 'post' ) ) {
    
    $aftercontent = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">'
  		.$btn_text.
		'</button>';
    $content .= '<p>'.$aftercontent.'</p>';
    }
    return $content;
}

elseif ($my_layout == xtras) {
	if ( is_singular( $post_types = 'post' ) ) {
    
    $aftercontent = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">'
  		.$btn_text.
		'</button>';
    $content .= '<p>'.$aftercontent.'</p>';
    }
    return $content;
}
elseif ($my_layout == blk) {
	if ( is_singular( $post_types = 'post' ) ) {
    
    $aftercontent = '<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">'
  		.$btn_text.
		'</button>';
    $content .= '<p>'.$aftercontent.'</p>';
    }
    return $content;
}


	

}


add_action('wp_head','emp_btnn_algn',10);
function emp_btnn_algn(){
	$titan = TitanFramework::getInstance( 'pst-email' );
	$btn_algn = $titan->getOption('btn_algn');

	if ($btn_algn == 1) 
	{
		?>
	<style type="text/css">
		.btn-primary{
			float: right!important;
		}
	</style>
		<?php
	}
	elseif ($btn_algn == 2) 
	{
		?><style type="text/css">
		.btn-primary{
			float: left!important;
		}
	</style><?php
	}
	elseif ($btn_algn == 3) 
	{
		?>
		<style type="text/css">
		.btn-primary{
			margin-left: 50%!important;
		}
	</style>
	<?php
	}

}

add_filter('wp_mail_from_name', 'emp_ppt_email_from_name');
	 
	function emp_ppt_email_from_name() {
		$sender_name = strip_tags(trim($_POST["yname"]));
		$sender_name = str_replace(array("\r","\n"),array(" "," "),$sender_name);
	return $sender_name;
}

add_action('wp_footer','emp_pptemailja',10);
function emp_pptemailja()
{
	$titan = TitanFramework::getInstance( 'pst-email' );
	$email_success = $titan->getOption( 'email_success' );
	?>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php $title = get_the_title( $post_id );echo "Sending: ".$title;?></h4>
      </div>
      <div class="modal-body">
        <!-- Contact Form starts here-->
       
    	


<form class="form-horizontal" id="contactform" name="contact" role="form" method="post" action="#">

	<div class="form-group" id="name-group">
		<label for="name" class="col-sm-2 control-label">Your Name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="name" name="yname" placeholder="First & Last Name" value="">
							<span class="alert name-alert"></span>

		</div>
	</div>
	<div class="form-group" id="email-group">
		<label for="email" class="col-sm-2 control-label">Send To Email</label>
		<div class="col-sm-10">
					<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
					<span class="alert email-alert"></span>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
		

			<input id="submit" name="submit" type="submit" value="Send" class="btn btn-success" onclick="document.getElementById('progress').style.display = 'block' ;"> 
<!-- 						<button type="submit" class="btn btn-lg btn-primary">Send</button>
 -->
		</div>
	</div>
	
</form>
<div id="progress"><?php echo $email_success;?></div>
<script type="text/javascript">
	// Function Validation Form
function valForm() {

	var formMessages = $('#form-messages');

	if ($('#name').val() == '') {
		$('#name-group').addClass('has-error');
		$('#name-alert').addClass('text-danger').html('Your name is empty');

	} else {
		$('#name-group').removeClass('has-error');
		$('#name-alert').removeClass('text-danger').html('');
	}

	if ($('#email').val() === '') {
		$('#email-group').addClass('has-error');
		$('#email-alert').addClass('text-danger').html('Your email is empty');
	} else {
		$('#email-group').removeClass('has-error');
		$('#email-alert').removeClass('text-danger').html('');
	}

}
// End Function

$(function() {

	// Contact Form
    var form = $('#contactform');
    var formMessages = $('#form-messages');

	$(form).submit(function(event) {

	    event.preventDefault();
	    formMessages.html('');

	    if(valForm()){
	    	var formData = $(form).serialize();

			$.ajax({
			    type: 'POST',
			    url: $(form).attr('action'),
			    data: formData
			}).done(function(response) {

			    $(formMessages).removeClass('text-warning');
			    $(formMessages).addClass('text-success');

			    $(formMessages).text('Your message has been sent.');

			    // Clear the form.
			    $('#name').val('');
			    $('#email').val('');

			}).fail(function(data) {

			    $(formMessages).removeClass('success');
			    $(formMessages).addClass('error');

			    if (data.responseText !== '') {
			        $(formMessages).text(data.responseText);
			    } else {
			        $(formMessages).text('Oops! An error occured and your message could not be sent.');
			    }
			});
	    }

	    
	});
	// End Contact Form
});
</script>

	<!--Contact form ends here-->
	</div>
      
    </div>
  </div>
</div>

<?php
function emp_msg_footer($content){
	$titan = TitanFramework::getInstance( 'pst-email' );
	$email_footermsg = $titan->getOption( 'email_footermsg' );
	if ( is_singular( $post_types = 'post' ) ) {
    $aftercontent = $email_footermsg;
    $content .= '<p>'.$aftercontent.'</p>';
    }
    return $content;
}


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    	function emp_ppt_mail_format() {
    return 'text/html';
}
add_filter( 'wp_mail_content_type','emp_ppt_mail_format' );
        // Get the form fields and remove whitespace.
        $to = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $query = get_post(get_the_ID()); 
		remove_filter('the_content', 'emp_wpptemail_before_after');
		add_filter('the_content', 'emp_msg_footer');
		$message = apply_filters('the_content', $query->post_content).'<br>';
        $title = get_the_title( $post_id );
		$subject = $title;
        // Build the email headers.
	    $headers = 'MIME-Version: 1.0' . "\r\n";
		$headers = array('Content-Type: text/html; charset=UTF-8');
		//$headers .= 'From: '. $name .' <"'. $email .'">' . "\r\n";
        // Build the email content.
                // Send the email.
        if (wp_mail($to, $subject, $message, $headers)) {
        	remove_filter('wp_mail_from', 'emp_ppt_email_from');
remove_filter('wp_mail_from_name', 'emp_ppt_email_from_name');
remove_filter('the_content', 'emp_msg_footer');
            // Set a 200 (okay) response code.
            http_response_code(200);
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
        }
	}
}
?>