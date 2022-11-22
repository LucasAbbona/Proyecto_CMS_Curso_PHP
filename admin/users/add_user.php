<?php
include "../includes/connection.php";
ob_start();

if(isset($_POST['create_user'])){
    $user_firstname= $_POST['user_firstname'];
    $user_lastname= $_POST['user_lastname'];
    $user_role= $_POST['user_role'];/* 
    $post_image= $_FILES['image'] ['name'];
    $post_image_temp= $_FILES['image'] ['tmp_name']; */
    $username= $_POST['username'];
    $user_email= $_POST['user_email'];
    $user_password= $_POST['user_password'];
    /* $post_date= date('d-m-y'); */
    /* $post_comment_count= 4; */


/*     move_uploaded_file($post_image_temp, "../images/$post_image");
         */
        $user_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost' => 10));
    $query="INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) VALUES('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$user_password}')";
    $create_user_query=mysqli_query($connection,$query);

    echo "User Created: " ." " . "<a href='users.php'>View Users</a>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
<input type="text" class="form-control" placeholder="First Name" name="user_firstname">
</div>

<div class="form-group">
<input type="text" class="form-control" placeholder="Last Name" name="user_lastname">
</div>

<div class="form-group">
<select name="user_role" id="">
<option value="subscriber">Select options</option>
<option value="admin">Admin</option>
<option value="subscriber">Subscriber</option>
</select>
</div>

<div class="form-group">
<input type="text" class="form-control" placeholder="Username" name="username">
</div>

<div class="form-group">
<input type="email" class="form-control" placeholder="Email" name="user_email">
</div>
<div class="form-group">
<input type="password" class="form-control" placeholder="Password" name="user_password">
</div>
<input type="submit" value="Create" name="create_user">

</form>