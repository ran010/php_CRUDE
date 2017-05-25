<?php
	require_once 'dbconfig.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
#myImg {
	border-radius: 5px;
	cursor: pointer;
	transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
	display: none; /* Hidden by default */
	position: fixed; /* Stay in place */
	z-index: 1; /* Sit on top */
	padding-top: 100px; /* Location of the box */
	left: 0;
	top: 0;
	width: 100%; /* Full width */
	height: 100%; /* Full height */
	overflow: auto; /* Enable scroll if needed */
	background-color: rgb(0,0,0); /* Fallback color */
	background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
	margin: auto;
	display: block;
	width: 50%;
	max-width: 700px;

}

/* Caption of Modal Image */
#caption {
	margin: auto;
	display: block;
	width: 80%;
	max-width: 700px;
	text-align: center;
	color: #ccc;
	padding: 10px 0;
	height: 150px;
}

/* Add Animation */
.modal-content, #caption {
	-webkit-animation-name: zoom;
	-webkit-animation-duration: 0.6s;
	animation-name: zoom;
	animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
	from {-webkit-transform:scale(0)}
	to {-webkit-transform:scale(1)}
}

@keyframes zoom {
	from {transform:scale(0)}
	to {transform:scale(1)}
}

/* The Close Button */
.close {
	position: absolute;
	top: 15px;
	right: 35px;
	color: #f1f1f1;
	font-size: 40px;
	font-weight: bold;
	transition: 0.3s;
}

.close:hover,
.close:focus {
	color: #bbb;
	text-decoration: none;
	cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
	.modal-content {
			width: 100%;
	}
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>INDEX PAGE</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">


</head>

<body>

<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <a class="navbar-brand" href="home.php" title='Programming Blog'>Home</a>
            <a class="navbar-brand" href="#">Gallery</a>
            <a class="navbar-brand" href="#">Contact Us</a>
            <a class="navbar-brand" href="#">About Us</a>
						<a  href="logout.php" class="glyphicon glyphicon-log-in">logout</a>

						<?php if(isset($_SESSION['is_loggedin()'])) : ?>
							<a  href="logout.php" class="glyphicon glyphicon-log-in">logout</a>
							<h1>You want to sign in</h1>
					<?php else : ?>
						<a  href="login.php" class="glyphicon glyphicon-log-in">signin</a>

				<?php endif ;?>
        </div>

    </div>
</div>

<div class="container">
<div class="row">
<?php

	$stmt = $DB_con->prepare('SELECT pid, pname, psize, pdetails,ptype,ppic FROM details ORDER BY pid DESC');
	$stmt->execute();

	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>

		<div class="col-xs-3">
				<p class="page-header">name:<?php echo $pname//."&nbsp;/&nbsp;".$userProfession; ?></p>
				<img id="myImg" src="user_images/<?php echo $row['ppic']; ?>" class="img-rounded" width="250px" height="250px" />
				<span>
					<p class="page-header">Size<?php echo $psize; ?></p>
					<p class="page-header">Type<?php echo $ptype; ?></p>
					<p class="page-header">Details<?php echo $pdetails; ?></p>
				</span>
				</p>
				<!-- jquery model -->
				<div id="myModal" class="modal">
				  <span class="close">&times;</span>
				  <img class="modal-content" id="img01">
				</div>
				<script>
				// Get the modal
				var modal = document.getElementById('myModal');

				// Get the image and insert it inside the modal - use its "alt" text as a caption
				var img = document.getElementById('myImg');
				var modalImg = document.getElementById("img01");
				var captionText = document.getElementById("caption");
				img.onclick = function(){
				    modal.style.display = "block";
				    modalImg.src = this.src;
				    captionText.innerHTML = this.alt;
				}

				// Get the <span> element that closes the modal
				var span = document.getElementsByClassName("close")[0];

				// When the user clicks on <span> (x), close the modal
				span.onclick = function() {
				    modal.style.display = "none";
				}
				</script>
			</div>


			<?php
		}
	}
	else
	{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
            </div>
        </div>
        <?php
	}

?>
</div>

</div>


</div>


<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>
