<?php include "includes/connection.php"; ?>
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
                <a class="navbar-brand" href="./index.php">HOME</a>
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
                 
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <?php    
            $query="SELECT * FROM posts";
            $select_all_posts_query= mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($select_all_posts_query)){
                    $post_title=$row["post_title"];
                    $post_author=$row["post_author"];
                    $post_date=$row["post_date"];
                    $post_image=$row["post_image"];
                    $post_content=$row["post_content"];
                }
            ?>
<div class="well">
                    <h4>Blog Search</h4>
                    <form action="" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form>

                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
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
                                    echo "<li><a href='#'>$cat_title</a></li>";
                                }
                                ?>
                                
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                

            </div>

        </div>
<?php
            if(isset($_POST["submit"])){
            $search = $_POST['search'];
            $query= "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
            $search_query = mysqli_query($connection,$query);

            $count= mysqli_num_rows($search_query);

            if($count == 0){
                echo "<h1>NO RESULTS FOUND</h1>";
            }else{
                echo " " ."<h1>$count RESULTS FOUND</h1>";?>
                <!-- First Blog Post -->
                <?php    
            $query="SELECT * FROM posts";
            $select_all_posts_query= mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($search_query)){
                    $post_title=$row["post_title"];
                    $post_author=$row["post_author"];
                    $post_date=$row["post_date"];
                    $post_image=$row["post_image"];
                    $post_content=$row["post_content"];
                    $post_user=$row['post_user'];
                    $post_id=$row['post_id'];
            ?>
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <?php } ?>
            <?php
            }
            }
            ?> 
            <hr>

<!-- Footer -->
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