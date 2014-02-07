<?php
$your_email ='royrutto@gmail.com';// <<=== update to your email address

session_start();
$errors = '';
$name = '';
$visitor_email = '';
$user_message = '';

if(isset($_POST['submit']))
{
	
	$name = $_POST['name'];
	$visitor_email = $_POST['email'];
	$user_message = $_POST['message'];
	///------------Do Validations-------------
	if(empty($name)||empty($visitor_email))
	{
		$errors .= "\n Name and Email are required fields. ";	
	}
	if(IsInjected($visitor_email))
	{
		$errors .= "\n Bad email value!";
	}
	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$errors .= "\n The captcha code does not match!";
	}
	
	if(empty($errors))
	{
		//send the email
		$to = $your_email;
		$subject="Contact Form for Roy Rutto";
		$from = $your_email;
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		
		$body = "A user  $name submitted the contact form:\n".
		"Name: $name\n".
		"Email: $visitor_email \n".
		"Message: \n ".
		"$user_message\n".
		"IP: $ip\n";	
		
		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $visitor_email \r\n";
		
		mail($to, $subject, $body,$headers);
		
		header('Location: thank-you.html');
	}
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?>
<!DOCTYPE html>
<!-- saved from url=(0065)http://twitter.github.io/bootstrap/examples/marketing-narrow.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Roy Rutto - Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   	<meta name="description" content="Roy Rutto's Official Website. A Software Developer and Musician based in Kenya.">
   	<meta name="author" content="Roy Rutto">

    <!-- Le styles -->
    <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	 <link href="./css/docs.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 785px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
      .muted{
		  float:right;
		  margin-right:150px;
		  margin-top:50px;
	  }
	  
	 body {
		font-family: Ubuntu, sans-serif;
	 }
	 .err
		{
	 	color: red;
		}

    </style>
    <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
	<link rel="shortcut icon" href="./favicon.ico">
  </head>

  <body>

    <div class="container-narrow">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li><a href="index.html">About</a></li>
          <li><a href="resume.html">Resume</a></li>
          <li><a href="portfolio.html">Portfolio</a></li>
          <li class="active"><a href="contact.php">Contact</a></li>
        </ul>
          <a href="index.html"><img class="img-circle" data-src="holder.js/140x140" alt="Roy Rutto" style="width: 140px; height: 140px;" src="./images/Roy-Rutto.jpg">
        <h1 class="muted">Roy Rutto</h1></a>
      </div>

      <hr>

        <!-- Jumbotron -->
        <p>
        Drop me a message here and I'll be glad to get back to you.
        </p>
        
      
        <?php
if(!empty($errors)){
echo "<p class='err'>".nl2br($errors)."</p>";
}
?>
<div id='contact_form_errorloc' class='err'></div>
<form method="POST" name="contact_form" class="form-horizontal"
action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"> 
<div class="control-group">
    <label class="control-label" for="inputName">Name:</label>
    <div class="controls">
      <input type="text" name="name" id="name" placeholder="Name" value='<?php echo htmlentities($name) ?>'>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputEmail">Email:</label>
    <div class="controls">
      <input type="text" name ="email" id="email" placeholder="Email" value='<?php echo htmlentities($visitor_email) ?>'>
    </div>
</div> 
<div class="control-group">
    <label class="control-label" for="inputMessage">Message:</label>
    <div class="controls">
      <textarea name="message"><?php echo htmlentities($user_message) ?></textarea>
    </div>
</div> 


<div class="control-group">
<div class="controls">
	<img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' >
</div>
<br>
    <label class="control-label" for="inputCaptcha">Enter above code here:</label>
   
    <div class="controls">
      <input id="6_letters_code" name="6_letters_code" type="text"><br>
      <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>
    </div>
</div>

<div class="controls">
<input type="submit" value="Submit" name='submit' class="btn btn-primary">
</div>
</form>
<script language="JavaScript">
// Code for validating the form
// Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
// for details
var frmvalidator  = new Validator("contact_form");
//remove the following two lines if you like error message box popups
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();

frmvalidator.addValidation("name","req","Please provide your name"); 
frmvalidator.addValidation("email","req","Please provide your email"); 
frmvalidator.addValidation("email","email","Please enter a valid email address"); 
</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
      

    

      <hr>

      <div class="footer">
        <p>© Roy Rutto 2013</p>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap-transition.js"></script>
    <script src="./js/bootstrap-alert.js"></script>
    <script src="./js/bootstrap-modal.js"></script>
    <script src="./js/bootstrap-dropdown.js"></script>
    <script src="./js/bootstrap-scrollspy.js"></script>
    <script src="./js/bootstrap-tab.js"></script>
    <script src="./js/bootstrap-tooltip.js"></script>
    <script src="./js/bootstrap-popover.js"></script>
    <script src="./js/bootstrap-button.js"></script>
    <script src="./js/bootstrap-collapse.js"></script>
    <script src="./js/bootstrap-carousel.js"></script>
    <script src="./js/bootstrap-typeahead.js"></script>

  

</body></html>
