<form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Update</label>
                                    <?php
                                    if(isset($_GET['update'])){

                                    $cat_id=$_GET['update'];
                                    $query="SELECT * FROM categories WHERE cat_id = $cat_id ";
                                    $select_categories_= mysqli_query($connection,$query); 

                                    while($row=mysqli_fetch_assoc($select_categories_)){
                                    $cat_id=$row['cat_id'];
                                    $cat_title=$row['cat_title'];

                                    ?>
                                    <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">
                                    <?php
                                    } }?>

                                    <?php
                                    if(isset($_POST['update_category'])){
                                        $the_cat_id = $_POST['cat_title'];
                                        $query = "UPDATE categories SET cat_title = '{$the_cat_id}' WHERE cat_id = {$cat_id} ";
                                        $borrar_query=mysqli_query($connection,$query);
                                        header("Location: categories.php");
                                    }
                                    ?>

                                    
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Update" class="btn btn-primary" name="update_category">
                                </div>
                            </form>