<?php include "../includes/connection.php" ?>
<?php ob_start();?>
<?php session_start(); ?>
<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    $query="SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile=mysqli_query($connection,$query);

    while($row=mysqli_fetch_array($select_user_profile)){
        $user_id=$row['user_id'];
        $username=$row['username'];
        $user_password=$row['user_password'];
        $user_firstname=$row['user_firstname'];
        $user_lastname=$row['user_lastname'];
        $user_email=$row['user_email'];
        $user_image=$row['user_image'];
        $user_role=$row['user_role'];

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
if(isset($_POST['edit_user'])){
    $user_firstname= $_POST['user_firstname'];
    $user_lastname= $_POST['user_lastname'];
    $user_role= $_POST['user_role'];
    $username= $_POST['username'];
    $user_email= $_POST['user_email'];
    $user_password= $_POST['user_password'];

$query="UPDATE users SET user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', username='{$username}', user_email='{$user_email}', user_password='{$user_password}' WHERE username = '{$username}' ";

$update_user= mysqli_query($connection,$query);

}

?>
<div id="wrapper">

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">CMS ADMIN</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php
                    if(isset($_SESSION['username'])){
                        echo $_SESSION['username'];

                    }
                    ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="./profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>
            <li>
                <a href="./posts.php" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo1" class="collapse">
                    <li>
                        <a href="posts.php?source=add_posts">Add Posts</a>
                    </li>
                    <li>
                        <a href="./posts.php">View Posts</a>
                    </li>
                </ul>
</li> 
            <li class="active">
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="./users.php">View all users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>
            <li >
                <a href="../comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">
                            Administration area
                            <small>FROM USERS</small>
                        </h1>
                        <form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
<input type="text" class="form-control" placeholder="First Name" value="<?php echo $user_firstname; ?>" name="user_firstname">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Last Name" value="<?php echo $user_lastname; ?>" name="user_lastname">
</div>

<div class="form-group">
<input type="text" class="form-control" placeholder="Username" value="<?php echo $username; ?>" name="username">
</div>
<div class="form-group">
<input type="email" class="form-control" placeholder="Email" value="<?php echo $user_email; ?>" name="user_email">
</div>
<div class="form-group">
<input type="password" class="form-control" placeholder="Password" autocomplete="off" name="user_password">
</div>
<input type="submit" value="Update Profile" name="edit_user">

</form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="./js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./js/bootstrap.min.js"></script>

</body>

</html>
