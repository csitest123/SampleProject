<?php
include 'func.php';

checkSession();
beginPage("Orders");
$c = getDB();
$rs = qWMR("select

o.id,
o.order_date,
(select city_name from cities where id = o.city_id) as 'city',
(select shop_name from shops where id = o.shop_id) as 'shop',
(select shop_adr from shops where id = o.shop_id) as 'shop_adr',
(select concat(cust_name,'<br />', cust_tel) from customers where id = o.cust_id) as 'customer',
o.cust_address,

o.travel_distance,
o.total_amount,
o.transportation_fee,
o.discount_amount,
o.total_payment,
o.payment_type,

o.order_status

from orders o order by order_date desc", null, $c);
?>
<div class="row mt-3 justify-content-center">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Orders</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped w-100">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th  style='display:none' class='text-center id'>ID</th>
                            <th  class='text-center' >Order Date</th>
                            <th  class='text-center' >City</th>
                            <th  class='text-center' >Shop Name</th>
                            <th  class='text-center' >Shop Address</th>
                            <th  class='text-center' >Customer</th>
                            <th  class='text-center' >Delivery Address</th>
                            
                            <th  class='text-center' >Travel Distance</th>
                            <th  class='text-center' >Total Amount</th>
                            <th  class='text-center' >Transportation Fee</th>
                            <th  class='text-center' >Discount Amount</th>
                            <th  class='text-center' >Total Payment</th>
                            <th  class='text-center' >Payment Type</th>
                            <th  class='text-center' >Status</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            echo '<tr>';
                            $keys = array_keys($r);
                            foreach($keys as $key)
                            {
                                $className = "";
                                if ($key == "id") $className = "id";
                                $style = '';
                                if ($key == "id") $style="display:none;";
                                
                                echo "<td style='$style vertical-align:middle' class='$className text-center'>".$r[$key]."</td>";
                                
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
endPage();
?>
<script>
var t = $("#tbl").DataTable(
        {
            dom: 'Bfrtip',
            pageLength : 10,
            scrollX : true,
            buttons: [ 
                'excel'
                
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updOrder.php?id="+data[0], '_blank');
} );

$(".viewLink").click(function(e)
{
    e.stopPropagation();
});
</script>

<style>
    tr { cursor:pointer;}
    th, td { min-width: 200px !important; }
    th.id, td.id {min-width: 60px !important}
</style>



