<?php
if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $checkBoxvalue){
        
        $bulk_options=$_POST['bulk_options'];
        
        switch($bulk_options){
            case 'published':
                $query="UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '$checkBoxvalue' ";
                $update_to_publish=mysqli_query($connection,$query);
                break;
            case 'draft':
                $query="UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '$checkBoxvalue' ";
                $update_to_draft=mysqli_query($connection,$query);
                break;  
                case 'delete':
                    $query="DELETE FROM posts WHERE post_id = '$checkBoxvalue' ";
                    $update_to_delete=mysqli_query($connection,$query);
                    break;
                case 'clone':
                    $query="SELECT * FROM posts WHERE post_id = '{$checkBoxvalue}'";
                    $select_post_query=mysqli_query($connection,$query);

                    while($row=mysqli_fetch_array($select_post_query)){
                        $post_title=$row['post_title'];
                        $post_category_id=$row['post_category_id'];
                        $post_date=$row['post_date'];
                        $post_author=$row['post_author']; 
                        $post_user=$row['post_user'];
                        $post_status=$row['post_status'];
                        $post_image=$row['post_image'];
                        $post_tags=$row['post_tags'];
                        $post_content=$row['post_content'];
                    }
                    $query="INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_status, post_image, post_tags, post_content) VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}' , now() ,'{$post_status}' , '{$post_image}', '{$post_tags}', '{$post_content}') ";
                    $select_clone=mysqli_query($connection,$query);
                    break;
        }
    }
}

?>  

<form action="" method="post">
<table class="table table-bordered table-hover">
    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" value="Apply" class="btn btn-success" name="submit">
        <a href="posts.php?source=add_posts" class="btn btn-primary">Add New</a>
    </div>


                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllBoxes"></th>
                                    <th>Post</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query="SELECT * FROM posts ORDER BY post_id DESC ";
                                $select_posts= mysqli_query($connection,$query); 

                                while($row=mysqli_fetch_assoc($select_posts)){
                                    $post_id=$row['post_id'];
                                    $post_author=$row['post_author'];
                                    $post_user=$row['post_user'];
                                    $post_title=$row['post_title'];
                                    $post_date=$row['post_date'];
                                    $post_image=$row['post_image'];
                                    $post_comment_count=$row['post_comment_count'];
                                    $post_tags=$row['post_tags'];
                                    $post_status=$row['post_status'];
                                    $post_category_id=$row['post_category_id'];

                                    echo "<tr>";
                                    ?>
                                    <td><input name="checkBoxArray[]" value="<?php echo $post_id; ?>" class='checkBoxes' type='checkbox'></td>
                                    <?php
                                    echo "<td>$post_id</td>";
                                    
                                    if(!empty($post_author)){
                                        echo "<td> $post_author</td>";
                                    }else if((!empty($post_user))){
                                        echo "<td> $post_user</td>";
                                        
                                    }
                                    $query="SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
                                    $select_categories_= mysqli_query($connection,$query); 

                                    while($row=mysqli_fetch_assoc($select_categories_)){
                                    $cat_id=$row['cat_id'];
                                    $cat_title=$row['cat_title'];
                                    echo "<td>$post_title</td>";
                                    echo "<td>$cat_title</td>"; }

                                    echo "<td>$post_status</td>";
                                    echo "<td><img src='images/$post_image'></td>";
                                    echo "<td>$post_tags</td>";
                                        $query="SELECT * FROM comments WHERE comment_post_id = $post_id";
                                        $send_comment=mysqli_query($connection,$query);
                                        $count_coments=mysqli_num_rows($send_comment);

                                    echo "<td>$count_coments</td>";
                                    
                                    
                                    echo "<td>$post_date</td>";
                                    echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
                                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?')\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                                    echo "</tr>";
                                }
                                
                                ?>
                                

                            </tbody>
                        </table>
                        

                        <?php
                        if(isset($_GET['delete'])){
                            $the_post_id=$_GET['delete'];
                            $query="DELETE FROM posts WHERE post_id = {$the_post_id}";
                            $delete_query = mysqli_query($connection,$query);
                            header("Location: posts.php");
                        }
                        ?>
                        </form>