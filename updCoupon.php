<?php

include 'func.php';
checkSession();
$c = getDB();
$id = g("id");
beginPage('Edit Coupon');
$r = qW1R("select * from coupons where id = $id", null, $c);
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='upd_coupon' />    
<input type='hidden' name='id' value='<?=$id;?>' />
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Coupon</div>
            <div class='card-body'>
                <div class="row">
                    <div class="col-12">
                        Coupon Code
                        <input type='text' readonly class='form-control mt-1 mb-3' value="<?=$r['coupon_code'];?>" />
                    </div>
                    <div class="col-12">
                        Minimum Cart Amount
                        <input type='number' min="0" step="0.01" class='form-control mt-1 mb-3' id='min_basket_price' name='min_basket_price' required value="<?=$r['min_basket_price'];?>" />
                    </div>
                    
                    <div class="col-12">
                        Discount Type
                        <select class='form-control mt-1 mb-3 selectpicker' id='discount_type' name='discount_type'  data-live-search="true" data-size="10" title="Select">
                            <option <?=($r['discount_type'] == "AMOUNT" ? "selected='selected'" : "");?> value="AMOUNT">AMOUNT</option>
                            <option <?=($r['discount_type'] == "PERCENT" ? "selected='selected'" : "");?> value="PERCENT">PERCENT</option>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        Discount Value
                        <input type='number' min="0" step="0.01" class='form-control mt-1 mb-3' id='discount_value' name='discount_value' required value="<?=$r['discount_value'];?>" />
                    </div>
                    
                    <div class="col-12">
                        Valid Until
                        <input type='date' class='form-control mt-1 mb-3' id='valid_until' name='valid_until' required value="<?=$r['valid_until'];?>"/>
                    </div>
                    
                    <div class="col-12">
                        Assigned To
                        <select class='form-control mt-1 mb-3 selectpicker' data-live-search="true" data-size="10" id='assigned_to' name='assigned_to' title="Select">
                            <?php
                            $rs = qWMR("select id, cust_name, cust_em from customers order by cust_name", null, $c);
                            foreach($rs as $rx)
                            {
                                $xId = $rx['id'];
                                $xName = $rx['cust_name'];
                                $xds = $rx['cust_em'];
                                $sel = ($xId == $r['assigned_to'] ? "selected='selected'" : "");
                                echo "<option $sel value='$xId' data-subtext='$xds'>$xName</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                
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
        $.post("op.php", { op : "del_coupon", id : <?=$id;?> }, function(d,s) { location.href = "listCoupons.php" } );
    }
}); 
</script>    