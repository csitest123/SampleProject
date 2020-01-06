<?php

include 'func.php';
checkSession();
$c = getDB();
$id = g("id");
$r = qW1R("select * from customers where id = $id", null, $c);
beginPage('Edit Customer');
?>

<form id='f' action="op.php" method="post">
<input type='hidden' name='op' value='upd_customer' />    
<input type='hidden' name='id' value='<?=$id;?>' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Customer</div>
            <div class='card-body'>
                <div class="row">
                    <div class="col-md-12 col-12">
                        Customer Name
                        <input type="text" class="form-control mt-1 mb-3" id="fn" name="fn" required value="<?=$r['cust_name'];?>" />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer E-Mail
                        <input type="email" class="form-control mt-1 mb-3" id="em" name="em" required value="<?=$r['cust_em'];?>" />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer Password <span style="float:right"><a href="#" id='genPass'>Generate Random Password</a></span>
                        <input type='text' class='form-control mt-1 mb-3' id='pw' name='pw' required value="<?=$r['cust_pw'];?>" />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer Phone Number
                        <input type="text" class="form-control mt-1 mb-3" id="tel" name="tel" required value="<?=$r['cust_tel'];?>" />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer Balance
                        <input type="number" min="0" step="0.01" class="form-control mt-1 mb-3" id="balance" name="balance" required  value="<?=$r['cust_balance'];?>" />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Can Transfer Balance
                        <select class="form-control mt-1 mb-3 selectpicker" id="can_transfer" name="can_transfer" required value="0" title="select">
                            <option <?=($r['can_transfer_balance'] == "YES" ? "selected='selected'" : "");?> value="YES">YES</option>
                            <option <?=($r['can_transfer_balance'] == "NO" ? "selected='selected'" : "");?>  value="NO">NO</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 col-12">
                    Can Receive Balance
                        <select class="form-control mt-1 mb-3 selectpicker" id="can_receive" name="can_receive" required value="0" title="select">
                            <option <?=($r['can_receive_balance'] == "YES" ? "selected='selected'" : "");?> value="YES">YES</option>
                            <option <?=($r['can_receive_balance'] == "NO" ? "selected='selected'" : "");?>  value="NO">NO</option>
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
    

$("#genPass").click(function()
{
   var result           = '';
   var characters       = 'ABCDEF123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < 6; i++ ) 
   {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   
    $("#pw").val(result);
});
    
    

$("#btnDel").click(function()
{
    var o = confirm("Are You Sure ?");
    if (o)
    {
        $.post("op.php", { op : "del_customer", id : <?=$id;?> }, function(d,s) { location.href = "listCustomers.php" } );
    }
});     
    
</script>