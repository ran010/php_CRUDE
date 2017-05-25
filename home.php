<?php

	require_once("session.php");
	require_once 'dbconfig.php';

	require_once("class.user.php");
	$auth_user = new USER();

	$user_id = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT ppic FROM details WHERE pid =:id');
		$stmt_select->execute(array(':id'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['ppic']);

		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM details WHERE pid =:id');
		$stmt_delete->bindParam(':id',$_GET['delete_id']);
		$stmt_delete->execute();

		header("Location: home.php");
	}

?>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>welcome - <?php// print($userRow['user_email']); ?></title>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com">Coding Cage</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://www.codingcage.com/2015/04/php-login-and-registration-script-with.html">Back to Article</a></li>
            <li><a href="http://www.codingcage.com/search/label/jQuery">jQuery</a></li>
            <li><a href="http://www.codingcage.com/search/label/PHP">PHP</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php// echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              <ul class="dropdown-menu">
                <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>

              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
  <!--    </div>
    </nav>


    <div class="clearfix"></div>


<div class="container-fluid" style="margin-top:80px;">

    <div class="container">

    	<label class="h5">welcome : <?php// print($userRow['user_name']); ?></label>
        <hr />

        <h1>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp;
        <a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h1>
       	<hr />

        <p class="h4">User Home Page</p>


    <p class="blockquote-reverse" style="margin-top:200px;">
    Programming Blog Featuring Tutorials on PHP, MySQL, Ajax, jQuery, Web Design and More...<br /><br />
    <a href="http://www.codingcage.com/2015/04/php-login-and-registration-script-with.html">tutorial link</a>
    </p>

    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>welcome - <?php print($userRow['user_email']); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>HOME PAGE</title>
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
					<?php if(isset($_SESSION['is_loggedin'])) : ?>

					<a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a>
          <a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a>
				<?php else : ?>
					<a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a>

					<a  href="login.php" class="glyphicon glyphicon-log-in">signin</a>

				<?php endif ;?>
				<!--	<a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp;
					<a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h1> -->

        </div>

    </div>
</div>

<div class="container">

	<div class="page-header">
    	<h1 class="h2">ADD PRODUCTS <a class="btn btn-default" href="addnew.php"> <span class="glyphicon glyphicon-plus"></span> &nbsp; add new </a></h1>
    </div>

<br />

<div class="row">
<?php

	$stmt = $DB_con->prepare('SELECT pid, pname, psize, ptype,pdetails,ppic FROM details ORDER BY pid DESC');
	$stmt->execute();

	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
		<div class="col-xs-3">
				<p class="page-header">Name:<?php echo $pname//."&nbsp;/&nbsp;".$userProfession; ?></p>
				<img src="user_images/<?php echo $row['ppic']; ?>" class="img-rounded" width="250px" height="250px" />
				<span>
					<p class="page-header">Size:<?php echo $psize; ?></p>
					<p class="page-header">Type:<?php echo $ptype; ?></p>
					<p class="page-header">Detail:<?php echo $pdetails; ?></p>



				<a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['pid']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['pid']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				</span>
				</p>
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

<div class="alert alert-info">
    <strong>tutorial link !</strong> <a href="http://www.codingcage.com/2016/02/upload-insert-update-delete-image-using.html">Coding Cage</a>!
</div>

</div>


<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>
