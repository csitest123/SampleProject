<?php
include 'func.php';

checkSession();
beginPage("Coupons");
$c = getDB();
$rs = qWMR("select c.id, c.coupon_code, c.min_basket_price,  c.discount_type, c.valid_until, c.discount_value, (select cust_em from customers where id = c.assigned_to) as 'assigned_to', (select cust_em from customers where id = c.used_by) as 'used_by', c.used_date, c.used_order_id from coupons c ", null, $c);
?>
<div class="row mt-3 justify-content-center">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Coupons</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th style="width:100px !important" class='text-center id'>ID</th>
                            <th class='text-center'>Coupon Code</th>
                            <th style="width:15% !important" class='text-right'>Min Cart Amount </th>
                            <th class='text-center'>Discount Type</th>
                            <th style="width:15% !important" class='text-right'>Discount Value</th>
                            <th class='text-center'>Valid Until</th>
                            <th class='text-center'>Assigned To</th>
                            <th class='text-center'>Used By</th>
                            <th class='text-center'>Date Of Use</th>
                            <th class='text-center'>Order ID</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                            <tr>
                                <td class='id text-center' style="vertical-align: middle"><?=$r['id'];?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['coupon_code'];?></td>
                                <td class='text-right' style="vertical-align: middle"><?=number_format($r['min_basket_price'],2,'.','.');?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['discount_type'];?></td>
                                <td class='text-right' style="vertical-align: middle"><?=number_format($r['discount_value'],2,'.','.');?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['valid_until'];?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['assigned_to'];?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['used_by'];?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['used_date'];?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['used_order_id'];?></td>
                            </tr>
                            <?php
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
            scrollX : true,
            buttons: [ 
                'excel', 
                { text : 'New Coupon', action : function() { window.open('addCoupon.php', '_blank'); } } 
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updCoupon.php?id="+data[0], '_blank');
} );
</script>


<style>
    th, td { min-width: 200px !important; max-width : 400px !important}
    th.id, td.id {min-width: 60px !important}
</style>