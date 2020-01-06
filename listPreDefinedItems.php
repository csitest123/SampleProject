<?php
include 'func.php';

checkSession();
beginPage("Pre Defined Items");
$c = getDB();
$rs = qWMR("select * from pre_defined_items", null, $c);
?>
<div class="row mt-3 justify-content-center">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header bg-dark text-light">Pre Defined Items</div>
            <div class="card-body">
                <table id="tbl" class="table table-bordered table-hover table-striped w-100">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th style="width:100px !important" class='text-center'>ID</th>
                            <th  class='text-center'>Item Image</th>
                            <th  class='text-center'>Item Name</th>
                            <th  class='text-center'>Item Info</th>
                            <th  class='text-center'>Item Price</th>
                            <th  class='text-center'>Item In Stocks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rs as $r)
                        {
                            ?>
                        <tr>
                        <td class='id text-center' style="vertical-align: middle"><?=$r['id'];?></td>
                        <td  class='text-center' style="vertical-align: middle;text-align:center"><img src='<?=($r['item_img'] == "" ? "nan.png" : $r['item_img']);?>' class='img-thumbnail' style='max-width:100%;max-height:100px'</td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['item_name'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['item_info'];?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=number_format($r['item_price'],2,'.','.');?></td>
                        <td  class='text-center' style="vertical-align: middle"><?=$r['item_in_stocks'];?></td>
                        
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



<form action='op.php' method='post' enctype="multipart/form-data">
    <input type='hidden' name='op' value='import_items' />
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark text-light">Import Items

          </div>
          <div class="modal-body">
              <div class='row'>
                  <div class='col-12 mb-4'>
                      <a href='Items.xlsx' target='_blank' class='btn btn-block btn-primary'><i class='fa fa-fw fa-lg fa-cloud-download-alt'></i> Download Template</a>
                  </div>

                  <div class='col-12 mb-1'>
                      After Editing The Template File Upload It Please
                      <input type='file' class='form-control mt-1' required name='xls' id='xls' />
                  </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">IMPORT</button>
          </div>
        </div>
      </div>
    </div>
</form>
<?php
endPage();
?>
<script>
var t = $("#tbl").DataTable(
        {
            dom: 'Bfrtip',
            
            buttons: [ 
                'excel', 
                { text : 'Import Pre Defined Items', action : function() { $("#addModal").modal('show'); } } ,
                { text : 'New Pre Defined Item', action : function() { window.open('addPreDefinedItem.php', '_blank'); } } 
                
            ]
        });

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    window.open("updPreDefinedItem.php?id="+data[0], '_blank');
} );


</script>

<style>
    tr { cursor:pointer;}
    
</style>



