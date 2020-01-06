<?php

include 'func.php';
checkSession();

beginPage('Add Pre Defined Item');
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='add_pre_defined_item' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Add Pre Defined Item</div>
            <div class='card-body'>
                
                Item Name
                <input type='text' class='form-control mt-1 mb-3' id='item_name' name='item_name' required />
                
                Item Image
                <input type='file' class='form-control mt-1 mb-3' id='item_img' name='item_img' />
                
                Item Info
                <input type='text' class='form-control mt-1 mb-3' id='item_info' name='item_info' required />
                
                Item Price
                <input type='number' min='0.00' step='0.01' class='form-control mt-1 mb-3' id='item_price' name='item_price' required />
                
                Item In Stocks
                <select class='form-control mt-1 mb-3' id='item_in_stocks' name='item_in_stocks' required >
                    <option value='YES'>YES</option>
                    <option value='NO'>NO</option>
                </select>
                
                
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>ADD</button>
            </div>
        </div>
    </div>
</div>
</form>
