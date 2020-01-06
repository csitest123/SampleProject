<?php

include 'func.php';
checkSession();
$c = getDB();

$id = g("id");

beginPage('Edit Shop');
$rShop = qW1R("select * from shops where id = $id", null, $c);

?>
<form id='f' action="op.php" method="post" enctype="multipart/form-data">
<input type='hidden' name='op' value='upd_shop' />  
<input type='hidden' name='id' value='<?=$id;?>' />  
<div class='row mt-3 justify-content-center'>
    <div class='col-md-12 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Shop</div>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-6 col-6'>
                        Person In Charge
                        <input type='text' class='form-control mt-1 mb-3' id='shop_person' name='shop_person' required value="<?=$rShop['person'];?>" />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Phone Number
                        <input type='text' class='form-control mt-1 mb-3' id='shop_tel' name='shop_tel' required value="<?=$rShop['tel'];?>" />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Username
                        <input type='email' class='form-control mt-1 mb-3' id='shop_un' name='shop_un' required  value="<?=$rShop['un'];?>" />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Password <span style="float:right"><a href="#" id='genPass'>Generate Random Password</a></span>
                        <input type='text' class='form-control mt-1 mb-3' id='shop_pw' name='shop_pw' required  value="<?=$rShop['pw'];?>" />
                    </div>
                    
                    <div class='col-md-6 col-12'>
                        Shop Name
                        <input type='text' class='form-control mt-1 mb-3' id='shop_name' name='shop_name' required  value="<?=$rShop['shop_name'];?>" />
                    </div>
                    <div class='col-md-6 col-12'>
                        Shop Image <?php if ($rShop['shop_img'] != '' ) { ?> <span style="float:right"><a href="<?=$rShop['shop_img'];?>" target="_blank">View Image</a></span> <?php } ?>
                        <input type='file' class='form-control mt-1 mb-3' id='img' name='img' data-toggle="tooltip" title="If You Leave This Empty, Current Image Won't Be Deleted Or Updated" />
                    </div>
                    
                    <div class='col-md-6 col-12'>
                        Category
                        <select class='form-control mt-1 mb-3 selectpicker' id='cat_id' name='cat_id' required data-live-search='true' data-size='10' title='Select'>
                            <?php
                                $rs = qWMR("select * from categories", null, $c);
                                $catId = $rShop['cat_id'];
                                foreach($rs as $r)
                                {
                                    $xId = $r['id'];
                                    $xName = $r['cat_name'];
                                    $sel = ($xId == $catId ? "selected='selected'" : "");
                                    echo "<option $sel value='$xId'>$xName</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Shop Info
                        <input type='text' class='form-control mt-1 mb-3' id='shop_info' name='shop_info' required value="<?=$rShop['shop_info'];?>"/>
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        City
                        <select class='form-control mt-1 mb-3 selectpicker' id='shop_city' name='shop_city' required data-live-search='true' data-size='10' title='Select'>
                            <?php
                                $rs = qWMR("select * from cities", null, $c);
                                $cityId = $rShop['shop_city'];
                                foreach($rs as $r)
                                {
                                    $xId = $r['id'];
                                    $xName = $r['city_name'];
                                    $sel = ($xId == $cityId ? "selected='selected'" : "");
                                    echo "<option $sel value='$xId'>$xName</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Address
                        <input type='text' class='form-control mt-1 mb-3' id='shop_adr' name='shop_adr' required value="<?=$rShop['shop_adr'];?>" />
                    </div>
                    
                    
                    
                    
                    <div class='col-md-6 col-6'>
                        Location <span style='float:right'><a href='#' onclick="$('#mapModal').modal('show');">Select From Map</a></span>
                        <input type='text' class='form-control mt-1 mb-3' id='shop_loc' name='shop_loc' required value="<?=$rShop['shop_loc'];?>" />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        <div class='row'>
                            <div class='col-md-4 col-12'>
                                Serving Hours [Start]
                                <input type='time' class='form-control mt-1 mb-3' id='shop_start' name='shop_start' value="<?=$rShop['shop_active_start'];?>"  required />
                            </div>

                            <div class='col-md-4 col-12'>
                                Serving Hours [End]
                                <input type='time' class='form-control mt-1 mb-3' id='shop_end' name='shop_end' value="<?=$rShop['shop_active_end'];?>" required />
                            </div>
                            
                            <div class='col-md-4 col-12'>
                                Can Serve Right Now
                                 <select class='form-control mt-1 mb-3 selectpicker' id='can_serve' name='can_serve' required data-live-search='true' data-size='10' title='Select'>
                                    <option <?=$rShop['can_serve'] == "YES" ? "selected='selected'" : "";?> value='YES'>YES</option>
                                    <option <?=$rShop['can_serve'] == "NO" ? "selected='selected'" : "";?> value='NO'>NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class='card-footer text-right'>
                <a href="editMenu.php?id=<?=$id;?>" class="btn btn-dark">EDIT MENU</a>
                <button type='submit' class='btn btn-success'>UPDATE</button>
                <button type='button' id="btnDel" class='btn btn-danger'>DELETE</button>
            </div>
        </div>
    </div>
</div>
</form>


<!-- Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">Choose Location</div>
      <div class="modal-body" style="padding:0px;">
            <div id="map" style="height:500px;margin:0px">
              
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnUseLocation">USE MARKED LOCATION</button>
      </div>
    </div>
  </div>
</div>
<?php
endPage();

?>

<script>
    
$("#btnDel").click(function()
{
    var o = confirm("Are You Sure ?");
    if (o)
    {
        $.post("op.php", { op : "del_shop", id : <?=$id;?> }, function(d,s) { location.href = "listShops.php" } );
    }
});    
$("#btnUseLocation").click(function()
{
    $("#mapModal").modal('hide');
    
    var loc = marker.getPosition().lat()+","+marker.getPosition().lng();
   $("#shop_loc").val(loc);
});    

<?php

$tmp = explode(",", $rShop['shop_loc']);

if (count($tmp) == 2)
{
?>
var ilkCenter = {lat: <?=$tmp[0];?>, lng: <?=$tmp[1];?>};
<?php } else { ?>
    
var ilkCenter = {lat: 11.683211269105458, lng: 17.64892578125};
<?php } ?>
var map;


var marker;

    
$("#genPass").click(function()
{
   var result           = '';
   var characters       = 'ABCDEF123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < 6; i++ ) 
   {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   
    $("#shop_pw").val(result);
});


function initMap()
{
    map = new google.maps.Map(document.getElementById('map'), 
    {
      center: ilkCenter,
      zoom: 6
    });


    marker = new google.maps.Marker(
    {
        position: ilkCenter,
        map: map,
        draggable:true,
        title: 'Shop Location'

    });
    
    console.log("Marker Created : ");
    
    marker.addListener('dragEnd', function(e) 
    {
        console.log("move");

    });
}

</script>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtwCm5qw7S7ruArmqyZxE-pyIs4b9bNcs&libraries=places&callback=initMap" async defer></script>