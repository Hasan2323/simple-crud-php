<?php
    include('server.php');
    if(!isset($_SESSION)) session_start();

    //fetch the record to be updated
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];

        $singleRec = mysqli_query($db, "SELECT * FROM info WHERE id=$id");
        $records = mysqli_fetch_array($singleRec);
        $name = $records['name'];
        $address = $records['address'];
        $edit_state = true;
    }

?>


<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>How to Create, Delete, update Database records: Php and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>



    <?php if(isset($_SESSION['msg'])): ?>
        <div class="msg">
            <?php
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            ?>
        </div>
    <?php endif; ?>



    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Picture</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>

        
        <?php while($row = mysqli_fetch_array($results)){ ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['address']; ?></td>
                <td><?php
                        echo "<div style='border: 1px solid black;'>";
                            echo "<img style=\"width:100px;height:100px;\" src='UploadedImages/".$row['image']."'>";
                        echo "</div>";
                    ?>
                </td>


                <td>
                    <a href="index.php?edit=<?= $row['id']; ?>">Edit</a>
                </td>
                <td>
                    <a href="server.php?del=<?= $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <form action="server.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="input-group">
            <label for="name">Name: </label>
            <input type="text" name="name" value="<?= $name; ?>" required>
        </div>
        <div class="input-group">
            <label for="address">Address: </label>
            <input type="text" name="address" value="<?= $address; ?>" required>
        </div>

        <div class="input-group">
            <label for="image">Picture: </label>
            <input type="file" name="image"  required>
        </div>

        <div class="input-group">
            <?php if ($edit_state == false): ?>
                <button type="submit" name="save" class="btn">Save</button>
            <?php else: ?>
                <button type="submit" name="update" class="btn">Update</button>
            <?php endif; ?>
        </div>
    </form>

</body>
</html>