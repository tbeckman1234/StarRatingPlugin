<?php 
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$DoS = $_POST['DoS'];
$sCheck = $_POST['sCheck'];
$pCheck = $_POST['pCheck'];
$message = $_POST['message'];
$formcontent="From: $name \n $sCheck \n $pCheck \n Message: $message";
$recipient = "tyeson@dppidaho.com, mike.emerich@gmail.com";
$subject = "Customer Review Feedback";
$mailheader = "From: $email \n Phone: $phone \n Date of service: $DoS \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "Thank You!";
?>

<html lang ="en">
<head>
<!--Custom CSS for rating plugin-->
<link rel="stylesheet" href="rating.css"/>
<!--Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!--Font Awesome custom CDN-->
<script src="https://use.fontawesome.com/43b5321601.js"></script>
</head>
<body>
<div class="ratingContainer container">
<div class="ratingDiv container jumbotron">
		<h3 class="rateHeading">Rate your experience with us! &nbsp <span class="fa fa-pencil"></span></h3>
		<h4 class="text-muted"><span id="starNum">0</span> out of 5 stars</h4>
		<ul class="c-rating" id="el">
		</ul>
		<button id="submitBtn" type="button" class="btn btn-primary btn-lg">Submit &nbsp <span class="fa fa-chevron-right"></span></button>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">We value your feedback</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p class="lead">Thank you for taking a moment to tell us how we did.  It appears that we may have fallen a bit short of your service expectations and we'd like to know more so we may learn and do better next time.</p>
		<p>
		What aspect of your interaction(s) were less than delightful?  Please pick all that apply.
		</p>
		<form action="starMail.php" method="POST">
		<div class="checkbox">
		  <label><input type="checkbox" name="sCheck" value="Dissatisfied with service">Service</label>
		</div>
		<div class="checkbox">
		  <label><input type="checkbox" name="pCheck" value="Dissatisfied with product">Product</label>
		</div>
		</br>
		<h4 class="text-center">Please tell us about your experience</h4>
		<div class="form-group">
		  <label for="comment">Comments:</label>
		  <textarea class="form-control" name="message" rows="5" id="comment"required></textarea>
		</div>
		<h4 class="text-center">We would like to contact you directly to discuss your experience.</h4>
		<div class="form-group">
			<label for="usr">Name:</label>
			<input type="text" name="name" class="form-control" id="usr" required>
		</div>
		<div class="form-group">
			<label for="phone">Phone:</label>
			<input type="text" name="phone" class="form-control" id="phone" required>
		</div>		
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" name="email" class="form-control" id="email" required>
		</div>
		<div class="form-group">
			<label for="DoS">Date of service:</label>
			<input type="DoS" name="DoS" class="form-control" id="DoS" required>
		</div>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send Feedback &nbsp <span class="fa fa-send"></span></button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!--Customized compilation of Bootstrap.js-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- Implementation of js for star rating plugin-->
	<script src="rating.min.js"></script>
		
<script>
//event listener detection booleans
var googleSet = false;
var suggestionSet = false;

//submit button
var submit = document.getElementById("submitBtn");

//button disabled until rating is selected
submit.disabled = true;
submit.style.backgroundColor = "gray";

// target element
var el = document.querySelector('#el');

//rating display
var starNum = document.getElementById("starNum");

// current rating, or initial rating
var currentRating = 0;

// max rating, i.e. number of stars you want
var maxRating= 5;

// callback to run after setting the rating
var callback = function(rating) 
{ 
	//Navigation to Google Reviews for 4&5 star ratings, and opens suggestion modal for 1-3 star ratings
	if (rating == 4 || rating == 5)
	{
		//checks for changed user rating and corrects navigation event listener
		if(suggestionSet == true) {
			submit.removeEventListener("click", openSuggestions);
			suggestionSet = false;
		}
		//sets text to current user rating, enables button, changes background color of button, sets "changed-user-rating-checking-boolean" value
		starNum.textContent = rating;
		submit.disabled = false;
		submit.style.backgroundColor = "#337ab7";
		googleSet = true;
		//adds event listener which sets navigation to Google Reviews for 4 & 5 star ratings
		submit.addEventListener("click", gotoGoogle);
		
	}else 
	{
		//checks for changed user rating and corrects navigation event listener
		if(googleSet == true) {
			submit.removeEventListener("click", gotoGoogle);
			googleSet = false;
		}
		//sets text to current user rating, enables button, changes background color of button, sets "changed-user-rating-checking-boolean" value
		starNum.textContent = rating;
		submit.disabled = false;
		submit.style.backgroundColor = "#337ab7";
		suggestionSet = true;
		//adds event listener which sets navigation to suggestion modal for 1-3 star ratings
		submit.addEventListener("click", openSuggestions);
	}
};

//go to Google Reviews for 4 & 5 star ratings
function gotoGoogle() {
	window.location= "https://search.google.com/local/writereview?placeid=ChIJsTrNBKL4rlQRaNxSqMNLBTY";
};

//open suggestion modal for 1-3 star ratings
function openSuggestions() {
	$('#myModal').modal('show');
};


// rating instance
var myRating = rating(el, currentRating, maxRating, callback);
</script>
</body>
</html>

