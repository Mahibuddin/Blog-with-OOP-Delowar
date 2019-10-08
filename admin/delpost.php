<?php
    include "../lib/Session.php";
    Session::checkSession();
?>

<?php
    include "../config/config.php"; 
    include "../lib/Database.php"; 
    include "../helpers/Format.php"; 
    $db = new Database();
?>

<?php
    $delPost = mysqli_real_escape_string($db->link, $_GET['delPostId']);
    if (!isset($delPost) || $delPost == NULL) {
        echo "<script>windows.location = 'postlist.php'; </script>";
        //header("Location:catlist.php");
    }else{
        $postId = $delPost;

        // Delete Image from folder/path location

        $query = "SELECT * FROM tbl_post WHERE id = '$postId' ";
        $getData = $db->select($query);
        if ($getData) {
        	while ($delimg = $getData->fetch_assoc()) {
        		$dellink = $delimg['image'];
        		unlink($dellink);
        	}
        }

        $delquery = "DELETE FROM tbl_post WHERE id='$postId' ";
        $delData = $db->delete($delquery);
        if ($delData) {
        	echo "<script>alert('Data Deleted Successfully.');</script>";
        	//echo "<script>windows.location = 'postlist.php'; </script>";    // kajkorse na...
        	header("Location:postlist.php");
        }else{
        	echo "<script>alert('Data Not Deleted.');</script>";
        	echo "<script>windows.location = 'postlist.php'; </script>";
        }
    }
?>