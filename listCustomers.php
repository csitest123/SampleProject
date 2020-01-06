<?php
include 'func.php';

checkSession();
beginPage("Customers");
$c = getDB();
$rs = qWMR("select c.id, c.cust_name, c.cust_em, c.cust_pw, c.cust_tel, c.cust_balance, c.can_transfer_balance, c.can_receive_balance, (select count(*) from customer_addresses where cust_id = c.id) as 'adr_cnt' from customers c", null, $c);
?>
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Customers</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th class='text-center id'>ID</th>
                            <th class='text-center'>Name</th>
                            <th class='text-center'>E-Mail</th>
                            <th class='text-center'>Password</th>
                            <th class='text-center'>Phone Number</th>
                            <th class='text-center'>Balance</th>
                            <th class='text-center'>Can Transfer Balance</th>
                            <th class='text-center'>Can Receive Balance</th>
                            <th class='text-center'># Of Registered Addresses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                        <tr>
                        <td class='id text-center' style="vertical-align: middle"><?=$r['id'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['cust_name'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['cust_em'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['cust_pw'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['cust_tel'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['cust_balance'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['can_transfer_balance'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['can_receive_balance'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['adr_cnt'];?></td>
                        
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
                { text : 'New Customer', action : function() { window.open('addCustomer.php', '_blank'); } } 
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updCustomer.php?id="+data[0], '_blank');
} );
</script>


<style>
    th, td { min-width: 200px !important; max-width : 400px !important}
    th.id, td.id {min-width: 60px !important}
</style>