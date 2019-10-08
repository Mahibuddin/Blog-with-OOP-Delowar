<?php include "inc/header.php"; ?>

<?php
    $pageId = mysqli_real_escape_string($db->link, $_GET['pageid']);
    if (!isset($pageId ) || $pageId  == NULL) {
        echo "<script>windows.location = '404.php'; </script>";
        //header("Location:catlist.php");
    }else{
        $id = $pageId ;
    }
?>

<?php
        $pageQuery = "SELECT * FROM tbl_page WHERE id='$id' ";
        $pagesDetails = $db->select($pageQuery);
        if($pagesDetails){ 
        while ($result = $pagesDetails->fetch_assoc()) {?> 

	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
				<h2><?php echo $result['name']; ?></h2>
	
				<?php echo $result['body']; ?>
			</div>
		</div>
<?php } }else{header("Location:404.php");} ?>

<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>