<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Category List</h2>
                <?php
                	if (isset($_GET['delId'])) {
                        $delId = mysqli_real_escape_string($db->link, $_GET['delId']);
                		$delQuery = "DELETE FROM tbl_category WHERE id='$delId'";
                		$delData = $db->delete($delQuery);
                        if ($delData) {
                            echo "<span class='success'>Category Deleted Successfuly.</span>";
                        }else{
                            echo "<span class='error'>Category Not Deleted !!</span>";
                        }
                	}
                ?>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = "SELECT * FROM tbl_category ORDER BY id DESC";  // List niye kaj korate order by....
							$category = $db->select($query);
							if ($category) {
								$i=0;
								while ($result = $category->fetch_assoc()) {
									$i++;
						?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result['name'];?></td>
							<td><a href="editcat.php?catId=<?php echo $result['id'];?>">Edit</a> || <a onclick="return confirm('Are sure to Delete !');" href="?delId=<?php echo $result['id'];?>">Delete</a></td>
						</tr>
						<?php 	} }?>
						
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


