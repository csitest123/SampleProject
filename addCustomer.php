<?php

include 'func.php';
checkSession();

beginPage('Add Customer');
?>

<form id='f' action="op.php" method="post">
<input type='hidden' name='op' value='add_customer' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Add Customer</div>
            <div class='card-body'>
                <div class="row">
                    <div class="col-md-12 col-12">
                        Customer Name
                        <input type="text" class="form-control mt-1 mb-3" id="fn" name="fn" required />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer E-Mail
                        <input type="email" class="form-control mt-1 mb-3" id="em" name="em" required />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer Password <span style="float:right"><a href="#" id='genPass'>Generate Random Password</a></span>
                        <input type='text' class='form-control mt-1 mb-3' id='pw' name='pw' required />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer Phone Number
                        <input type="text" class="form-control mt-1 mb-3" id="tel" name="tel" required />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Customer Balance
                        <input type="number" min="0" step="0.01" class="form-control mt-1 mb-3" id="balance" name="balance" required value="0" />
                    </div>
                    
                    <div class="col-md-12 col-12">
                        Can Transfer Balance
                        <select class="form-control mt-1 mb-3 selectpicker" id="can_transfer" name="can_transfer" required value="0" title="select">
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 col-12">
                    Can Receive Balance
                        <select class="form-control mt-1 mb-3 selectpicker" id="can_receive" name="can_receive" required value="0" title="select">
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>ADD</button>
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
    
    
</script>