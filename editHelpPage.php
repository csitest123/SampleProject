<?php

include 'func.php';
checkSession();

$c = getDB();
$id = g("id");
$txt = qW1R("select txt from help_page where id = 1", null, $c)['txt'];
beginPage('Edit Help Page');

?>
<script src="http://cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='edit_help' />    

<div class='row mt-3 justify-content-center'>
    <div class='col-md-12 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Help</div>
            <div class='card-body' style="padding:0px">
                
                <textarea id="txt" name="txt"><?=$txt;?></textarea>
                
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>UPDATE</button>
            </div>
        </div>
    </div>
</div>
</form>
<?php
endPage();
?>
<script>
    CKEDITOR.replace('txt', { width: '100%', height: 530 });
</script>    
