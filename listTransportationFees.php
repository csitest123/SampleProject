<?php
include 'func.php';

checkSession();
beginPage("Transportation Fees");
$c = getDB();
$rs = qWMR("select t.id, (select city_name from cities where id = t.city) as 'city', t.min_distance, t.max_distance, t.fee from transportation_fees t", null, $c);
?>
<div class="row mt-3 justify-content-center">
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Transportation Fees</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th style="width:100px !important" class='text-center id'>ID</th>
                            <th class='text-center'>City</th>
                            <th style="width:15% !important" class='text-right'>Min Distance (m)</th>
                            <th style="width:15% !important" class='text-right'>Max Distance (m)</th>
                            <th style="width:15% !important" class='text-right'>Fee</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                            <tr>
                                <td class='id text-center' style="vertical-align: middle"><?=$r['id'];?></td>
                                <td class='text-center' style="vertical-align: middle"><?=$r['city'];?></td>
                                <td class='text-right' style="vertical-align: middle"><?=number_format($r['min_distance'],2,'.','.');?></td>
                                <td class='text-right' style="vertical-align: middle"><?=number_format($r['max_distance'],2,'.','.');?></td>
                                <td class='text-right' style="vertical-align: middle"><?=number_format($r['fee'],2,'.','.');?></td>
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
                { text : 'New Transportation Fee Rule', action : function() { window.open('addTransportationFee.php', '_blank'); } } 
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updTransportationFee.php?id="+data[0], '_blank');
} );
</script>


<style>
    th, td { min-width: 200px !important; max-width : 400px !important}
    th.id, td.id {min-width: 60px !important}
</style>