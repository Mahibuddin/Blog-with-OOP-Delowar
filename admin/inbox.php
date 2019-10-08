<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>


<div class="grid_10">
    <div class="box round first grid">
        <h2>Inbox</h2>

        <?php
		    if (isset($_GET['seenid']) ) {
		    	$seenid = mysqli_real_escape_string($db->link, $_GET['seenid']);
		    	
		        $query = "UPDATE tbl_contact SET status = '1' WHERE id = '$seenid' ";
	                $upadate_row = $db->update($query);
	                if ($upadate_row) {
	                    echo "<span class='success'>Message sent in the seen box</span>";
	                }else{
	                    echo "<span class='error'>Message not sent seen box !!</span>";
	            }
		    }
		?>
        <div class="block">        
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Serial No.</th>
					<th>Name</th>
					<th>Email</th>
					<th>Message</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
					$query = "SELECT * FROM tbl_contact WHERE status='0' ORDER BY id DESC";
					$msg = $db->select($query);
					if ($msg) {
						$i=0;
					while ($result = $msg->fetch_assoc()) {
							$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['firstname'].' '.$result['lastname']; ?></td>
					<td><?php echo $result['email']; ?></td>
					<td><?php echo $fm->textShorten($result['body'], 30); ?></td>
					<td><?php echo $fm->formatDate($result['date']); ?></td>
					<td>
						<a href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a> || 
						<a href="replymsg.php?replyid=<?php echo $result['id']; ?>">Reply</a> || 
						<a onclick="return confirm('Are you sure to Move the Message in to the seen box !');" href="?seenid=<?php echo $result['id']; ?>">Seen</a></td>
				</tr>
				<?php } } ?>
			</tbody>
		</table>
       </div>
    </div>

    <div class="box round first grid">
        <h2>Seen Message</h2>

        <?php
        	if (isset($_GET['delid'])) {
        		$delId = $_GET['delid'];
        		$delQuery = "DELETE FROM tbl_contact WHERE id='$delId'";
        		$delData = $db->delete($delQuery);
                if ($delData) {
                    echo "<span class='success'>Message Deleted Successfuly.</span>";
                }else{
                    echo "<span class='error'>Message Not Deleted !!</span>";
                }
        	}
        ?>
        <div class="block">        
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Serial No.</th>
					<th>Name</th>
					<th>Email</th>
					<th>Message</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

				<?php
					$query = "SELECT * FROM tbl_contact WHERE status='1' ORDER BY id DESC";
					$msg = $db->select($query);
					if ($msg) {
						$i=0;
					while ($result = $msg->fetch_assoc()) {
							$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['firstname'].' '.$result['lastname']; ?></td>
					<td><?php echo $result['email']; ?></td>
					<td><?php echo $fm->textShorten($result['body'], 30); ?></td>
					<td><?php echo $fm->formatDate($result['date']); ?></td>
					<td>
						<a href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a> ||
						<a onclick="return confirm('Are you sure to Move the Message !');" href="?delid=<?php echo $result['id']; ?>">Delete</a></td>
				</tr>
				<?php } } ?>
				
			</tbody>
		</table>
       </div>
    </div>
</div>

    <script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
            setSidebarHeight();


        });
    </script>
<?php include "inc/footer.php"; ?>


