<?php include("admin-panel/app/config/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<title>MR ART Exports</title>
	<meta name='robots' content='noindex,follow' />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<style type="text/css">
		.jumbotron {
		background: #358CCE;
		color: #FFF;
		border-radius: 0px;
		}
		.jumbotron-sm { padding-top: 24px;
		padding-bottom: 24px; }
		.jumbotron small {
		color: #FFF;
		}
		.h1 small {
		font-size: 24px;
		}
	</style>
	
</head>
<body style="font-family: 'Ubuntu', sans-serif;">
		<header>
			<div class="mx-auto mt-2 mb-2" style="width: 200px;">
				<a href="" title="MR ART Exports"><img src="images/logo.png" width="200px"></a>
			</div>
		</header>
		<div class="container shadow-lg p-2 mb-5 bg-white rounded">
			<?php include("widgets/top-menu.php"); ?>

		<!-- Product Category Started -->
		<main role="main" class="about">
		  <div style="width:100%;height:400px;"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d894.8408206166928!2d73.00346252923812!3d26.21738310210235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39418b3b1242f9ff%3A0x60b5f8a92de49a35!2sSat+Sai+Infocom!5e0!3m2!1sen!2sin!4v1550166702927" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe></div>
		  <div class="jumbotron jumbotron-sm">
		    <div class="container">
		        <div class="row">
		            <div class="col-sm-12 col-lg-12">
		                <h1 class="h1">
		                    Contact us <small>Feel free to reach us</small></h1>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="container">
		    <div class="row">
		        <div class="col-md-8">
		            <div class="well well-sm m-4">
		                <form method="POST">
		                	<div id="displayMessage"></div>
		                <div class="row">
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label for="name">
		                                Name</label>
		                            <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
		                        </div>
		                        <div class="form-group">
		                            <label for="email">
		                                Email Address</label>
		                            <div class="input-group">
		                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
		                                </span>
		                                <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
		                        </div>
		                        <div class="form-group">
		                            <label for="subject">
		                                Subject</label>
		                            <select id="subject" name="subject" class="form-control" required="required">
		                                <option value="na" selected="">Choose One:</option>
		                                <option value="service">General Customer Service</option>
		                                <option value="suggestions">Suggestions</option>
		                                <option value="product">Product Support</option>
		                            </select>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label for="name">
		                                Message</label>
		                            <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
		                                placeholder="Message"></textarea>
		                        </div>
		                    </div>
		                    <div class="col-md-12">
		                        <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
		                            Send Message</button>
		                    </div>
		                </div>
		                </form>
		            </div>
		        </div>
		        <div class="col-md-4">
		            <form>
		            <legend><span class="glyphicon glyphicon-globe"></span> Our office</legend>
		            <address>
		                <strong>SAT SAI INFOCOM</strong><br>
		                Plot No. 10, Veer Tejaji Nagar,
		                <br>
		                Sangariya, Jodhpur, Rajasthan, 342005<br/>
		                <abbr title="Phone">
		                    P:</abbr>
		                +91 88241 66759
		            </address>
		            <address>
		            	<strong>Developed By:</strong><br>
		            	<a href="https://github.com/devavratsingh" target="_blank">Devavrat Singh</a><br>
		                <strong>email</strong><br>

		                <a href="mailto:satsaiinfo@gmail.com">satsaiinfo@gmail.com</a><br>
		            </address>
		            </form>
		        </div>
		    </div>
		</div>

		</main>
		<?php include("widgets/footer.php"); ?>
	</div>
	<script type="text/javascript">
	const url = 'contact-operation.php';
	const form = document.querySelector('form');
	form.addEventListener('submit', e => {
	  e.preventDefault();
	  const name = document.getElementById('name').value;
	  const email = document.getElementById('email').value;
	  const subject = document.getElementById('subject').value;
	  const message = document.getElementById('message').value;
	  const formData = new FormData();
	  formData.append('name', name);
	  formData.append('email', email);
	  formData.append('subject', subject);
	  formData.append('message', message);
	  console.log(formData);
	  //if(window.XMLHttpRequest)
	  fetch(url, {
	    method: 'POST',
	    body: formData
	  }).then(response => response.text()
	  .then(text => {
	    document.getElementById('displayMessage').innerHTML = text;
	  }));
	});
	</script>
	<script type="text/javascript" src="js/jquery.slim.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>