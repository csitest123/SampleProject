<?php

include 'func.php';
checkSession();
$c = getDB();
beginPage('Add Transportation Fee');
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data" onsubmit="return checkData()">
<input type='hidden' name='op' value='add_transportation_fee' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Add Transportation Fee</div>
            <div class='card-body'>
                
                <div class="row">
                    <div class="col-12">
                        City
                        <select class='form-control mt-1 mb-3 selectpicker' id='city' name='city' required  data-size="10" data-live-search="true" title="Select">
                            <?php
                            $rs = qWMR("select * from cities order by city_name", null, $c);
                            foreach($rs as $r)
                            {
                                $xId = $r['id'];
                                $xAd = $r['city_name'];
                                echo "<option value='$xId'>$xAd</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        Minimum Distance
                        <input type="number" min="0" max="1000000" id="min_distance" name="min_distance" required  class="form-control mt-1 " value="0"/>
                    </div>
                    
                    <div class="col-4">
                        Maximum Distance
                        <input type="number" min="0" max="1000000" step="1" id="max_distance" name="max_distance" required  class="form-control mt-1 " value="0"/>
                    </div>
                    
                    <div class="col-4">
                        Fee
                        <input type="number" min="0" step="0.01" max="1000000" id="fee" name="fee" required  class="form-control mt-1"/>
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
</script>