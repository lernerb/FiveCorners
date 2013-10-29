<?php

if(isset($_POST['submit'])) {
   
  include('validate.class.php');
   
  //assign post data to variables 
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $interest = trim($_POST['interest']);
  $message = trim($_POST['message']);
 
  //start validating our form
  $v = new validate();
  $v->validateStr($name, "name", 3, 75);
  $v->validateStr($phone, "phone", 7, 20);
  $v->validateEmail($email, "email");
  $v->validateStr($message, "message", 1, 1000);
 
 
  if(!$v->hasErrors()) {
		$main_email = 'Jonathan.Lerner@realliving.com';
        $header = "From: $main_email\n" . "Reply-To: $main_email\n";
        $subject = "Five Corners Real Estate Contact Form - $name";
        $email_to = $main_email;
                
        $emailMessage = "Hello! Our records indicate that you have a message from " . $name . "!\n\n";    
        $emailMessage .= "The users contact information is located below. Please follow up with them at your earliest convience.:\nEmail: " . $email . "\nPhone: " . $phone . "\n\n";
        $emailMessage .= "This user is interested in " . $interest . ". \n\nThe following message was sent by " .$name . ":\n\n" .$message;

        $url = "http". ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        header('Location: '.$url."?sent=yes");
        @mail($email_to, $subject ,$emailMessage ,$header );  
    } else {
    //set the number of errors message
    $message_text = $v->errorNumMessage();       
 
    //store the errors list in a variable
    $errors = $v->displayErrors();
     
    //get the individual error messages
    $nameErr = $v->getError("name");
    $emailErr = $v->getError("email");
	$phoneErr = $v->getError("phone");
    $messageErr = $v->getError("message");
  }//end error check
}
// end isset
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <title></title>
      <meta name="description" content="Scarsdale Real Estate from Real Living Five Corners">
      <meta name="viewport" content="width=device-width">
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/main.css">
      <script src="js/vendor/modernizr-2.6.2.min.js"></script>
      <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
      <script src="js/plugins.js"></script>
      <script src="js/main.js"></script>
   </head>
   <body id ="mainbody" class="mainbodyclass">
      <div class="body-container">
         <header class="header-wrapper">
            <div class="nav-wrapper">
               <nav>
                  <ul class="clearfix">
                     <li class="selected"><a href="index.html">Home</a></li>
                     <li class="notselected"><a  href="buying.html">Buying</a></li>
                     <li class="notselected"><a  href="selling.html">Selling</a></li>
                     <li class="notselected"><a  href="community.html">Community Info</a></li>
                     <li class="notselected"><a  href="realtors.html">Realtors</a></li>
                     <li class="notselected"><a  href="contact-us.html">Contact Us</a></li>
                     <li class="notselected-us"><a  href="join-us.html">Join Us</a></li>
                  </ul>
               </nav>
            </div>
            <a href="index.html" title="Go to the home page"><img src="img/logo.png" width="300" height="100" alt="Five Corners Real Estate" /></a>
            <hr>
         </header>
         <div class ="content-wrapper">
            <div class ="left-content">
               <p class="page-title">
                  Contact Five Corners Real Estate
               </p>
               <p>
                  You'll have filled out dozens of documents and signed your name more than a hundred times by the time we're finished buying or selling your home.
				  Unfortunately, we can't help that part -- real estate laws and such.
				  What we can do is make choosing your real estate agent as simple as this short contact form.
				  Better yet, just give us a call or drop by one of our conveniently located offices.
               <p/>
			
<div id="contact_form_wrap">
    <span class="message"><?php echo $message_text; ?></span>
    <?php echo $errors; ?>
    <?php if(isset($_GET['sent'])): ?><h2>Your message has been sent</h2><?php endif; ?>
    <form id="contact_form" method="post" action="contact-us.php">
      <p><label>Name:<br />
      <input type="text" name="name" class="textfield" value="<?php echo htmlentities($name); ?>" />
      </label><br /><span class="errors"><?php echo $nameErr; ?></span></p>
       
      <p><label>Email Address: <br />
      <input type="text" name="email" class="textfield" value="<?php echo htmlentities($email); ?>" />
      </label><br /><span class="errors"><?php echo $emailErr ?></span></p>          
	  
	  <p><label>Phone Number: <br />
      <input type="text" name="phone" class="textfield" value="<?php echo htmlentities($phone); ?>" />
      </label><br /><span class="errors"><?php echo $phoneErr ?></span></p>          


      <p><label>Interest: <br />
        <select name="interest">
                <option value = "buying a home">Buying a home</option>
                <option value = "selling a home">Selling a home</option>
                <option value = "joining the team">Joining the team</option>
				<option value = "asking a question">Other (message below)</option>

        </select>      
      </label></p>      
        
      <p><label>Message *: <br />
      <textarea name="message" class="textarea" cols="45" rows="5"><?php echo htmlentities($message); ?></textarea>
      </label><br /><span class="errors"><?php echo $messageErr ?></span></p>
       
      <p><input type="submit" name="submit" class="button" value="Submit" /></p>
    </form>
  </div>

			
			</div>
			   
			   

            </div>
         </div>
         <footer>
            <div class="footer-wrapper">
               <div class="social-wrapper" style="float:right">
                  <p>Follow Us</p>
                  <div class="addthis_toolbox addthis_32x32_style addthis_default_style">
                     <a class="addthis_button_facebook_follow" addthis:userid="pages/Five-Corners-Real-Estate/138141839532808#"></a>
                     <a class="addthis_button_twitter_follow" addthis:userid="RLFiveCorners"></a>
                     <a class="addthis_button_youtube_follow" addthis:userid="reallivingvideo?feature=watch"></a>
                     <a class="addthis_button_foursquare_follow" addthis:userid="v/real-living-five-corners/4e1da584b61c7cb34d93bbef"></a>
                  </div>
                  <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5219451f07524221"></script>
               </div>
               <div class="footer-text" style="float:left">
                  <p>© 2013 - Five Corners Real Estate</p>
               </div>
            </div>
         </footer>
      </div>
      <script>
         var _gaq=[['_setAccount','UA-26549749-2'],['_trackPageview']];
         (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
         g.src='https://www.google-analytics.com/ga.js';
         s.parentNode.insertBefore(g,s)}(document,'script'));
      </script>
   </body>
</html>