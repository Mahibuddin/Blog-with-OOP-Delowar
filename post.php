<?php include "inc/header.php"; ?>

	<?php
		$postId = mysqli_real_escape_string($db->link, $_GET['id']);
		if (!isset($postId) || $postId == NULL) {
			header("Location:404.php");
		}else{
			$id = $postId;
		}
	?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">

			<?php
				$query = "SELECT * FROM  tbl_post Where id = $id";
				$post = $db->select($query);
				if ($post) {
					while ($result = $post->fetch_assoc()) {
			?>

				<h2><?php echo $result['title']; ?></h2>
				<h4><?php echo $fm->formatDate($result['date']); ?>, By <a href="#"><?php echo $result['author'];	?></a></h4>
				<img src="admin/<?php echo $result['image']; ?>" alt="post image"/>
				<p><?php echo $result['content']; ?></p>
				
				<div class="relatedpost clear">
					<h2>Related articles</h2>
					<?php
						$catId = $result['cat'];
						$queryRelated = "SELECT * FROM  tbl_post WHERE cat=$catId ORDER BY rand() limit 6";
						$postRelted = $db->select($queryRelated);
						if ($catId) {
							while ($rresult = $postRelted->fetch_assoc()) {
					?>
					<a href="post.php?id=<?php echo $rresult['id']; ?>"><img src="admin/<?php echo $rresult['image']; ?>" alt="post image"/></a>
					<?php } }else{"There is No Related Post Available !!";} ?>
				</div>
			<?php } }else{header("Location:404.php");} ?>
			</div>
		</div>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>