<?php

	error_reporting( ~E_NOTICE ); // avoid notice

	require_once 'dbconfig.php';

	if(isset($_POST['btnsave']))
	{
		$productname = $_POST['p_name'];// user name
		$productsize = $_POST['p_size'];// user email
		$producttype = $_POST['p_type'];
		$productdetails = $_POST['p_details'];
		$imgFile = $_FILES['p_image']['name'];
		$tmp_dir = $_FILES['p_image']['tmp_name'];
		$imgSize = $_FILES['p_image']['size'];


		if(empty($productname)){
			$errMSG = "Please Enter Product Name.";
		}
		else if(empty($productsize)){
			$errMSG = "Please Enter Product Size.";
		}
		else if(empty($producttype)){
			$errMSG = "Please Enter Product Type.";
		}
		else if(empty($productdetails)){
			$errMSG = "Please Enter Product Details.";
		}
		else if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = 'user_images/'; // upload directory

			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

			// rename uploading image
			$productpic = rand(1000,1000000).".".$imgExt;

			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$productpic);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}
		}


		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO details (pname,psize,ptype,pdetails,ppic) VALUES(:name, :size,:type,:details ,:pic)');
			$stmt->bindParam(':name',$productname);
			$stmt->bindParam(':size',$productsize);
			$stmt->bindParam(':type',$producttype);
			$stmt->bindParam(':details',$productdetails);
			$stmt->bindParam(':pic',$productpic);

			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:5;index.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADD PRODUCT</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
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
					<a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a>
          <a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a>
        </div>

    </div>
</div>

<div class="container">


	<div class="page-header">
    	<h1 class="h2">Add new products: <a class="btn btn-default" href="home.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; view all </a></h1>
    </div>


	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>

<form method="post" enctype="multipart/form-data" class="form-horizontal">

	<table class="table table-bordered table-responsive">

    <tr>
    	<td><label class="control-label">ProductName.</label></td>
        <td><input class="form-control" type="text" name="p_name" placeholder="Enter Product" value="<?php echo $productname; ?>" /></td>
    </tr>
		<tr>
    	<td><label class="control-label">Product Type</label></td>
        <td><input class="form-control" type="text" name="p_type" placeholder="Product type" value="<?php echo $producttype; ?>" /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Product Size</label></td>
        <td><input class="form-control" type="text" name="p_size"  placeholder="Product Size" value="<?php echo $productsize; ?>" /></td>
    </tr>
		<tr>
    	<td><label class="control-label">Product Details</label></td>
        <td><input class="form-control" type="text" name="p_details" placeholder="Product Details" value="<?php echo $productdetails; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Image</label></td>
        <td><input class="input-group" type="file" name="p_image" accept="image/*" /></td>
    </tr>

    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>

    </table>

</form>



<div class="alert alert-info">
    <strong>tutorial link !</strong> <a href="http://www.codingcage.com/2016/02/upload-insert-update-delete-image-using.html">Coding Cage</a>!
</div>



</div>






<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>
