<?php include('../partials/menu.php');?>

<!--Main Contect-->
<section id="main-content">
    <h1 id="title">Manage Category</h1>

    <a href="add-category.php" id="btn-add">Add Category</a>

        <form action='' method='post' encrypt='multipart/form-data'>
            <table id='fliter'>
                <tr>
                    <td>
                        <span id='fliter-title'>Title:</span>
                        <input type='text' name='fliter-title' id='fliter-inputfield' placeholder='Input Title'>
                    </td>

                    <td>
                    <span id='fliter-title'>Featured:</span>
                        <select name='fliter-featured' id='fliter-select'>
                            <option value="">-</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                    </td>

                    <td>
                    <span id='fliter-title'>Active:</span>
                        <select name='fliter-active' id='fliter-select'>
                            <option value="">-</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </td>

                    <td>
                        <input type='submit' name='fliter-submit' id='btn-primary' value='Search'>
                    </td>
                </tr>
            </table>
        </form>

        <table id="tables">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>

            <?php
                
                $sql_query = "SELECT * FROM tbl_category";

                if(isset($_POST['fliter-submit']))
                {
                    $fliter_title = mysqli_real_escape_string($con, $_POST['fliter-title']);
                    $fliter_featured = $_POST['fliter-featured'];
                    $fliter_active = $_POST['fliter-active'];

                    $sql_query = "SELECT * FROM `tbl_category`";

                    // Insert String to Query while any inputfield not null
                    if($fliter_title != "" || $fliter_featured != "" || $fliter_active != "")
                    {
                        $sql_query .= " WHERE";

                        // Insert String to Query while fliter_title not null
                        if($fliter_title != "")
                        {
                            $sql_query .= " `title` LIKE '%$fliter_title%'";                        // Insert string to query while title is not null
                        }

                        // Insert String to Query while fliter_featured not null
                        if($fliter_featured != "")
                        {
                            if($fliter_title != "")
                            {
                                $sql_query .= " AND";                        // Insert 'AND' to query while title are not null
                            }
                                                
                            $sql_query .= " `featured` = '$fliter_featured'";                   // Insert string to query while other input is not null
                        }

                        // Insert String to Query while fliter_active not null
                        if($fliter_active != "")
                        {
                            if($fliter_title != "" || $fliter_featured != "")
                            {
                                $sql_query .= " AND";                         // Insert 'AND' to query while other input are not null
                            }

                            $sql_query .= " `active` = '$fliter_active'";                     // Insert string to query while $fliter_active input is not null
                            
                        }
                    }
                }

                $res = mysqli_query($con, $sql_query);

                $num = 1;

                if($res == true)
                {
                    $rows = mysqli_num_rows($res);

                    if($rows > 0)
                    {
                            
                        while($rows = mysqli_fetch_assoc($res))
                        {
                            $id = $rows['id'];
                            $title = $rows['title'];
                            $image_name = $rows['image_name'];
                            $featured = $rows['featured'];
                            $active = $rows['active'];
                        ?>
                        <tr>
                            <td><?php echo $num++;?></td>
                            <td><?php echo $title;?></td>
                            <td><?php 
                                if($image_name != "")
                                {
                                    ?>
                                    <img src='../img/category/<?php echo $image_name;?>' alt='' width='250px' height='150px'>
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $featured;?></td>
                            <td><?php echo $active;?></td>
                            <td>
                                <a href="update-category.php?id=<?php echo $id;?>" id='btn-secondary'>Update Category</a>
                                <a href="../api/delete-category-api.php?id=<?php echo $id?>&image_name=<?php echo "$image_name"?>" id='btn-danger'>Delete Category</a>
                            </td>
                        </tr>
                        <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            There are no category in database
                            <td>N/A</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <?php
                    }
                }
            ?>
        </table>
</section>

<?php include('../partials/footer.php')?>