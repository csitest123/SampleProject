<?php

include 'func.php';
checkSession();
$id = g("id");
$c = getDB();
$r = qW1R("select * from transportation_fees where id = $id", null, $c);
beginPage('Edit Transportation Fee');
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data" onsubmit="return checkData()">
<input type='hidden' name='op' value='upd_transportation_fee' />    
<input type='hidden' name='id' value='<?=$id;?>' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Edit Transportation Fee</div>
            <div class='card-body'>
                
                <div class="row">
                    <div class="col-12">
                        City
                        <select class='form-control mt-1 mb-3 selectpicker' id='city' name='city' required  data-size="10" data-live-search="true" title="Select">
                            <?php
                            $rs = qWMR("select * from cities order by city_name", null, $c);
                            $selCity = $r['city'];
                            foreach($rs as $rx)
                            {
                                $xId = $rx['id'];
                                $xAd = $rx['city_name'];
                                $sel = ($xId == $selCity ? "selected='selected'" : "");
                                echo "<option $sel value='$xId'>$xAd</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        Minimum Distance
                        <input type="number" min="0" max="1000000" id="min_distance" name="min_distance" required  class="form-control mt-1 " value="<?=$r['min_distance'];?>"/>
                    </div>
                    
                    <div class="col-4">
                        Maximum Distance
                        <input type="number" min="0" max="1000000" step="1" id="max_distance" name="max_distance" required  class="form-control mt-1 " value="<?=$r['max_distance'];?>"/>
                    </div>
                    
                    <div class="col-4">
                        Fee
                        <input type="number" min="0" step="0.01" max="1000000" id="fee" name="fee" required  class="form-control mt-1" value="<?=$r['fee'];?>"/>
                    </div>
                </div>
                
                
                
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>UPDATE</button>
                <button type='submit' class='btn btn-danger' id="btnDel">DELETE</button>
            </div>
        </div>
    </div>
</div>
</form>
<?php
    endPage();
?>
<script>
function checkData()
{
    var min = Number($("#min_distance").val());
    var max = Number($("#max_distance").val());
    
    if (min > max)
    {
        alert("Minimum Distance Must Be Smaller Than Maximum Distance");
        return false;
    }
    return true;
}


$("#btnDel").click(function()
{
    var o = confirm("Are You Sure ?");
    if (o)
    {
        $.post("op.php", { op : "del_transportation_fee", id : <?=$id;?> }, function(d,s) { location.href = "listTransportationFees.php" } );
    }
}); 
</script>