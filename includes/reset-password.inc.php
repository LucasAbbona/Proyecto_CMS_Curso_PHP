<?php
if(isset($_POST['reset-pwd-submit'])){
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['pwd'];
    $pwdRepeat = $_POST['pwd-repeat'];

    if(empty($password) || empty($pwdRepeat)){
        header("Location: create-new-password.php?newpwd=empty");
        exit();
    } else if($password != $pwdRepeat){
        header("Location: create-new-password.php?newpwd=pwdnotsame");
        exit();
    }
$currentdate= date("U");

require "./includes/connection.php";

$query= "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
$stmt=mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($stmt,$query)){
        echo "There was an error";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s",$selector,$currentdate);
        mysqli_stmt_execute($stmt);
        $result= mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result)){
            echo "You need to be re-submit your reset request.";
            exit();
        }else{
            $tokenBin=hex2bin($validator);
            $tokenCheck=password_verify($tokenBin,$row['pwdResetToken']);
            if($tokenCheck === false){
            echo "You need to be re-submit your reset request.";
            exit();            
        }elseif($tokenCheck === true){
            $tokenEmail = $row=['pwdResetEmail'];
            $query="SELECT * FROM users WHERE user_email=?;";
            $stmt=mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($stmt,$query)){
                echo "There was an error";
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s" ,$tokenEmail);
                mysqli_stmt_execute($stmt);
            $result= mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)){
                echo "There was an error!";
                exit();
            } else{
                $query="UPDATE users SET user_password=? WHERE user_email=?;";
                $stmt=mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($stmt,$query)){
                echo "There was an error";
                exit();
            }else{
                $newpwd= password_hash($password,PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss" ,$newpwd, $tokenEmail);
                mysqli_stmt_execute($stmt);
                $query= "DELETE FROM pwdreset WHERE pwdResetEmail=?";
                $stmt=mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($stmt,$query)){
                echo "There was an error";
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s" ,$tokenEmail);
                mysqli_stmt_execute($stmt);
                header("Location: ./index.php?newpwd=passwordupdated");
            }

            }
        }
        }
    } 
    }
    }

} else{
    header("Location: index.php");
}