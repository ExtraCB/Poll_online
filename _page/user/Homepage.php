<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$userid = $_SESSION['userid'];

 if(isset($_POST['selected'])){
    $value = $_POST['value'];

    $data = [
        'own_ps' => $userid,
        'po_ps' => $value
    ];

    $db -> insert("poll_status",$data);

    if($db -> query){
        $_SESSION['success'] = "Select Successfully";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Select Error ";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }
 }



 if(isset($_POST['edit'])){
    $value = $_POST['value'];
    $id_ps = $_POST['id_ps'];

    echo $id_ps;


    $data = [
        'po_ps' => $value
    ];

    $db -> update("poll_status",$data,"id_ps = $id_ps");

    if($db -> query){
        $_SESSION['success'] = "Edit Successfully";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Edit Error ";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }

 }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <script defer src="./../../style/js/bootstrap.bundle.js"></script>
    <script src="./../../style/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./../../style/css/bootstrap.css">


</head>

<body>
    <!--Main Navigation-->
    <header>
        <?php  include('./../components/navbar_user.php'); ?>
    </header>
    <!--Main layout-->
    <main style="margin-top: 58px;">
        <div class="container pt-4">
            <div class="row">
                <?php  include('./../components/error.php'); ?>
            </div>
            <div class="row">
                <?php
                $db_header = new database();
                $db_header -> select("poll_header","*","status_ph != 0");

                while($fetch_header = $db_header -> query -> fetch_object()){
                ?>
                <div class="card my-3">
                    <h5 class="card-header"><?= $fetch_header -> text_ph ?></h5>
                    <div class="card-body">
                        <?php include('./../components/modal_vote.php'); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
</body>


</html>