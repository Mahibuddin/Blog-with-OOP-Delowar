<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>

<?php
    if (!isset($_GET['replyid']) || $_GET['replyid'] == NULL) {
        echo "<script>windows.location = 'inbox.php'; </script>";
        //header("Location:catlist.php");
    }else{
        $id = $_GET['replyid'];
    }
?>

<div class="grid_10">

    <div class="box round first grid">
        <h2>View Message</h2>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { 


                $to      = $fm->validation($_POST['toEmail']);
                $from    = $fm->validation($_POST['fromEmail']);
                $sub     = $fm->validation($_POST['subject']);
                $message = $fm->validation($_POST['message']);

                $to       = mysqli_real_escape_string($db->link, $to);
                $from     = mysqli_real_escape_string($db->link, $from);
                $sub      = mysqli_real_escape_string($db->link, $sub);
                $message  = mysqli_real_escape_string($db->link, $message);

                $sendmail = mail($to, $sub, $message, $from);
                if ($sendmail) {
                    echo "<span class='success'>Message Sent Successfuly. </span>";
                }else{
                    echo "<span class='error'>Somethings went wrong !</span>";
                }
            }
        ?>
        <div class="block">               
         <form action="" method="POST">

            <?php
                $query = "SELECT * FROM tbl_contact WHERE id='$id' ";
                $msg = $db->select($query);
                if ($msg) {
                while ($result = $msg->fetch_assoc()) {
            ?>
            <table class="form">
               

                <tr>
                    <td>
                        <label>To Email</label>
                    </td>
                    <td>
                        <input type="text" readonly name="toEmail" value="<?php echo $result['email']; ?>" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>From Email</label>
                    </td>
                    <td>
                        <input type="text" name="fromEmail" placeholder="Please Enter Your Email Address" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Subject</label>
                    </td>
                    <td>
                        <input type="text" name="subject" placeholder="Please Enter Subject" class="medium" />
                    </td>
                </tr>
           
            
                <tr>
                    <td>
                        <label>Message</label>
                    </td>
                    <td>
                        <textarea class="tinymce"  name="message"> </textarea>
                    </td>
                </tr>

    			<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Send" />
                    </td>
                </tr>
            </table>
        <?php } } ?>
            </form>
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




