<?php
include 'func.php';

checkSession();
beginPage("Cities");
$c = getDB();
$rs = qWMR("select * from cities", null, $c);
?>
<div class="row mt-3 justify-content-center">
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Cities</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped w-100">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th style="width:100px !important" class='text-center'>ID</th>
                            <th  class='text-center'>City Name </th>
                            
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                        <tr>
                        <td class='id text-center' style="vertical-align: middle"><?=$r['id'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['city_name'];?></td>
                        
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
                { text : 'New City', action : function() { window.open('addCity.php', '_blank'); } } 
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updCity.php?id="+data[0], '_blank');
} );

$(".viewLink").click(function(e)
{
    e.stopPropagation();
});
</script>

<style>
    tr { cursor:pointer;}
    
</style>



