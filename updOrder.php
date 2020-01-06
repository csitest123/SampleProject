<?php

include 'func.php';
checkSession();

$c = getDB();
$id = g("id");
$orderID = $id;
$r = qW1R("select * from orders where id = $id", null, $c);
beginPage('Edit Order');

$mapKey = 'AIzaSyDtwCm5qw7S7ruArmqyZxE-pyIs4b9bNcs';
$order_date = $r['order_date'];
$city_id = $r['city_id'];
$cityName = qW1R("select city_name from cities where id= $city_id", null, $c)['city_name'];
$shop_id = $r['shop_id'];
$shopName = qW1R("select shop_name from shops where id = $shop_id", null, $c)['shop_name'];
$shopLocation= qW1R("select shop_loc from shops where id = $shop_id", null, $c)['shop_loc'];
$shopAdr = qW1R("select shop_adr from shops where id = $shop_id", null, $c)['shop_adr'];
$shopTel = qW1R("select tel from shops where id = $shop_id", null, $c)['tel'];

$customer_id = $r['cust_id'];
$customerName = qW1R("select cust_name from customers where id = $customer_id", null, $c)['cust_name'];
$customerTel= qW1R("select cust_tel from customers where id = $customer_id", null, $c)['cust_tel'];
$customerAddress = $r['cust_address'];
$customerLocation = $r['cust_loc'];
$travel_distance = $r['travel_distance'];
$total_amount = $r['total_amount'];
$transportation_fee = $r['transportation_fee'];
$discount_amount = $r['discount_amount'];
$total_payment = $r['total_payment'];
$payment_type = $r['payment_type'];
$order_status = $r['order_status'];
$cancel_reason = $r['cancel_reason'];

$customerCity = qW1R("select city_name from cities where id= $city_id", null, $c)['city_name'];
$shopCity = qW1R("select city_name from cities where id = (select shop_city from shops where id = $shop_id)", null, $c)['city_name'];

$js = toArr($r['js']);


$customerLocation = "";
?>

<form id='f' >

