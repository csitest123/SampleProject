<?php

include 'func.php';
checkSession();
$c = getDB();
$id = g("id");
$r = qW1R("select * from categories where id = $id", null, $c);

beginPage('Edit Category');
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='upd_category' />    
<input type='hidden' name='id' value='<?=$id;?>' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Category</div>
            <div class='card-body'>
                Category Name
                <input type='text' class='form-control mt-1 mb-3' id='cat_name' name='cat_name' required value="<?=$r['cat_name'];?>"/>
                Image <?php if ($r['cat_img'] != "") { ?> <span style="float:right"><a href="<?=$r['cat_img'];?>" target="_blank">View Image</a></span> <?php } ?>
                <input type='file' accept="image/*" class='form-control mt-1 mb-3' id='img' name='img'   data-toggle="tooltip" title="If You Leave This Empty, Current Image Won't Be Deleted Or Updated" />
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>UPDATE</button>
                <button type='submit' id="btnDel" class='btn btn-danger'>DELETE</button>
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
        $.post("op.php", { op : "del_category", id : <?=$id;?> }, function(d,s) { location.href = "listCategories.php" } );
    }
});        
    
</script>    