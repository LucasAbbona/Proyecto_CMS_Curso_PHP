<?php  include "./includes/connection.php"; ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Home - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-home.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
if(isset($_GET['lang']) &&  !empty($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
        echo "<script type='text/javascript'>location.reload();</script>";
    }
}
    if(isset($_SESSION['lang'])){
        include "./includes/languages/". $_SESSION['lang']. ".php";
    }else{
        include "./includes/languages/en.php";
    }




?>

<?php
    function username_exists($username){
     global $connection;
     $query="SELECT username FROM users WHERE username = '$username'";
     $result = mysqli_query($connection,$query);
     if(mysqli_num_rows($result) > 0){
        return true;
     }else{
        return false;
     }
}
function email_exists($email){
    global $connection;
    $query="SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection,$query);
    if(mysqli_num_rows($result) > 0){
       return true;
    }else{
       return false;
    }
}
    
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        if((username_exists($username) || email_exists($email))){
            $message = 'This user or email already exists';
            echo $message;
            die("Query Failed");
        }else{
        
        if(!empty($username) && !empty($email) && !empty($password)){
        

        $username=mysqli_real_escape_string($connection,$username);
        $email=mysqli_real_escape_string($connection,$email);
        $password= mysqli_real_escape_string($connection,$password);
            
        $password = password_hash($password,PASSWORD_BCRYPT,array('cost' => 12));

        $query="INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
        $register_user=mysqli_query($connection,$query);

            $message="Registration Completed";
        
    } else{
        $message="Fields can not be empty";
    }
}

}else{
    $message="";
}


?>

    <!-- Navigation -->
    
     <!-- Navigation -->
     <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index">HOME</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                
                <?php
                $query="SELECT * FROM categories";
                $select_all_categories_query= mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($select_all_categories_query)){
                    $cat_title=$row["cat_title"];
                    echo "<li><a href='#'>{$cat_title}</a></li>";
                }
                ?>
                <li><a href="./admin/index.php">Admin</a></li>
                    
                <?php
                if(isset($_SESSION['user_role'])){
                    if(isset($_GET['p_id'])){
                        $the_post_id=$_GET['p_id'];
                        echo "<li>
                        <a href='admin/posts.php?source=edit_post&p_id=$the_post_id'>Edit Post</a>
                    </li>";
                    }
                
                }

?>
                    
                    
                    <!--
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li> -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
 
    <!-- Page Content -->
    <div class="container">
    <form action="" method="get" class="navbar-form navbar-right" id="language_form">
        <div class="form-group">
            <select name="lang" class="form-control" onchange="changeLanguage()" > 
                <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){echo "selected"; } ?>>English</option>
                <option value="es" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'es'){echo "selected"; } ?>>Spanish</option>
            </select>
        </div>
    </form>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER; ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                    <h6 class="text-center"><?php echo $message; ?></h6>    
                    <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="<?php echo _REGISTER; ?>">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>

<script>
    function changeLanguage(){
        document.getElementById('language_form').submit();
    }
</script>

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

