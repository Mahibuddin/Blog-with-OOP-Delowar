<?php 
    include "inc/header.php"; 
    include "inc/sidebar.php";
?>

<?php   // Every User can access the add user, that why: assign this...
    if (Session::get('userRole') !== '0') {   // Add User only assign for Admin
        //echo "<script>windows.location = 'index.php'; </script>";
        //header("Location:index.php");
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';    
exit;
    }
?>

        <div class="grid_10">
        
            <div class="box round first grid">
                <h2>Add New User</h2>
               <div class="block copyblock">
               <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $username = $fm->validation($_POST['username']);
                        $password = $fm->validation(md5($_POST['password']));
                        $email    = $fm->validation($_POST['email']);
                        $role     = $fm->validation($_POST['role']);

                        $username = mysqli_real_escape_string($db->link, $username);
                        $password = mysqli_real_escape_string($db->link, $password);
                        $email    = mysqli_real_escape_string($db->link, $email);
                        $role     = mysqli_real_escape_string($db->link, $role);

                        if (empty($username) || empty($password) || empty($email ) || empty($role ) ) {
                            echo "<span class='error'>Field Must Not Be Empty !!</span>";
                        }else{
                            $mailquery = "SELECT * FROM tbl_user WHERE email = '$email' limit 1";
                            $mailcheck = $db->select($mailquery);
                            if ($mailcheck != false) {
                                echo "<span class='error'>Email Already Exist !!</span>";
                            }else{
                                $query = "INSERT INTO tbl_user(username, password, email, role) VALUES ('$username', '$password', '$email', '$role') ";
                                $userInsert = $db->insert($query);
                                if ($userInsert) {
                                    echo "<span class='success'>User Inserted Successfuly.</span>";
                                }else{
                                    echo "<span class='error'>User Not Inserted !!</span>";
                                }
                            }
                        } 
                    }
                ?> 
                 <form action="" method="post">
                    <table class="form">                    
                        <tr>
                            <td>
                                <label for="">Username</label>
                            </td>
                            <td>
                                <input type="text" name="username" placeholder="Enter User Name..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Password</label>
                            </td>
                            <td>
                                <input type="text" name="password" placeholder="Enter Password..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Email</label>
                            </td>
                            <td>
                                <input type="text" name="email" placeholder="Enter Valid Email Address..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">User Role</label>
                            </td>
                            <td>
                                <select name="role" id="select">
                                    <option>Select User Role</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Author</option>
                                    <option value="2">Editor</option>
                                </select>
                            </td>
                        </tr>
                        <tr> 
                            <td></td>
                            <td>
                                <input type="submit" name="submit" Value="Create" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>

<?php include "inc/footer.php"; ?>