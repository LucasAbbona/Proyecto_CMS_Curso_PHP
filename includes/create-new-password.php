<?php  include "./connection.php"; ?>
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


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                                <div class="panel-body">
                                    <?php 
                                    $selector=$_GET['selector'];
                                    $validator=$_GET['validator'];
                                    if(empty($selector) || empty($validator)){
                                        echo "Could not validate your request";
                                    }else{
                                        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){

                                            ?>
                                            <form action="reset-request.inc.php" method="post">
                                            <input type="hidden" name="selector" value="<?php echo $selector ?>">
                                            <input type="hidden" name="validator" value="<?php echo $validator ?>">
                                            <input type="password" name="pwd" placeholder="Enter a new password" id="">
                                            <input type="password" name="pwd-repeat" placeholder="Repeat new password" id="">
                                            <button type="submit" name="reset-pwd-submit">Reset Password</button>
                                        </form>

                                            <?php
                                        }
                                    }

                                    ?>
                                </div>

                        </div>
                    </div>
                </div>
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

</div> <!-- /.container -->

<script src="js/jquery.js"></script>

<script src="js/bootstrap.min.js"></script>

</body>

</html>
