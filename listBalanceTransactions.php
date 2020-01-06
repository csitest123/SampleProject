<?php
include 'func.php';

checkSession();
beginPage("Balance Transactions");
$c = getDB();
$rs = qWMR("select b.id, b.transaction_id, op_date, (select cust_em from customers where id = b.from_user) as 'from_user', (select cust_em from customers where id = b.to_user) as 'to_user', b.amount  from balance_transactions b", null, $c);
?>
<div class="row mt-3 justify-content-center">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Balance Transactions</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped w-100">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th style="width:300px !important" class='text-left'>Transaction ID</th>
                            <th  class='text-center'>Date</th>
                            <th  class='text-left'>From</th>
                            <th  class='text-left'>To</th>
                            <th  class='text-right'>Amount</th>
                            
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                        <tr>
                        <td class='text-left' style="vertical-align: middle"><?=$r['transaction_id'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['op_date'];?></td>
                        <td  class='text-left' style="vertical-align: middle"><?=$r['from_user'];?></td>
                        <td  class='text-left' style="vertical-align: middle"><?=$r['to_user'];?></td>
                        <td  class='text-right' style="vertical-align: middle"><?=number_format($r['amount'],2,'.','.');?></td>
                        
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
            
            buttons: [ 
                'excel', 
                { text : 'Clear Transaction History', action : function() { clearHistory(); } } 
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    clearSingleHistory(data[0]);
} );


function clearHistory()
{
    var o = confirm("Are You Sure ?");
    if (o)
    {
        $.post("op.php", { op : "clear_transaction_history" }, function(d,s)
        {
            location.reload();
        });
    }
}

function clearSingleHistory(id)
{
    var o = confirm("Are You Sure ?");
    if (o)
    {
        $.post("op.php", { op : "clear_single_transaction_history", tId : id }, function(d,s)
        {
            location.reload();
        });
    }
}
</script>

<style>
    tr { cursor:pointer;}
    
    
    
</style>



