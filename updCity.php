<?php

include 'func.php';
checkSession();

$c = getDB();
$id = g("id");
$r = qW1R("select * from cities where id = $id", null, $c);
beginPage('Edit City');

?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='upd_city' />    
<input type='hidden' name='id' value='<?=$id;?>' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit City</div>
            <div class='card-body'>
                City Name
                <input type='text' class='form-control mt-1 mb-3' id='city_name' name='city_name' required value="<?=$r['city_name'];?>"/>
                
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>UPDATE</button>
                <button type='button' id="btnDel" class='btn btn-danger'>DELETE</button>
            </div>
        </div>
    </div>
</div>
</form>
<?php
endPage();
?>

<script>

$("#btnDel").click(function()
{
    var o = confirm("Are You Sure ?");
    if (o)
    {
        $.post("op.php", { op : "del_city", id : <?=$id;?> }, function(d,s) { location.href = "listCities.php" } );
    }
});        
    
</script> 

