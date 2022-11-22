<?php include "includes/connection.php";?>
<?php session_start();
      ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog Home - Start Bootstrap Template</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/blog-home.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">HOME</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <!-- Categorias en la navegacion -->
                <?php
                $query="SELECT * FROM categories";
                $select_all_categories_query= mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($select_all_categories_query)){
                    $cat_title=$row["cat_title"];
                    echo "<li><a href='#'>{$cat_title}</a></li>";} ?>

                <li><a href="./admin/index.php">Admin</a></li>
                <li><a href="./registration.php">Registration</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <!-- Categorias en la navegacion -->
                <?php
                if(isset($_SESSION['user_role'])){
                    if(isset($_GET['p_id'])){
                        $the_post_id=$_GET['p_id'];
                        echo "<li>
                        <a href='admin/posts.php?source=edit_post&p_id=$the_post_id'>Edit Post</a></li>";}
                }   ?>
    </nav>
        <div class="container">

        <div class="row">
            <div class="col-md-8">
            <!-- Pasar de pagina -->
            <?php
            if(isset($_GET['page'])){
                $page=$_GET['page'];
            
            }else{
                $page="";
            }

            if($page=="" || $page ==1){
                $page_1=0;
            }else{
                $page_1=($page*3) - 3;
            }
            ?>
            
            <?php
            $select_post_query_count="SELECT * FROM posts WHERE post_status = 'published'";
            $select_post_count=mysqli_query($connection,$select_post_query_count);
            $count=mysqli_num_rows($select_post_count);
            if($count < 1) {
                echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";

            } else {

            
            $count = ceil($count/3);           

            $query="SELECT * FROM posts LIMIT $page_1, 3 ";
            $select_all_posts_query= mysqli_query($connection,$query);
            while($row=mysqli_fetch_assoc($select_all_posts_query)){
                $post_id=$row["post_id"];
                $post_title=$row["post_title"];
                $post_author=$row["post_author"];
                $post_user=$row['post_user'];
                $post_date=$row["post_date"];
                $post_image=$row["post_image"];
                $post_content=substr($row["post_content"],0,50);
                $post_status=$row["post_status"];
                $post_category=$row['post_category_id'];

            ?>
            <!-- Pasar de pagina -->
            <?php if($_SESSION['user_role']=='Admin'){

             ?>
                <h1 class="page-header">
                    CMS PROJECT
                    <small>Lucas Abbona</small>
                </h1>
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="http://placehold.it/900x300" alt=""></a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                
    <?php }else{
        
    } } } ?>

                <ul class="pager">
                    
                </ul>
            </div>
            
            <div class="col-md-4">
            <!-- Lupita -->
            <?php
            if(isset($_POST["submit"])){
            $search = $_POST['search'];
            $query= "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
            $search_query = mysqli_query($connection,$query);

            $count= mysqli_num_rows($search_query);

            if($count==0){
                echo "NO RESULTS FOUND";
            }else{
                echo $count. " ". "RESULTS FOUND";
                
            }

            }
            
            ?>
            <!-- Lupita -->
               <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form>
                </div>
            
                <!-- Login -->
                <div class="well">
                <?php if(isset($_SESSION['user_role'])): ?>
                    <h4>Logged in as <?php echo $_SESSION['username'] ?> </h4>
                    <a href="./includes/logout.php" class="btn btn-primary">  Logout  </a>
                <?php else:  ?>
                <h4>Login</h4>
                <form action="./includes/login.php" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Username" name="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Enter Password" name="password">
                                    </div>
                                    <span class="input-group">
                                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                                    </span>
                                    
                                    <div class="form-group">
                                    <?php
                                    if(isset($_GET['newpwd'])){
                                        if($_GET['newpwd'] == "passwordupdated"){
                                            echo "<p>Your password has been reset</p>";
                                        }
                                    }
                                    ?>
                                    <a href="reset-password.php">Forgot Password?</a>
                                    </div>
                                    </form>
                <?php endif; ?>
                    
                    
                </div>



                
                <div class="well">

                <?php
                $query="SELECT * FROM categories ";
                $select_categories_sidebar = mysqli_query($connection,$query);
                ?>
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <?php
                                while($row= mysqli_fetch_assoc($select_categories_sidebar)){
                                    echo "<li><a href=#>$cat_title</a></li>";
                                    $query="SELECT * FROM posts WHERE post_category_id = {$post_category}";
                                    mysqli_query($connection,$query);
                                    
                                }
                                ?>
                                
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        

        <hr>

        
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
                
            </div>
            
        </footer>

    </div>
    <ul class="pager">
        <!-- Pasar de paginas -->
        <?php 
        for($i=1; $i <= $count;$i++){
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
        }
        ?>
        <!-- Pasar de paginas -->

    </ul>

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>

</body>

</html>
