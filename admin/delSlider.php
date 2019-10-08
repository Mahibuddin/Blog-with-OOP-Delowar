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
    $delSlider = mysqli_real_escape_string($db->link, $_GET['delSliderId']);
    if (!isset($delSlider) || $delSlider == NULL) {
        echo "<script>windows.location = 'sliderlist.php'; </script>";
        //header("Location:sliderlist.php");
    }else{
        $sliderId = $delSlider;

        // Delete Image from folder/path location

        $query = "SELECT * FROM tbl_slider WHERE id = '$sliderId' ";
        $getData = $db->select($query);
        if ($getData) {
        	while ($delimg = $getData->fetch_assoc()) {
        		$dellink = $delimg['image'];
        		unlink($dellink);
        	}
        }

        $delquery = "DELETE FROM tbl_slider WHERE id='$sliderId' ";
        $delData = $db->delete($delquery);
        if ($delData) {
        	echo "<script>alert('Data Deleted Successfully.');</script>";
        	//echo "<script>windows.location = 'sliderlist.php'; </script>";    // kajkorse na...
        	header("Location:sliderlist.php");
        }else{
        	echo "<script>alert('Data Not Deleted.');</script>";
        	echo "<script>windows.location = 'sliderlist.php'; </script>";
        }
    }
?>