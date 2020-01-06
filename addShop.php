<?php

include 'func.php';
checkSession();
$c = getDB();

beginPage('Add Shop');
/*
 * $fPath = saveFile($_FILES['img'], $dir);
    
    $q = "insert into shops values (0, :cat_id, :shop_name, :shop_type, :img, :info, :adr, :city, :loc, :start, :end, '[]', :can_serve)";
    
    qWNR($q, array(
        'cat_id' => p("cat_id"),
        'shop_name' => p("shop_name"),
        'shop_type' => p("shop_type"),
        'img' => $fPath,
        'info' => p("shop_info"),
        'adr' => p("shop_adr"),
        'city' => p("shop_city"),
        'loc' => p("shop_loc"),
        'start' => p("shop_start"),
        'end' => p("shop_end"),
        'can_serve' => p("can_serve")
        ), $c);
 */
?>
<form id='f' action="op.php" method="post" enctype="multipart/form-data">
<input type='hidden' name='op' value='add_shop' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-12 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Add Shop</div>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-6 col-6'>
                        Person In Charge
                        <input type='text' class='form-control mt-1 mb-3' id='shop_person' name='shop_person' required />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Phone Number
                        <input type='text' class='form-control mt-1 mb-3' id='shop_tel' name='shop_tel' required />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Username
                        <input type='email' class='form-control mt-1 mb-3' id='shop_un' name='shop_un' required />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Password <span style="float:right"><a href="#" id='genPass'>Generate Random Password</a></span>
                        <input type='text' class='form-control mt-1 mb-3' id='shop_pw' name='shop_pw' required />
                    </div>
                    
                    <div class='col-md-6 col-12'>
                        Shop Name
                        <input type='text' class='form-control mt-1 mb-3' id='shop_name' name='shop_name' required />
                    </div>
                    <div class='col-md-6 col-12'>
                        Shop Image
                        <input type='file' class='form-control mt-1 mb-3' id='img' name='img' required />
                    </div>
                    
                    <div class='col-md-6 col-12'>
                        Category
                        <select class='form-control mt-1 mb-3 selectpicker' id='cat_id' name='cat_id' required data-live-search='true' data-size='10' title='Select'>
                            <?php
                                $rs = qWMR("select * from categories", null, $c);
                                foreach($rs as $r)
                                {
                                    $xId = $r['id'];
                                    $xName = $r['cat_name'];
                                    echo "<option value='$xId'>$xName</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Shop Info
                        <input type='text' class='form-control mt-1 mb-3' id='shop_info' name='shop_info' required />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        City
                        <select class='form-control mt-1 mb-3 selectpicker' id='shop_city' name='shop_city' required data-live-search='true' data-size='10' title='Select'>
                            <?php
                                $rs = qWMR("select * from cities", null, $c);
                                foreach($rs as $r)
                                {
                                    $xId = $r['id'];
                                    $xName = $r['city_name'];
                                    echo "<option value='$xId'>$xName</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        Address
                        <input type='text' class='form-control mt-1 mb-3' id='shop_adr' name='shop_adr' required />
                    </div>
                    
                    
                    
                    
                    <div class='col-md-6 col-6'>
                        Location <span style='float:right'><a href='#' onclick="$('#mapModal').modal('show');">Select From Map</a></span>
                        <input type='text' class='form-control mt-1 mb-3' id='shop_loc' name='shop_loc' required />
                    </div>
                    
                    <div class='col-md-6 col-6'>
                        <div class='row'>
                            <div class='col-md-4 col-12'>
                                Serving Hours [Start]
                                <input type='time' class='form-control mt-1 mb-3' id='shop_start' name='shop_start' required />
                            </div>

                            <div class='col-md-4 col-12'>
                                Serving Hours [End]
                                <input type='time' class='form-control mt-1 mb-3' id='shop_end' name='shop_end' required />
                            </div>
                            
                            <div class='col-md-4 col-12'>
                                Can Serve Right Now
                                 <select class='form-control mt-1 mb-3 selectpicker' id='can_serve' name='can_serve' required data-live-search='true' data-size='10' title='Select'>
                                    <option value='YES'>YES</option>
                                    <option value='NO'>NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>ADD</button>
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
    
$("#btnUseLocation").click(function()
{
    $("#mapModal").modal('hide');
    
    var loc = marker.getPosition().lat()+","+marker.getPosition().lng();
   $("#shop_loc").val(loc);
});    
   
var ilkCenter = {lat: 11.683211269105458, lng: 17.64892578125};
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