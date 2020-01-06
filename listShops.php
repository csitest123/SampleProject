<?php
include 'func.php';

checkSession();
beginPage("Shops");
$c = getDB();
$rs = qWMR("select 

s.id, 
s.cat_id,
(select cat_name from categories where id = s.cat_id) as 'cat_name',
s.shop_name,

s.shop_img, 
s.shop_info,
s.shop_adr,
s.shop_city,
s.person,
s.tel,
(select city_name from cities where id = s.shop_city) as 'city_name',
s.shop_loc,
s.shop_active_start,
s.shop_active_end,
s.can_serve

from 

shops s;
", null, $c);
?>
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Shops</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th class='id text-center'>ID</th>
                            <th class='text-center'>Shop Image</th>
                            <th class='text-center'>Shop Name</th>
                            <th class='text-center'>Category</th>
                            
                            <th class='text-center'>Shop Info</th>
                            <th class='text-center'>Shop City</th>
                            <th class='text-center'>Person In Charge</th>
                            <th class='text-center'>Shop Phone Number</th>
                            <th class='text-center'>Shop Address</th>
                            <th class='text-center'>Shop Location</th>
                            <th class='text-center'>Working Hours</th>
                            <th class='text-center'>Can Serve Right Now</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                        <tr>
                        <td class='id text-center' style="vertical-align: middle"><?=$r['id'];?></td>
                        <td  class='text-center' style="vertical-align: middle;text-align:center"><img src='<?=$r['shop_img'];?>' class='img-thumbnail' style='max-width:100%;max-height:100px'</td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['shop_name'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['cat_name'];?></td>
                        
                        <td  class='text-center' style="vertical-align: middle"><?=$r['shop_info'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['city_name'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['person'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['tel'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['shop_adr'];?></td>
                        <td class='text-center' style="vertical-align: middle;text-align:center"><a class='viewLink' href='https://www.google.com/maps/search/?api=1&query=<?=$r['shop_loc'];?>' target='_blank'>View On Map</a></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['shop_active_start'];?> - <?=$r['shop_active_end'];?></td>
                        <td class='text-center' style="vertical-align: middle"><?=$r['can_serve'];?></td>
                        
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
            scrollX : 'true',
            buttons: [ 
                'excel', 
                { text : 'New Shop', action : function() { window.open('addShop.php', '_blank'); } } 
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updShop.php?id="+data[0], '_blank');
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



