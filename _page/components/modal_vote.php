<div class="">

    <a href="" class="btn btn-primary btn-rounded mb-4" data-bs-toggle="modal"
        data-bs-target="#vote<?= $fetch_header -> id_ph ?>">Show Details</a>
</div>
<form action="" method="post">
    <div class="modal fade" id="vote<?= $fetch_header -> id_ph ?>" data-bs-keyboard="false" data-bs-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Poll Option</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>


                <div class="modal-body mx-3">
                    <?php 
                            $id_ph = $fetch_header -> id_ph;
                            $dbcheck = new database();
                            $dbcheck -> select("poll_header,poll_option,poll_status","COUNT(id_ps) as count,id_ps,po_ps","id_ph = $id_ph AND id_ph = ph_po AND id_po = po_ps AND own_ps = $userid");
                            $result = $dbcheck -> query;
                            $fetch_check = $result -> fetch_assoc();


                            $db5 = new database();
                            $db5 -> select("poll_option","*","ph_po = $id_ph");
                            while($fetch_option = $db5 -> query -> fetch_object()) {
                            ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="value" value="<?= $fetch_option -> id_po; ?>"
                            id="flexRadioDefault1"
                            <?= ($fetch_check['po_ps'] == $fetch_option -> id_po ? "checked" : "") ?>>
                        <label class="form-check-label" for="flexRadioDefault1">
                            <?= $fetch_option -> text_po ?>
                        </label>
                    </div>
                    <?php } ?>
                </div>
                <div class="modal-footer px-4 d-flex justify-content-between">
                    <?php 
                if($fetch_check['count'] != 0){ ?>
                    <input type="hidden" name="id_ps" value="<?= $fetch_check['id_ps'] ?>">
                    <button class="btn btn-warning" name="edit">Edit</button>
                    <?php }else{ ?>
                    <button class="btn btn-warning" name="selected">Selected</button>
                    <?php }
                ?>

                </div>


            </div>
        </div>
    </div>
</form>