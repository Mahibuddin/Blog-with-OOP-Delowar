<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>

<?php
    $viewPost = mysqli_real_escape_string($db->link, $_GET['viewPostId']);
    if (!isset($viewPost) || $viewPost == NULL) {
        echo "<script>windows.location = 'postlist.php'; </script>";
        //header("Location:postlist.php");
    }else{
        $postId = $viewPost;
    }
?>

<div class="grid_10">

    <div class="box round first grid">
        <h2>Update Post</h2>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //echo "<script>windows.location = 'postlist.php'; </script>";
                //header("Location:postlist.php");
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=postlist.php">';    
exit;
            }
        ?>
        <div class="block"> 
        <?php
            $query = "SELECT * FROM  tbl_post WHERE id='$postId' ORDER BY id DESC";
            $post = $db->select($query);
            while ($postResult = $post->fetch_assoc()) {?>
                 
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Title</label>
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo $postResult['title']; ?>" class="medium" />
                    </td>
                </tr>
             
                <tr>
                    <td>
                        <label>Category</label>
                    </td>
                    <td>
                        <select id="select" >
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
                        <label>Image</label>
                    </td>
                    <td>
                        <input type="file" name="image" />
                        <div class="edit-img"><img src="<?php echo $postResult['image']; ?>" width="250px" height="150px" alt=""></div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Content</label>
                    </td>
                    <td>
                        <textarea class="tinymce" readonly>
                            <?php echo $postResult['content']; ?>
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Tags</label>
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo $postResult['tags']; ?>" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Author</label>
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo $postResult['author']; ?>" class="medium" />
                    </td>
                </tr>
    			<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Ok" />
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
