<?php
include"../includes/connection.php";

?>

<?php
    if(isset($_GET['p_id'])){
        $the_post_id=$_GET['p_id'];
    }

$query="SELECT * FROM posts WHERE post_id=$the_post_id";
$select_posts_id= mysqli_query($connection,$query); 

while($row=mysqli_fetch_assoc($select_posts_id)){
    $post_id=$row['post_id'];
    $post_user=$row['post_user'];
    $post_title=$row['post_title'];
    $post_date=$row['post_date'];
    $post_image=$row['post_image'];
    $post_comment_count=$row['post_comment_count'];
    $post_content= $row['post_content'];
    $post_tags=$row['post_tags'];
    $post_status=$row['post_status'];
    $post_category_id=$row['post_category_id'];

}

if(isset($_POST['update_post'])){
    $post_title= $_POST['title'];
    $username= $_POST['post_user'];
    $post_category_id= $_POST['post_category_id'];
    $post_status= $_POST['post_status'];
    $post_image= $_FILES['image'] ['name'];
    $post_image_temp= $_FILES['image'] ['tmp_name'];
    $post_tags= $_POST['post_tags'];
    $post_content= $_POST['post_content'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image)){
        $query="SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image= mysqli_query($connection,$query);

        while($row=mysqli_fetch_array($select_image)){
            $post_image = $row ['post_image'];
        }

    }
    

    $query="UPDATE posts SET post_title='{$post_title}', post_category_id='{$post_category_id}', post_date=now(), post_user='{$username}', post_status='{$post_status}', post_tags='{$post_tags}', post_content='{$post_content}', post_image='{$post_image}' WHERE post_id = {$the_post_id} ";

    $update_post= mysqli_query($connection,$query);

    echo "<p>Post Updated</p> . <a href'./post.php?p_id={$the_post_id}'>View Post</a>";
}

?>
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">

<input type="text" value="<?php echo $post_title; ?>" class="form-control" placeholder="Title" name="title">
</div>
<div class="form-group">

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
<div class="form-group">
    <label for="users">Users</label>
<select name="post_user" id="">
<?php
$query="SELECT * FROM users ";
$select_users_= mysqli_query($connection,$query); 

while($row=mysqli_fetch_assoc($select_users_)){
$username=$row['username'];
echo "<option value='$username'>$username</option>";
}

?>
<div class="form-group">

<div class="form-group">

<img width="100px" src="../images/<?php echo $post_image; ?>" alt="">
</div>

<div class="form-group">
    <input type="file"  name="image">
</div>

<div class="form-group">
<select name="post_status" id="">
    <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
    <?php
    if($post_status == 'published'){
        echo "<option value='draft'>Draft</option>";
    }else{
        echo "<option value='published'>Published</option>";
    }

?>
</select>

</div>


<input type="text" value="<?php echo $post_tags; ?>" class="form-control" placeholder="Post Tags" name="post_tags">
</div>
<div class="form-group">

<input type="text" value="<?php echo $post_content; ?>" class="form-control" placeholder="Content" name="post_content">
</div>
<input type="submit" value="Update" name="update_post">

</form>