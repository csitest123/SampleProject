<?php

include 'func.php';
checkSession();
$c = getDB();
$id = g("id");

$shop_id = $id;

beginPage('Edit Menu');
$rsSections = qWMR("select * from menu_sections where shop_id = $id", null, $c);

?>




<div class='row mt-3 justify-content-center'>
    <div class='col-md-12 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Menu <span style="float:right"><a href="#" style="text-decoration: none;color:white" id="btnAddSection"><i class="fa fa-plus-circle"></i> Section</a></span></div>
            <div class="card-body">
                <div class="row" id="div_render">
                    
                    <div class='col-md-12 col-12 mb-3'>
                                
                                <div class='card'>
                                    <div class='card-header bg-secondary text-light' >Uncategorized <i class='fa fa-info-circle' style='cursor:pointer' data-toggle='tooltip'  data-placement='left' title='You Can Ignore This, Items Without Sections Will Be Listed Here, If You Assign Sections To All Items, This Will Be Invisible'></i></div>
                                    <div class="card-body">
                                        <div class="row div_render">
                                            <div class='col-12'>
                                            <table class="table table-sm table-bordered table-hover w-100" id='tbl_uncategorized'>
                                                <thead class="bg-secondary text-light">
                                                    <tr>
                                                        <th  class='text-center' width='100px'>ID</th>
                                                        <th class='text-center' width='200px'>Item Image</th>
                                                        <th>Item Name</th>
                                                        <th>Item Info</th>
                                                        <th class='text-right'>Item Price</th>
                                                        <th class="text-center">In Stocks</th>
                                                        <th>Customization</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $rsItems = qWMR("select * from menu_items where shop_id = $shop_id and section_id = ''", null, $c);
                                                    foreach($rsItems as $rsi)
                                                    {
                                                        ?>
                                                    <tr>
                                                        <td class='text-center' style="vertical-align: middle"><?=$rsi['id'];?></td>
                                                        <td class='text-center' style="vertical-align: middle"><img src='<?=$rsi['item_img'];?>' style='height: 120px' /></td>
                                                        <td style="vertical-align: middle"><?=$rsi['item_name'];?></td>
                                                        <td style="vertical-align: middle"><?=$rsi['item_info'];?></td>
                                                        <td style="vertical-align: middle" class='text-right'><?=number_format($rsi['item_price'],2,'.','.');?></td>
                                                        <td class="text-center" style="vertical-align: middle"><?=$rsi['item_in_stocks'];?></td>
                                                        <td style="vertical-align: middle" style='padding:0'>
                                                            
                                                            <?php
                                                            $xtras = toArr($rsi['js']);
                                                            if (count($xtras) == 0)
                                                            {
                                                                echo "<div class='text-center'>No Customization</div>";
                                                            }
                                                            else {
                                                            ?>
                                                            <table class='table table-sm table-bordered' style='margin:0; font-size:12px !important'>
                                                                
                                                                <thead class='bg-dark text-light' style='margin:0;background:#343A40 !important'>
                                                                    <tr>
                                                                        <th style='background:#343A40 !important; color:white !important' width='25%'>Name</th>
                                                                        <th style='background:#343A40 !important; color:white !important'width='25%'>Type</th>
                                                                        <th style='background:#343A40 !important; color:white !important'>Choices</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style='margin:0'>
                                                            <?php
                                                            	
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            $str = "";
                                                            foreach($xtras as $xtra)
                                                            {
                                                                $xtraName = $xtra['name'];
                                                                $xtraType = $xtra['type'];
                                                                $xtraOptions = $xtra['options'];
                                                                
                                                                $str = "";
                                                                foreach($xtraOptions as $opt)
                                                                {
                                                                    $str .= $opt['name'].' → '.$opt['price'].'<br>'."\r\n";
                                                                }
                                                                $xtraTypeName = "";
                                                                if ($xtraType == "SC1") { $xtraTypeName = "Single - Required"; }
                                                                if ($xtraType == "SC0") { $xtraTypeName = "Single - Non Required"; }
                                                                if ($xtraType == "MC0") { $xtraTypeName = "Multiple - At Least 1 Required"; }
                                                                if ($xtraType == "MC0") { $xtraTypeName = "Multiple - Non Required"; }
                                                                ?>
                                                                <tr>
                                                                    <td style='vertical-align:middle'><?=$xtraName;?></td>
                                                                    <td style='vertical-align:middle'><?=$xtraTypeName;?></td>
                                                                    <td style='vertical-align:middle'><?=$str;?></td>
                                                                </tr>
                                                                <?php
                                                                        
                                                            }
                                                            ?>
                                                                </tbody>
                                                            </table>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        
                                            </div>
                                        </div>
                                        
                                        <script>
                                var tbl_uncategorized = $("#tbl_uncategorized").DataTable({});
                                
                                
                                $('#tbl_uncategorized tbody').on('click', 'tr', function () 
                                {
                                    var data = tbl_uncategorized.row( this ).data();
                                    
                                    $.post("op.php", { op : "get_item", id : data[0] }, function(d,s)
                                    {
                                        console.log(d);
                                        $("#updItemModal").modal('show');
                                        
                                        var itId = d.id;
                                        var itImg = d.item_img;
                                        var itInStock = d.item_in_stocks;
                                        var itInfo = d.item_info;
                                        var itName = d.item_name;
                                        var itPrice = d.item_price;
                                        var itSectionId = d.section_id;
                                        var itShopId = d.shop_id;
                                        var itJS = JSON.parse(d.js);
                                        itemCustomization2 = itJS;
                                        
                                        if (itImg != "")
                                        {
                                            $("#view_upd_img").attr('href', itImg);
                                            $("#view_upd_img").show();
                                        }
                                        else
                                        {
                                            $("#view_upd_img").attr('href', '#');
                                            $("#view_upd_img").hide();
                                        }
                                        
                                        $("#upd_item_id").val(itId);
                                        $("#upd_shop_id").val(itShopId);
                                        $("#upd_item_section_id").val(itSectionId);
                                        $("#upd_item_menu_section").selectpicker('val', itSectionId);
                                        $("#upd_item_name").val(itName);
                                        $("#upd_item_info").val(itInfo);
                                        $("#upd_item_price").val(itPrice);
                                        $("#upd_item_in_stocks").selectpicker('val', itInStock);
                                        
                                        renderCustomizationTable2();
                                        
                                    });
                                } );    
                            </script>
                                    </div>
                                </div>
                                
                            </div>
                    
                    <?php
                    $cnt = 0;
                        foreach($rsSections as $rsSection)
                        {
                            $sectionId = $rsSection['id'];
                            $sectionName = $rsSection['section_name'];

                            ?>
                        
                            <div class='col-md-12 col-12 mb-3'>
                                
                                <div class='card'>
                                    <div class='card-header bg-default text-dark'><?=$sectionName;?> <span style="float:right">
                                            <a href="#" class='text-dark btnAddItem' data-toggle='tooltip' title='Click Here To Add An Item In This Section' style="text-decoration: none;color:white" rec_shop_id='<?=$shop_id;?>' rec_section_id='<?=$sectionId;?>' ><i class="fa fa-plus-circle"></i> Add Item</a>
                                            &nbsp;&nbsp;| &nbsp;&nbsp;
                                            <a href="#" class='text-dark btnUpdSection' data-toggle='tooltip' title='Click Here To Rename This Section' style="text-decoration: none;color:white" rec_section_name="<?=$sectionName;?>" rec_shop_id='<?=$shop_id;?>' rec_section_id='<?=$sectionId;?>'  ><i class="fa fa-edit"></i> Edit Section</a>
                                            
                                        </span></div>
                                    <div class="card-body">
                                        <div class="row div_render">
                                            <div class='col-12'>
                                            <table class="table table-sm table-bordered table-hover w-100" id='tbl_<?=$cnt;?>'>
                                                <thead class="bg-secondary text-light">
                                                    <tr>
                                                        <th  class='text-center' width='100px'>ID</th>
                                                        <th class='text-center' width='200px'>Item Image</th>
                                                        <th>Item Name</th>
                                                        <th>Item Info</th>
                                                        <th class='text-right'>Item Price</th>
                                                        <th class="text-center">In Stocks</th>
                                                        <th>Customization</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $rsItems = qWMR("select * from menu_items where shop_id = $shop_id and section_id = $sectionId", null, $c);
                                                    foreach($rsItems as $rsi)
                                                    {
                                                        ?>
                                                    <tr>
                                                        <td class='text-center' style="vertical-align: middle"><?=$rsi['id'];?></td>
                                                        <td class='text-center' style="vertical-align: middle"><img src='<?=$rsi['item_img'];?>' style='height: 120px' /></td>
                                                        <td style="vertical-align: middle"><?=$rsi['item_name'];?></td>
                                                        <td style="vertical-align: middle"><?=$rsi['item_info'];?></td>
                                                        <td style="vertical-align: middle" class='text-right'><?=number_format($rsi['item_price'],2,'.','.');?></td>
                                                        <td class="text-center" style="vertical-align: middle"><?=$rsi['item_in_stocks'];?></td>
                                                        <td style="vertical-align: middle" style='padding:0'>
                                                            
                                                            <?php
                                                            $xtras = toArr($rsi['js']);
                                                            if (count($xtras) == 0)
                                                            {
                                                                echo "<div class='text-center'>No Customization</div>";
                                                            }
                                                            else {
                                                            ?>
                                                            <table class='table table-sm table-bordered' style='margin:0; font-size:12px !important'>
                                                                
                                                                <thead class='bg-dark text-light' style='margin:0;background:#343A40 !important'>
                                                                    <tr>
                                                                        <th style='background:#343A40 !important; color:white !important' width='25%'>Name</th>
                                                                        <th style='background:#343A40 !important; color:white !important'width='25%'>Type</th>
                                                                        <th style='background:#343A40 !important; color:white !important'>Choices</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style='margin:0'>
                                                            <?php
                                                            	
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            $str = "";
                                                            foreach($xtras as $xtra)
                                                            {
                                                                $xtraName = $xtra['name'];
                                                                $xtraType = $xtra['type'];
                                                                $xtraOptions = $xtra['options'];
                                                                
                                                                $str = "";
                                                                foreach($xtraOptions as $opt)
                                                                {
                                                                    $str .= $opt['name'].' → '.$opt['price'].'<br>'."\r\n";
                                                                }
                                                                $xtraTypeName = "";
                                                                if ($xtraType == "SC1") { $xtraTypeName = "Single - Required"; }
                                                                if ($xtraType == "SC0") { $xtraTypeName = "Single - Non Required"; }
                                                                if ($xtraType == "MC0") { $xtraTypeName = "Multiple - At Least 1 Required"; }
                                                                if ($xtraType == "MC0") { $xtraTypeName = "Multiple - Non Required"; }
                                                                ?>
                                                                <tr>
                                                                    <td style='vertical-align:middle'><?=$xtraName;?></td>
                                                                    <td style='vertical-align:middle'><?=$xtraTypeName;?></td>
                                                                    <td style='vertical-align:middle'><?=$str;?></td>
                                                                </tr>
                                                                <?php
                                                                        
                                                            }
                                                            ?>
                                                                </tbody>
                                                            </table>
                                                            <?php } ?>
                                                        </td>
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
                                
                            </div>
                            <script>
                                var tbl_<?=$cnt;?> = $("#tbl_<?=$cnt;?>").DataTable({});
                                
                                
                                $('#tbl_<?=$cnt;?> tbody').on('click', 'tr', function () 
                                {
                                    var data = tbl_<?=$cnt;?>.row( this ).data();
                                    
                                    $.post("op.php", { op : "get_item", id : data[0] }, function(d,s)
                                    {
                                        console.log(d);
                                        $("#updItemModal").modal('show');
                                        
                                        var itId = d.id;
                                        var itImg = d.item_img;
                                        var itInStock = d.item_in_stocks;
                                        var itInfo = d.item_info;
                                        var itName = d.item_name;
                                        var itPrice = d.item_price;
                                        var itSectionId = d.section_id;
                                        var itShopId = d.shop_id;
                                        var itJS = JSON.parse(d.js);
                                        itemCustomization2 = itJS;
                                        
                                        if (itImg != "")
                                        {
                                            $("#view_upd_img").attr('href', itImg);
                                            $("#view_upd_img").show();
                                        }
                                        else
                                        {
                                            $("#view_upd_img").attr('href', '#');
                                            $("#view_upd_img").hide();
                                        }
                                        
                                        $("#upd_item_id").val(itId);
                                        $("#upd_shop_id").val(itShopId);
                                        $("#upd_item_section_id").val(itSectionId);
                                        $("#upd_item_menu_section").selectpicker('val', itSectionId);
                                        $("#upd_item_name").val(itName);
                                        $("#upd_item_info").val(itInfo);
                                        $("#upd_item_price").val(itPrice);
                                        $("#upd_item_in_stocks").selectpicker('val', itInStock);
                                        
                                        renderCustomizationTable2();
                                        
                                    });
                                } );    
                            </script>
                        <?php
                        $cnt++;
                        }
                        ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>




<form id="fAddSection">
<input type="hidden" name="op" value="add_section" />    
<input type="hidden" name="shop_id" value="<?=$id;?>" />
<div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">Add Section</div>
      <div class="modal-body">
        Section Name
        <input type="text" class="form-control mt-1" id="section_name" name="section_name" required />
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">ADD</button>
      </div>
    </div>
  </div>
</div>
</form>


<form id="fUpdSection">
<input type="hidden" name="op" value="upd_section" />    
<input type="hidden" name="shop_id" id='upd_shop_id' value="<?=$id;?>" />
<input type="hidden" name="section_id" id='upd_section_id' value="" />
<div class="modal fade" id="updSectionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">Edit Section</div>
      <div class="modal-body">
        Section Name
        <input type="text" class="form-control mt-1" id="upd_section_name" name="section_name" required />
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">RENAME</button>
        <button type="button" id='delSection' class="btn btn-danger">DELETE</button>
      </div>
    </div>
  </div>
</div>
</form>



<form id="fAddItem" action="op.php" method="post" enctype="multipart/form-data" onsubmit="return submitForm()" >
<input type="hidden" name="js" id="js" value="" />
<input type="hidden" name="op" value="add_item" />    
<input type="hidden" name="shop_id" id="add_item_shop_id" value="<?=$id;?>" />
<input type="hidden" name="section_id" id='add_item_section_id' value="" />
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">Add Item</div>
      <div class="modal-body">
        <div class="row">
            <div clasS="col-12 mb-3">
                 <b>Item Properties</b>
             </div>
            
            <div class="col-md-6 col-12">
                Menu Section
                <select class="form-control mt-1 mb-3 selectpicker" data-live-search="true" data-size="10" title="Select" required id="item_menu_section" name="item_menu_section">
                    <?php
                    foreach($rsSections as $rsSectionx)
                    {
                        $sectionId = $rsSectionx['id'];
                        $sectionName = $rsSectionx['section_name'];
                        echo "<option value='$sectionId'>$sectionName</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="col-md-6 col-12">
                Item Name
                <input type="text" class="form-control mt-1 mb-3" required id="item_name" name="item_name" />
            </div>
            <div class="col-md-6 col-12">
                Item Info
                <input type="text" class="form-control mt-1 mb-3" required id="item_info" name="item_info" />
            </div>
            
            <div class="col-md-6 col-12">
                Item Image
                <input type="file" accept="image/*" class="form-control mt-1 mb-3" required id="item_img" name="item_img" />
            </div>
            
            <div class="col-md-6 col-12">
                Item Price
                <input type="number" min="0" step="0.01" class="form-control mt-1 mb-3" required id="item_price" name="item_price" />
            </div>
            
            <div class="col-md-6 col-12">
                In Stocks
                <select class="form-control mt-1 mb-3 selectpicker" data-live-search="true" data-size="10" title="Select" required id="item_in_stocks" name="item_in_stocks">
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
            </div>
        </div>
          
         <div class="row mt-3">
             <div clasS="col-12 mb-3">
                 <b>Item Customization</b>
             </div>
             
             <div class="col-12" id="customization_div" style="display:none;">
                 
             </div>
             
             <div class="col-12">
                 <table class=" table-sm table table-bordered table-hover table-striped w-100" id="tbl" style="font-size:12px">
                     <thead class="bg-secondary text-light">
                         <tr>
                             <th style="width:40px !important">Index</th>
                             <th style="width:180px !important">Option Name</th>
                             <th style="width:140px !important">Option Type</th>
                             <th>Option List</th>
                         </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                 </table>
             </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">ADD</button>
      </div>
    </div>
  </div>
</div>
</form>
<?php
endPage();

?>








<form id="fUpdItem" action="op.php" method="post" enctype="multipart/form-data" onsubmit="return submitForm2()" >
<input type="hidden" name="upd_js" id="upd_js" value="" />
<input type="hidden" name="op" value="upd_item" />    
<input type="hidden" name="upd_item_id" id="upd_item_id" value="" />
<input type="hidden" name="upd_shop_id" id="upd_item_shop_id" value="<?=$id;?>" />
<input type="hidden" name="upd_section_id" id='upd_item_section_id' value="" />
<div class="modal fade" id="updItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">Edit Item</div>
      <div class="modal-body">
        <div class="row">
            <div clasS="col-12 mb-3">
                 <b>Item Properties</b>
             </div>
            
            <div class="col-md-6 col-12">
                Menu Section
                <select class="form-control mt-1 mb-3 selectpicker" data-live-search="true" data-size="10" title="Select" required id="upd_item_menu_section" name="upd_item_menu_section">
                    <?php
                    foreach($rsSections as $rsSectionx)
                    {
                        $sectionId = $rsSectionx['id'];
                        $sectionName = $rsSectionx['section_name'];
                        echo "<option value='$sectionId'>$sectionName</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="col-md-6 col-12">
                Item Name
                <input type="text" class="form-control mt-1 mb-3" required id="upd_item_name" name="upd_item_name" />
            </div>
            <div class="col-md-6 col-12">
                Item Info
                <input type="text" class="form-control mt-1 mb-3" required id="upd_item_info" name="upd_item_info" />
            </div>
            
            <div class="col-md-6 col-12">
                Item Image <span style="float:right"><a href="#" target="_blank" id="view_upd_img" style="display:none">View Image</a></span>
                <input type="file" accept="image/*" class="form-control mt-1 mb-3"  id="upd_item_img" name="upd_item_img" />
            </div>
            
            <div class="col-md-6 col-12">
                Item Price
                <input type="number" min="0" step="0.01" class="form-control mt-1 mb-3" required id="upd_item_price" name="upd_item_price" />
            </div>
            
            <div class="col-md-6 col-12">
                In Stocks
                <select class="form-control mt-1 mb-3 selectpicker" data-live-search="true" data-size="10" title="Select" required id="upd_item_in_stocks" name="upd_item_in_stocks">
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
            </div>
        </div>
          
         <div class="row mt-3">
             <div clasS="col-12 mb-3">
                 <b>Item Customization</b>
             </div>
             
             <div class="col-12" id="customization_div2" style="display:none;">
                 
             </div>
             
             <div class="col-12">
                 <table class=" table-sm table table-bordered table-hover table-striped w-100" id="tbl_upd" style="font-size:12px">
                     <thead class="bg-secondary text-light">
                         <tr>
                             <th style="width:40px !important">Index</th>
                             <th style="width:180px !important">Option Name</th>
                             <th style="width:140px !important">Option Type</th>
                             <th>Option List</th>
                         </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                 </table>
             </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">UPDATE</button>
        <button type="button"   id='btnDelItem' class="btn btn-danger">DELETE</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>

$("#btnDelItem").click(function()
{
    var o  = confirm("Are You Sure To Delete This Item ?");
    if(o)
    {
        var itemId = $("#upd_item_id").val();
        $.post("op.php", { op : "del_item", id : itemId}, function(d,s) { location.reload(); });
    }
});
var itemCustomization = [];
var itemCustomization2 = [];
    
function renderCustomizationTable()
{
    $(".xx").val('');
    $(".yy").val('');
    $(".yy").selectpicker('val', '');
    $("#customization_div").fadeOut();
    
    t.clear().draw();
    
    for (var i = 0; i< itemCustomization.length; i++)
    {
        var cust = itemCustomization[i];
        var custName = cust.name;
        var custType = cust.type;
        var custChoices = cust.options;
        // // SC1 Single - Required | SC0 Single - Non Required | MC1 - Multiple - At Least 1 Required | MC0 - Multiple - Non Required
        var custTypeText = "";
        if (custType == "SC1")      custTypeText = "Single - Required";
        if (custType == "SC0")      custTypeText = "Single - Non Required";
        if (custType == "MC1")      custTypeText = "Multiple - At Least 1 Required";
        if (custType == "MC0")      custTypeText = "Multiple - Non Required";
        
        var str = "";
        for (var j = 0; j < custChoices.length; j++)
        {
            var custOpt = custChoices[j];
            var optName = custOpt.name;
            var optPrice = custOpt.price;
            
            str += "( "+optName+" ) → "+optPrice+"<br>";
        }
        t.row.add([(i+1), custName, custTypeText, str]);
    }
    t.draw(false);
}

 
function renderCustomizationTable2()
{
    $(".xx").val('');
    $(".yy").val('');
    $(".yy").selectpicker('val', '');
    $("#customization_div2").fadeOut();
    
    t2.clear().draw();
    
    for (var i = 0; i< itemCustomization2.length; i++)
    {
        var cust = itemCustomization2[i];
        var custName = cust.name;
        var custType = cust.type;
        var custChoices = cust.options;
        // // SC1 Single - Required | SC0 Single - Non Required | MC1 - Multiple - At Least 1 Required | MC0 - Multiple - Non Required
        var custTypeText = "";
        if (custType == "SC1")      custTypeText = "Single - Required";
        if (custType == "SC0")      custTypeText = "Single - Non Required";
        if (custType == "MC1")      custTypeText = "Multiple - At Least 1 Required";
        if (custType == "MC0")      custTypeText = "Multiple - Non Required";
        
        var str = "";
        for (var j = 0; j < custChoices.length; j++)
        {
            var custOpt = custChoices[j];
            var optName = custOpt.name;
            var optPrice = custOpt.price;
            
            str += "( "+optName+" ) → "+optPrice+"<br>";
        }
        t2.row.add([(i+1), custName, custTypeText, str]);
    }
    t2.draw(false);
}

$(".btnAddItem").click(function()
{
    var shopId = $(this).attr('rec_shop_id');
    var sectionId = $(this).attr('rec_section_id');
    
    $("#add_item_shop_id").val(shopId);
    $("#add_item_section_id").val(sectionId);
    
    $("#addItemModal").modal('show');
    $("#item_menu_section").selectpicker('val', sectionId);
});

$(".btnUpdSection").click(function()
{
    var shopId = $(this).attr('rec_shop_id');
    var sectionId = $(this).attr('rec_section_id');
    var sectionName = $(this).attr('rec_section_name');
    $("#upd_shop_id").val(shopId);
    $("#upd_section_id").val(sectionId);
    $("#upd_section_name").val(sectionName);
    $("#updSectionModal").modal('show');
    
});

$("#delSection").click(function()
{
    var shopId = $("#upd_shop_id").val();
    var sectionId = $("#upd_section_id").val();
    
    var o = confirm("Are You Sure ?");
    if (o)
    {
        var v = { op : "del_section", shop_id : shopId, section_id : sectionId };
        console.log(v);
        $.post("op.php", v, function(d,s) {  location.reload(); });
    }
});

$("#fUpdSection").submit(function(e)
{
    e.preventDefault();
    var v = $(this).serialize();
    $.post("op.php", v, function(d,s) { location.reload(); });
    return false;
});

$("#btnAddSection").click(function()
{
    $("#addSectionModal").modal('show');
});    
    
$("#fAddSection").submit(function(e)
{
    e.preventDefault();
    var v = $(this).serialize();
    console.log(v);
    $.post("op.php", v, function(d,s)
    {
        location.reload();
    })
    return false;
});
    
    
    
var t = $("#tbl").DataTable(
{
    dom: 'Bfrtip',
    pageLength : 5,
    buttons: [ 
        
        { text : 'New Customization', action : function() { showCustomizationDiv(); } } 
    ]
});

$('#tbl tbody').on('click', 'tr', function () 
{
    var data = t.row( this ).data();
    var o = confirm("Are You Sure To Delete Selected Customization ?");
    if (o)
    {
        var ndx = data[0] - 1;
        itemCustomization.splice(ndx, 1);
        renderCustomizationTable();
    }
} );    





var t2 = $("#tbl_upd").DataTable(
{
    dom: 'Bfrtip',
    pageLength : 5,
    buttons: [ 
        
        { text : 'New Customization', action : function() { showCustomizationDiv2(); } } 
    ]
});

$('#tbl_upd tbody').on('click', 'tr', function () 
{
    var data = t2.row( this ).data();
    var o = confirm("Are You Sure To Delete Selected Customization ?");
    if (o)
    {
        var ndx = data[0] - 1;
        itemCustomization2.splice(ndx, 1);
        renderCustomizationTable2();
    }
} );    




function showCustomizationDiv()
{
    $.get("async_customization.php", {}, function(d,s)
    {
        
        $("#customization_div").html(d);
        $(".yy").selectpicker('render');
        $(".yy").selectpicker('refresh');
        $("#customization_div").fadeIn();
        
        $("#btnAddCustomization").off('click');
        
        
        $("#btnAddCustomization").click(function()
        {
            var optName = $("#new_option_name").val();
            var optType = $("#new_option_type").val();

            if (optName == "")
            {
                alert("Option Name Must Be Filled");
                return;
            }
            if (optType == "")
            {
                alert("Option Type Must Be Filled");
                return;
            }

            var choices = [];
            var cnt = 0;
            for (var i = 0; i < 10; i++)
            {
                var optChoice = $("#opt_choice_"+i).val();
                var optPrice = $("#opt_price_"+i).val();
                if (optChoice != "")
                {
                    cnt++;
                    if (optPrice == "") { optPrice = "0.00"; }
                    optPrice = Number(optPrice).toFixed(2);

                    choices.push({ name : optChoice, price : optPrice });
                }
            }

            if (cnt == 0)
            {
                alert("At Least One Choice Must Be Entered");
                return;
            }

            if ((optType == "MC0" || optType == "MC1") && cnt < 2)
            {
                alert("To Create Multiple Choice Option, At Least 2 Choices Must Be Entered");
                return;
            }

            itemCustomization.push({ name : optName, type : optType, options : choices });
            console.log(itemCustomization);
            $("#customization_div").fadeOut();
            setTimeout(function()
            {
                $("#customization_div").html("");    
            }, 333);

            renderCustomizationTable();
        });
    });
    
    
}

function showCustomizationDiv2()
{
    $.get("async_customization2.php", {}, function(d,s)
    {
        
        $("#customization_div2").html(d);
        $(".yy").selectpicker('render');
        $(".yy").selectpicker('refresh');
        $("#customization_div2").fadeIn();
        
        $("#btnAddCustomization2").off('click');
        
        
        $("#btnAddCustomization2").click(function()
        {
            var optName = $("#new_option_name2").val();
            var optType = $("#new_option_type2").val();

            if (optName == "")
            {
                alert("Option Name Must Be Filled");
                return;
            }
            if (optType == "")
            {
                alert("Option Type Must Be Filled");
                return;
            }

            var choices = [];
            var cnt = 0;
            for (var i = 0; i < 10; i++)
            {
                var optChoice = $("#opt_choice2_"+i).val();
                var optPrice = $("#opt_price2_"+i).val();
                if (optChoice != "")
                {
                    cnt++;
                    if (optPrice == "") { optPrice = "0.00"; }
                    optPrice = Number(optPrice).toFixed(2);

                    choices.push({ name : optChoice, price : optPrice });
                }
            }

            if (cnt == 0)
            {
                alert("At Least One Choice Must Be Entered");
                return;
            }

            if ((optType == "MC0" || optType == "MC1") && cnt < 2)
            {
                alert("To Create Multiple Choice Option, At Least 2 Choices Must Be Entered");
                return;
            }

            itemCustomization2.push({ name : optName, type : optType, options : choices });
            console.log(itemCustomization2);
            $("#customization_div2").fadeOut();
            setTimeout(function()
            {
                $("#customization_div2").html("");    
            }, 333);

            renderCustomizationTable2();
        });
    });
    
    
}

function submitForm()
{
    var str = JSON.stringify(itemCustomization);
    console.log(str);
    $("#js").val(str);
    $("#customization_div").html('');
    
        return true;
}

function submitForm2()
{
    var str = JSON.stringify(itemCustomization2);
    console.log(str);
    $("#upd_js").val(str);
    $("#customization_div2").html('');
    
        return true;
}
</script>