<input type='hidden' name='id' value='<?=$id;?>' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-12 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Order [ <?=$id;?> / <?=$order_date;?> ]</div>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-12 col-12 mb-3'>
                        <b>Customer Information</b>
                    </div>
                    
                    <div class='col-md-4 col-12'>
                        City
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$customerCity;?>' />
                    </div>
                    
                    <div class='col-md-4 col-12'>
                        Name
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$customerName;?>' />
                    </div>
                    
                    <div class='col-md-4 col-12'>
                        Phone Number
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$customerTel;?>' />
                    </div>
                    
                    <div class='col-md-12 col-12'>
                        Delivery Address <span style='float:right'><a class='viewLink' href='https://www.google.com/maps/search/?api=1&query=<?=$customerLocation;?>' target='_blank'>View On Map</a></span>
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$customerAddress;?>' />
                    </div>
                </div>
                
                <div class='row mt-3'>
                    <div class='col-md-12 col-12 mb-3'>
                        <b>Shop Information</b>
                    </div>
                    
                    <div class='col-md-4 col-12'>
                        City
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$shopCity;?>' />
                    </div>
                    
                    <div class='col-md-4 col-12'>
                        Name
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$shopName;?>' />
                    </div>
                    
                    <div class='col-md-4 col-12'>
                        Phone Number
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$shopTel;?>' />
                    </div>
                    
                    <div class='col-md-12 col-12'>
                        Address <span style='float:right'><a class='viewLink' href='https://www.google.com/maps/search/?api=1&query=<?=$shopLocation;?>' target='_blank'>View On Map</a></span>
                        <input type='text' class='form-control mt-1 mb-3' readonly value='<?=$shopAdr;?>' />
                    </div>
                </div>
                
                <div class='row mt-3'>
                    <div class='col-md-12 col-12 mb-3'>
                        <b>Order Details</b>
                    </div>
                    <div class='col-md-12 col-12 mb-3'>
                        <table class='table table-bordered table-sm table-hover table-striped w-100'>
                            <thead class='bg-secondary text-light'>
                                <tr>
                                    <th class='text-center' width='10%'>Quantity</th>
                                    <th >Item Name</th>
                                    <th>Customization</th>
                                    <th width='10%' class='text-right'>Price Per Unit</th>
                                    <th width='10%' class='text-right'>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($js['items'] as $item)
                                {
                                    $qty = $item['qty'];
                                    $basePrice = $item['base_price'];
                                    $itemId = $item['item_id'];
                                    $xtras = $item['xtras'];
                                    $str = "";
                                    $totalPrice = $qty * $basePrice;
                                    
                                    $custPrice = 0;
                                    foreach($xtras as $xtra)
                                    {
                                        $xtraName = $xtra['ad'];
                                        $xtraOpt = "";
                                        if (is_array($xtra['opt']))
                                        $xtraOpt = implode(", ", $xtra['opt']);
                                        else
                                            $xtraOpt = $xtra['opt'];
                                        
                                        $xtraDiff = $xtra['diff'];
                                        $str .= "[$xtraName -> $xtraOpt] (".number_format($xtraDiff,2,'.','.').")<br>";
                                        $custPrice += $xtraDiff;
                                    }
                                    
                                    $totalPrice += $custPrice;
                                    $itemName = qW1R("select item_name from menu_items where id = $itemId", null, $c)['item_name'];
                                    echo "<tr>";
                                    echo "<td  class='text-center' style='vertical-align:middle'>$qty</td>";
                                    echo "<td style='vertical-align:middle'>$itemName</td>";
                                    echo "<td style='vertical-align:middle'>$str</td>";
                                    echo "<td class='text-right' style='vertical-align:middle'>".number_format($basePrice,2,'.','.')."</td>";
                                    echo "<td class='text-right' style='vertical-align:middle'>".number_format($totalPrice,2,'.','.')."</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot class='bg-dark text-light'>
                                <tr>
                                    <td rowspan='5' colspan='3'></td>
                                    <td class='text-right' >TOTAL PRICE</td>
                                    <td class='text-right'><?=number_format($total_amount,2,'.','.')?></td>
                                </tr>
                                
                                <tr>
                                    
                                    <td class='text-right' >DISCOUNT</td>
                                    <td class='text-right'><?=number_format($discount_amount,2,'.','.')?></td>
                                </tr>
                                
                                <tr>
                                    
                                    <td class='text-right' >TRANSPORTATION FEE</td>
                                    <td class='text-right'><?=number_format($transportation_fee,2,'.','.')?></td>
                                </tr>
                                <tr>
                                    <td  class='text-right'>TOTAL PAYMENT</td>
                                    <td class='text-right'><?=number_format($total_payment,2,'.','.')?></td>
                                </tr>
                                
                                <tr>
                                    <td  class='text-right'>PAYMENT TYPE</td>
                                    <td class='text-right'><?=$payment_type;?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    
                        <div class='col-md-8 col-12'>
                            Order Note
                            <input type='text' class='form-control mt-1 mb-3' readonly  value="<?=$r['order_note'];?>"/>
                        </div>
                    
                        <div class='col-md-4 col-12'>
                            Order Status
                            <select class='form-control mt-1 mb-3 selectpicker'  title="Select" id='order_status' name='order_status'>
                                <option <?=($order_status == "PENDING" ? "selected='selected'" : "");?> value='PENDING'>PENDING</option>
                                <option <?=($order_status == "PREPARING" ? "selected='selected'" : "");?> value='PREPARING'>PREPARING</option>
                                <option <?=($order_status == "ON DELIVERY" ? "selected='selected'" : "");?> value='ON DELIVERY'>ON DELIVERY</option>
                                <option <?=($order_status == "COMPLETED" ? "selected='selected'" : "");?> value='COMPLETED'>COMPLETED</option>
                                <option <?=($order_status == "CANCELLED" ? "selected='selected'" : "");?> value='CANCELLED'>CANCELLED</option>
                            </select>
                        </div>
                    
                        <div class='col-12'>
                        Enter Cancel Reason
                        <textarea id="cancel_reason"  disabled="disabled" name="cancel_reason" class='form-control mt-1 mb-3' style='height:100px'><?=$cancel_reason;?></textarea>
                        </div>
                    
                </div>
                
                
                
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
$("#order_status").change(function()
{
    var v = $(this).val();
    
    if (v == "CANCELLED")
    {
        $("#cancel_reason").prop('disabled', false);
    }
    if (v != "CANCELLED")
    {
        $("#cancel_reason").prop('disabled', false);
        $("#cancel_reason").val('');
        $("#cancel_reason").prop('disabled', true);
        
        
    }
});
    
 $("#f").submit(function(e)
 {
     e.preventDefault();
     var v = $(this).serialize();
     $.post("op.php", { op : "upd_order_status", id : <?=$orderID;?>  , status : $("#order_status").val(), reason : $("#cancel_reason").val() }, function(d,s)
     {
         location.reload();
     });
     
     console.log(v);
     return false;
 });
</script> 

