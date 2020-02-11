<?php
    if(!isset($_SESSION)) session_start();

    //initialize variables
    $name="";
    $address="";
    $image="";
    $id=0;
    $edit_state= false;

    //connect to database
    $db= mysqli_connect('localhost','root', '','crudsingle');

    //if save button is clicked
    if(isset($_POST['save'])){
        $name = $_POST['name'];
        $address = $_POST['address'];

        $fileName= time().$_FILES['image'] ['name'];

        $source = $_FILES['image'] ['tmp_name'];

        $destination= "UploadedImages/".$fileName;

        move_uploaded_file($source,$destination);

        $query = "INSERT INTO info (name,address,image) VALUE ('$name', '$address','$fileName')";
        mysqli_query($db, $query);
        $_SESSION['msg'] = "Data inserted successfully!";
        header('location: index.php'); //redirect to index page after inserting


    }

    //Update records
    if(isset($_POST['update'])){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $id= $_POST['id'];

        $fileName= time().$_FILES['image'] ['name'];

        $source = $_FILES['image'] ['tmp_name'];

        $destination= "UploadedImages/".$fileName;

        move_uploaded_file($source,$destination);

        mysqli_query($db, "UPDATE info SET name='$name', address='$address', image='$fileName' WHERE id=$id");
        $_SESSION['msg'] = "Data updated successfully!";
        header('location: index.php');
    }

    //delete records
    if(isset($_GET['del'])){
        $id= $_GET['del'];
        mysqli_query($db, "UPDATE info SET is_deleted=NOW() WHERE id =$id");
        $_SESSION['msg'] = "Data deleted successfully!";
        header('location: index.php');
    }


    //retrieve records
    $results = mysqli_query($db, "SELECT * FROM info WHERE is_deleted='No'");