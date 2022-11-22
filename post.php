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

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/blog-home.css" rel="stylesheet">

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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>

    </nav>

     

    <div class="container">

        <div class="row">
            <div class="col-md-8">
            <!-- Posteo -->
            <?php    
                if(isset($_GET['p_id'])){
                    $post_id=$_GET['p_id'];
                }
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ){
                $query="SELECT * FROM posts WHERE post_id = $post_id ";
            }else{
                $query="SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'published' ";
            }


            $select_all_posts_query= mysqli_query($connection,$query);
            if(mysqli_num_rows($select_all_posts_query) < 1){
                echo "<h1 class='text-center'>No posts available</h1>";
            }else {
            
            while($row=mysqli_fetch_assoc($select_all_posts_query)){
                    $post_title=$row["post_title"];
                    $post_author=$row["post_author"];
                    $post_date=$row["post_date"];
                    $post_image=$row["post_image"];
                    $post_content=$row["post_content"];
                    $post_user=$row['post_user'];
            ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="./admin/images/<?php $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                
                <div class="clearfix"></div>

                <?php
if(isset($_POST['create_comment'])){
    $post_id=$_GET['p_id'];
        $comment_author=$_POST['comment_author'];
        $comment_email=$_POST['comment_email'];
        $comment_content=$_POST['comment_content'];
    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
    $query="INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ('{$post_id}', '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
        $create_comment_query= mysqli_query($connection,$query);

      
    }else{
        echo "Fields Can not be empty";
    }
    

    

}



?>

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="Author">Author</label>
                            <input type="text" class="form-control" name="comment_author"></input>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" name="comment_email"></input>
                        </div>
                        <div class="form-group">
                            <label for="Comment">Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Comentarios -->
                <?php
                $query="SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC ";
                $select_comment_query= mysqli_query($connection,$query);
                while($row=mysqli_fetch_array($select_comment_query)){
                    $comment_date=$row['comment_date'];
                    $comment_content=$row['comment_content'];
                    $comment_author=$row['comment_author'];

                    ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h3 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?> </small>
                        </h3>
                        <?php echo $comment_content; ?>

                    </div>
                </div>

            <?php } }?>
            <!-- Comentarios -->

                
                
    <?php } ?>
    <!-- Posteos -->

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


                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
  
                    </div>

                </div>

                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>
            </div>

        </div>
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>
    </div>

    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
