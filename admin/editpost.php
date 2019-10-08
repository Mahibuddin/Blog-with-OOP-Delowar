<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>

<?php
    $editPost = mysqli_real_escape_string($db->link, $_GET['editPostId']);
    if (!isset($editPost) || $editPost == NULL) {
        echo "<script>windows.location = 'postlist.php'; </script>";
        //header("Location:catlist.php");
    }else{
        $postId = $editPost;
    }
?>

<div class="grid_10">

    <div class="box round first grid">
        <h2>Update Post</h2>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $title    = mysqli_real_escape_string($db->link, $_POST['title']);
                $cat      = mysqli_real_escape_string($db->link, $_POST['cat']);
                $content  = mysqli_real_escape_string($db->link, $_POST['content']);
                $tags     = mysqli_real_escape_string($db->link, $_POST['tags']);
                $author   = mysqli_real_escape_string($db->link, $_POST['author']);
                $userid   = mysqli_real_escape_string($db->link, $_POST['userid']);

                $permited  = array('jpg', 'jpeg', 'png', 'gif');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_temp = $_FILES['image']['tmp_name'];

                $div             = explode('.', $file_name);
                $file_ext        = strtolower(end($div)) ; // Catch to file extention.
                $unique_img_name = substr(md5(time()), 0, 10).'.'.$file_ext;
                $uploaded_image  = "uploads/".$unique_img_name;

                if ($title == "" || $cat == "" || $content == "" || $tags == "" || $author == "" ) {
                    echo "<span class='error'>Field Must Not Be Empty !!</span>";
                }else{

                if (!empty($file_name)) {

                    if ($file_size > 1048576) {
                        echo "<span class='error'>Image Size Should Be Less Then 1 MB.</span>";
                    }elseif (in_array($file_ext, $permited) === false) {
                        echo "<span class='error'>You Can Upload Only :- ".implode(', ', $permited)."</span>";
                    }else{

                        move_uploaded_file($file_temp, $uploaded_image);

                        $query = "UPDATE tbl_post 
                        SET
                        cat     = '$cat',
                        title   = '$title',
                        content = '$content',
                        image   = '$uploaded_image',
                        author  = '$author',
                        tags    = '$tags',
                        userid    = '$userid'
                        WHERE id= '$postId' ";

                        $updated_rows = $db->update($query);
                        if ($updated_rows) {
                            echo "<span class='success'>Data Updated Successfuly</span>";
                        }else{
                            echo "<span class='error'>Data Not Updated !</span>";
                        }
                    }

                }else{
                    $query = "UPDATE tbl_post 
                        SET
                        cat     = '$cat',
                        title   = '$title',
                        content = '$content',
                        author  = '$author',
                        tags    = '$tags',
                        userid    = '$userid'
                        WHERE id= '$postId' ";

                        $updated_rows = $db->update($query);
                        if ($updated_rows) {
                            echo "<span class='success'>Data Updated Successfuly</span>";
                        }else{
                            echo "<span class='error'>Data Not Updated !</span>";
                        }
                    }
                }
            }
        ?>
        <div class="block"> 
        <?php
            $query = "SELECT * FROM  tbl_post WHERE id='$postId' ";
            $post = $db->select($query);
            while ($postResult = $post->fetch_assoc()) {?>
                 
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Title</label>
                    </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $postResult['title']; ?>" class="medium" />
                    </td>
                </tr>
             
                <tr>
                    <td>
                        <label>Category</label>
                    </td>
                    <td>
                        <select id="select" name="cat">
                            <option>Select Category</option>
                            <?php
                                $query = "SELECT * FROM tbl_category";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) { ?>

                            <option 
                                <?php if ($postResult['cat'] == $result['id']){ ?>
                                    selected = "selected";
                               <?php } ?>
                                value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></option>

                            <?php } }?>
                        </select>
                    </td>
                </tr>
           
            
                <tr>
                    <td>
                        <label>Date Picker</label>
                    </td>
                    <td>
                        <input type="text" id="date-picker" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <input type="file" name="image" />
                        <div class="edit-img"><img src="<?php echo $postResult['image']; ?>" width="200px" height="100px" alt=""></div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Content</label>
                    </td>
                    <td>
                        <textarea class="tinymce" name="content">
                            <?php echo $postResult['content']; ?>
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Tags</label>
                    </td>
                    <td>
                        <input type="text" name="tags" value="<?php echo $postResult['tags']; ?>" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Author</label>
                    </td>
                    <td>
                        <input type="text" name="author" value="<?php echo $postResult['author']; ?>" class="medium" />

                        <input type="hidden" name="userid" value="<?php echo Session::get('userId');?>" class="medium" />
                    </td>
                </tr>
    			<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>

        <?php }?>
        </div>
    </div>
</div>

     <!-- Load TinyMCE -->
    <script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setupTinyMCE();
            setDatePicker('date-picker');
            $('input[type="checkbox"]').fancybutton();
            $('input[type="radio"]').fancybutton();
        });
    </script>       
<?php include "inc/footer.php"; ?>
