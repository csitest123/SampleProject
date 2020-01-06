<?php

include 'func.php';
checkSession();
$id = g("id");
$c = getDB();
$r = qW1R("select * from pre_defined_items where id = $id", null, $c);
beginPage('Edit Pre Defined Item');
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='upd_pre_defined_item' />    
<input type='hidden' name='id' value='<?=$id;?>' />
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Pre Defined Item</div>
            <div class='card-body'>
                
                Item Name
                <input type='text' class='form-control mt-1 mb-3' id='item_name' name='item_name' required  value='<?=$r['item_name'];?>' />
                
                Item Image <?php if ($r['item_img'] != "") { ?> <span style='float:right'><a href='<?=$r['item_img'];?>' target='_blank'>View Image</a></span> <?php }?>
                <input type='file' class='form-control mt-1 mb-3' id='item_img' name='item_img' />
                
                Item Info
                <input type='text' class='form-control mt-1 mb-3' id='item_info' name='item_info' required value='<?=$r['item_info'];?>' />
                
                Item Price
                <input type='number' min='0.00' step='0.01' class='form-control mt-1 mb-3' id='item_price' name='item_price' required value='<?=$r['item_price'];?>' />
                
                Item In Stocks
                <select class='form-control mt-1 mb-3' id='item_in_stocks' name='item_in_stocks' required >
                    <option <?=($r['item_in_stocks'] == "YES" ? "selected='selected'" : "");?> value='YES'>YES</option>
                    <option <?=($r['item_in_stocks'] == "NO" ? "selected='selected'" : "");?> value='NO'>NO</option>
                </select>
                
                
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>UPDATE</button>
                <button type='button' id='delBtn'  class='btn btn-danger'>DELETE</button>
            </div>
        </div>
    </div>
</div>
</form>

<?php
endPage();
?>
<script>
    
$("#delBtn").click(function()
{
    
    var o = confirm("Are You Sure To Delete This Item ?");
    if (o)
    {
        $.post("op.php", { op : "del_pre_defined_item", id : <?=$id;?> }, function(d,s)
        {
            location.href = "listPreDefinedItems.php";
        })
    }
});    
</script>