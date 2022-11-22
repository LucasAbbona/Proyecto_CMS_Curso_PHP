<?php
require "./connection.php";
if (isset($_POST['recover-submit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost:3000/includes/create-new-password.php?selector=". $selector . "&validator=".bin2hex($token);
    $expires= date("U")+1800;
    
    $userEmail = $_POST['email'];
    $query="DELETE FROM pwdReset WHERE pwdResetEmail = ?;";
    $stmt=mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($stmt,$query)){
        echo "There was an error";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s",$userEmail);
        mysqli_stmt_execute($stmt);
    }
    $query="INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?); ";
    $stmt=mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($stmt,$query)){
        echo "There was an error";
        exit();
    }else{
        $hashtoken= password_hash($token,PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashtoken, $expires);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    
    $to = $userEmail;
    $subject= "Reset your password for CMS";
    $message="<p>We recieve a password reset request. This link will reset your password</p>";
    $message .= "<p>Here is your password reset link:</p></br>";
    $message .="<a href='.$url.'>'.$url.'</a>" ;

    $headers ="From: CMS <lucasabbona.github.io> \r\n";
    $headers .="Reply-To: useremail@gmail.com \r\n";
    $headers .="Content-type: text/html\r\n";

    mail($to,$subject,$message,$headers);

    header("Location: ../reset-password.php?reset=success");

} else{
    header("Location: ./index.php");
}