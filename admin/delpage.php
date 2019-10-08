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
$delPage = mysqli_real_escape_string($db->link, $_GET['delpage']);
    if (!isset($delPage ) || $delPage  == NULL) {
        echo "<script>windows.location = 'index.php'; </script>";
        //header("Location:catlist.php");
    }else{
        $pageId = $delPage;

        $delquery = "DELETE FROM tbl_page WHERE id='$pageId' ";
        $delData = $db->delete($delquery);
        if ($delData) {
        	echo "<script>alert('Page Deleted Successfully.');</script>";
        	//echo "<script>windows.location = 'postlist.php'; </script>";    // kajkorse na...
        	header("Location:index.php");
        }else{
        	echo "<script>alert('Page Not Deleted.');</script>";
        	echo "<script>windows.location = 'index.php'; </script>";
        }
    }
?>