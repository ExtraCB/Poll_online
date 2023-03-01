<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$db -> checkAdmin();
$userid = $_SESSION['userid'];






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="./../../style/css/admin_hp.css">
    <script defer src="./../../style/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./../../style/css/bootstrap.css">


</head>

<body>
    <!--Main Navigation-->
    <header>
        <?php include('./../components/sidebar.php');?>
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main style="margin-top: 58px;">
        <div class="container pt-4">
            <div class="row">
                <?php
                $db_header = new database();
                $db_header -> select("poll_header","*","status_ph != 0");

                while($fetch_header = $db_header -> query -> fetch_object()){
                    $id_ph = $fetch_header -> id_ph;
                    $sumvote = new database();
                    $sumvote -> select("poll_header,poll_option,poll_status","COUNT(id_ps) as count,id_ps,po_ps","id_ph = $id_ph AND id_ph = ph_po AND id_po = po_ps");
                    $fetchsum_vote = $sumvote -> query -> fetch_assoc();
                ?>
                <div class="card my-3">
                    <h5 class="card-header"><?= $fetch_header -> text_ph ?></h5>
                    <div class="card-body">
                        <?php 
                        $db_option = new database();
                        $db_option -> selectjoin("poll_option","text_po,COUNT(poll_status.po_ps) as sum","LEFT JOIN poll_status","poll_option.ph_po = $id_ph","poll_option.id_po = poll_status.po_ps","poll_option.id_po");

                        while($fetch_option = $db_option -> query -> fetch_object()){
                            if($fetch_option -> sum != 0){
                                $percent = $fetch_option -> sum * 100 / $fetchsum_vote['count'];
                            }else{
                                $percent = 0;
                            }

                        ?>
                        <b><?= $fetch_option -> text_po ?></b>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percent ?>%;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="<?= $fetchsum_vote['count'] ?>"><?= $percent ?>%
                            </div>
                        </div>
                        <?php }  ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <!--Main layout-->
</body>


</html>