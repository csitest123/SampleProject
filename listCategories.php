<?php
include 'func.php';

checkSession();
beginPage("Categories");
$c = getDB();
$rs = qWMR("select * from categories", null, $c);
?>
<div class="row mt-3 justify-content-center">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Categories</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped w-100">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th style="width:100px !important" class='text-center'>ID</th>
                            <th style="width:200px !important" class='text-center'>Category Image</th>
                            <th class='text-center'>Category Name</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                        <tr>
                        <td class='id text-center' style="vertical-align: middle"><?=$r['id'];?></td>
                        <td  class='text-center' style="vertical-align: middle;text-align:center"><img src='<?=$r['cat_img'];?>' class='img-thumbnail' style='max-width:100%;max-height:100px'</td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['cat_name'];?></td>
                        
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
                { text : 'New Category', action : function() { window.open('addCategory.php', '_blank'); } } 
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updCategory.php?id="+data[0], '_blank');
} );

$(".viewLink").click(function(e)
{
    e.stopPropagation();
});
</script>

<style>
    tr { cursor:pointer;}
    
</style>



