<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>

<?php
    if (!isset($_GET['pageid']) || $_GET['pageid'] == NULL) {
        echo "<script>windows.location = 'index.php'; </script>";
        //header("Location:catlist.php");
    }else{
        $id = $_GET['pageid'];
    }
?>


<div class="grid_10">

    <div class="box round first grid">
        <h2>Edit Page</h2>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name    = mysqli_real_escape_string($db->link, $_POST['name']);
                $body    = mysqli_real_escape_string($db->link, $_POST['body']);

                if ($name == "" || $body == "" ) {
                    echo "<span class='error'>Field Must Not Be Empty !!</span>";
                }else{

                    $query = "UPDATE tbl_page 
                                SET 
                                name = '$name',
                                body = '$body'
                                WHERE id = '$id' ";
                    $upadate_rows = $db->update($query);

                    if ($upadate_rows) {
                        echo "<span class='success'>Page Updated Successfuly</span>";
                    }else{
                        echo "<span class='error'>Page Not Updated !</span>";
                    }
                }
            }
        ?>
        <div class="block"> 

    <?php
        $pageQuery = "SELECT * FROM tbl_page WHERE id='$id' ";
        $pagesDetails = $db->select($pageQuery);
        while ($result = $pagesDetails->fetch_assoc()) {
        if($pagesDetails){ ?> 

         <form action="" method="post">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $result['name']; ?>" class="medium" />
                    </td>
                </tr>
           
            
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Content</label>
                    </td>
                    <td>
                        <textarea class="tinymce" name="body"><?php echo $result['body']; ?></textarea>
                    </td>
                </tr>

    			<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                        <span class="actiondel"><a onclick="return confirm('Are sure to Delete the Page !');" href="delpage.php?delpage= <?php echo $result['id']; ?>">Delete</a></span>
                    </td>
                </tr>
            </table>
            </form>
        <?php } }?>
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




