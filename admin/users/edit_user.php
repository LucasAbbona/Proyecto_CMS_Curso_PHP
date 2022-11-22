<?php
include"../includes/connection.php";
ob_start();

if(isset($_GET['edit_user'])){
$the_user_id= $_GET['edit_user'];

$query="SELECT * FROM users WHERE user_id = $the_user_id ";
                                $select_users_query= mysqli_query($connection,$query); 
                                while($row=mysqli_fetch_assoc($select_users_query)){
                                    $user_id=$row['user_id'];
                                    $username=$row['username'];
                                    $user_password=$row['user_password'];
                                    $user_firstname=$row['user_firstname'];
                                    $user_lastname=$row['user_lastname'];
                                    $user_email=$row['user_email'];
                                    $user_image=$row['user_image'];
                                    $user_role=$row['user_role']; }


if(isset($_POST['edit_user'])){
    $user_firstname= $_POST['user_firstname'];
    $user_lastname= $_POST['user_lastname'];
    $user_role= $_POST['user_role'];
    $username= $_POST['username'];
    $user_email= $_POST['user_email'];
    $user_password= $_POST['user_password'];


if(!empty($user_password)){
    $query_pass="SELECT user_password FROM users WHERE user_id=$the_user_id ";
    $get_user= mysqli_query($connection,$query_pass);

    $row=mysqli_fetch_array($get_user);
    $db_user_password=$row['user_password'];
    
    if($db_user_password!=$user_password){
    $hash_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost' => 12));
}
$query="UPDATE users SET user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', user_role='{$user_role}', username='{$username}', user_email='{$user_email}', user_password='{$hash_password}' WHERE user_id = {$the_user_id} ";

$update_user= mysqli_query($connection,$query);
}



}
}else{
header("Location:index.php");

}
?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
<input type="text" class="form-control" placeholder="First Name" value="<?php echo $user_firstname; ?>" name="user_firstname">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Last Name" value="<?php echo $user_lastname; ?>" name="user_lastname">
</div>

<div class="form-group">

<select name="user_role" id="">

<option value="subscriber"><?php echo $user_role; ?></option>

<?php
if($user_role=='admin'){

echo "<option value='subscriber'>Subscriber</option>";

} else {
    echo "<option value='admin'>Admin</option>";    
}
?>

</select>

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
<input type="submit" value="Update" name="edit_user">

</form>