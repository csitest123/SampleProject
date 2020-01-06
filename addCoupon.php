<?php

include 'func.php';
checkSession();
$c = getDB();
beginPage('Add Coupon');
$today = date('m-d');
$thisYear = date('Y')+1;
$nextYearToday = $thisYear.'-'.$today;
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='add_coupon' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Add Coupon</div>
            <div class='card-body'>
                <div class="row">
                    <div class="col-12">
                        Minimum Cart Amount
                        <input type='number' min="0" step="0.01" class='form-control mt-1 mb-3' id='min_basket_price' name='min_basket_price' required />
                    </div>
                    
                    <div class="col-12">
                        Discount Type
                        <select class='form-control mt-1 mb-3 selectpicker' id='discount_type' name='discount_type'  data-live-search="true" data-size="10" title="Select">
                            <option value="AMOUNT">AMOUNT</option>
                            <option value="PERCENT">PERCENT</option>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        Discount Value
                        <input type='number' min="0" step="0.01" class='form-control mt-1 mb-3' id='discount_value' name='discount_value' required/>
                    </div>
                    
                    <div class="col-12">
                        Valid Until
                        <input type='date' class='form-control mt-1 mb-3' id='valid_until' name='valid_until' required value="<?=$nextYearToday;?>" />
                    </div>
                    
                    <div class="col-12">
                        Assigned To
                        <select class='form-control mt-1 mb-3 selectpicker' data-live-search="true" data-size="10" id='assigned_to' name='assigned_to' title="Select">
                            <?php
                            $rs = qWMR("select id, cust_name, cust_em from customers order by cust_name", null, $c);
                            foreach($rs as $r)
                            {
                                $xId = $r['id'];
                                $xName = $r['cust_name'];
                                $xds = $r['cust_em'];
                                echo "<option value='$xId' data-subtext='$xds'>$xName</option>";
                            }
                            ?>
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
