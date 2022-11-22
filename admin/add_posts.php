<?php include "../includes/connection.php"; ?>
<?php ob_start();

if(isset($_POST['create_post'])){
    $post_title= $_POST['post_title'];
    $post_user= $_POST['post_user'];
    $post_category_id= $_POST['post_category_id'];
    $post_status= $_POST['post_status'];
    $post_image= $_FILES['image'] ['name'];
    $post_image_temp= $_FILES['image'] ['tmp_name'];
    $post_tags= $_POST['post_tags'];
    $post_content= $_POST['post_content'];
    $post_date= date('d-m-y');
    /* $post_comment_count= 4; */


    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query="INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES ('{$post_category_id}','{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
    $create_post_query=mysqli_query($connection,$query);

}
?>

<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">

<input type="text" class="form-control" placeholder="Title" name="title">
</div>

<div class="form-group">
    <label for="category">Category</label>
<select name="post_category_id" id="">
<?php
$query="SELECT * FROM categories ";
$select_categories_= mysqli_query($connection,$query); 

while($row=mysqli_fetch_assoc($select_categories_)){
$cat_id=$row['cat_id'];
$cat_title=$row['cat_title'];
echo "<option value='$cat_id'>$cat_title</option>";
}

?>

</select>
</div>

<!-- <div class="form-group">
<input type="text" class="form-control" placeholder="Author" name="author">
</div> -->
<div class="form-group">
    <label for="users">Users</label>
<select name="post_user" id="">
<?php
$query="SELECT * FROM users ";
$select_users_= mysqli_query($connection,$query); 

while($row=mysqli_fetch_assoc($select_users_)){
$user_id=$row['user_id'];
$username=$row['username'];
echo "<option value='$username'>$username</option>";
}

?>

</select>
</div>

<div class="form-group">
    <label for="post_status">Post Status</label>
    <select name="post_status" id="">
        <option value="draft">Select Options</option>
        <option value="published">Published</option>
        <option value="draft">Draft</option>
    </select>

</div>

<div class="form-group">
<input type="file"  name="image">
</div>

<div class="form-group">
<input type="text" class="form-control" placeholder="Post Tags" name="post_tags">
</div>

<div class="form-group">
<input type="text" class="form-control" placeholder="Content" name="post_content">
</div>
<input type="submit" value="Publish" name="create_post">

</form>