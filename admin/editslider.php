<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>

<?php
    $editSlider = mysqli_real_escape_string($db->link, $_GET['editSliderId']);
    if (!isset($editSlider) || $editSlider == NULL) {
        echo "<script>windows.location = 'sliderlist.php'; </script>";
        //header("Location:catlist.php");
    }else{
        $sliderId = $editSlider;
    }
?>

<div class="grid_10">

    <div class="box round first grid">
        <h2>Update Slider</h2>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $title    = mysqli_real_escape_string($db->link, $_POST['title']);

                $permited  = array('jpg', 'jpeg', 'png', 'gif');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_temp = $_FILES['image']['tmp_name'];

                $div             = explode('.', $file_name);
                $file_ext        = strtolower(end($div)) ; // Catch to file extention.
                $unique_img_name = substr(md5(time()), 0, 10).'.'.$file_ext;
                $uploaded_image  = "uploads/slider/".$unique_img_name;

                if ($title == "" ) {
                    echo "<span class='error'>Field Must Not Be Empty !!</span>";
                }else{

                if (!empty($file_name)) {

                    if ($file_size > 1048576) {
                        echo "<span class='error'>Image Size Should Be Less Then 1 MB.</span>";
                    }elseif (in_array($file_ext, $permited) === false) {
                        echo "<span class='error'>You Can Upload Only :- ".implode(', ', $permited)."</span>";
                    }else{

                        move_uploaded_file($file_temp, $uploaded_image);

                        $query = "UPDATE tbl_slider 
                        SET
                        title   = '$title',
                        image   = '$uploaded_image'
                        WHERE id= '$sliderId' ";

                        $updated_rows = $db->update($query);
                        if ($updated_rows) {
                            echo "<span class='success'>Slider Updated Successfuly</span>";
                        }else{
                            echo "<span class='error'>Slider Not Updated !</span>";
                        }
                    }

                }else{
                    $query = "UPDATE tbl_slider 
                        SET
                        title   = '$title'
                        WHERE id= '$sliderId' ";

                        $updated_rows = $db->update($query);
                        if ($updated_rows) {
                            echo "<span class='success'>Slider Updated Successfuly</span>";
                        }else{
                            echo "<span class='error'>Slider Not Updated !</span>";
                        }
                    }
                }
            }
        ?>
        <div class="block"> 
        <?php
            $query = "SELECT * FROM  tbl_slider WHERE id='$sliderId' ";
            $slider = $db->select($query);
            while ($sliderResult = $slider->fetch_assoc()) {?>
                 
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Slider Title</label>
                    </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $sliderResult['title']; ?>" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <input type="file" name="image" />
                        <div class="edit-img"><img src="<?php echo $sliderResult['image']; ?>" width="250px" height="100px" alt=""></div>
                    </td>
                </tr>

    			<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Updated" />
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
