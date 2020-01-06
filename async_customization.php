<div class="row">
    <div class="col-md-6 col-12">
        Option Name
        <input type="text" class="xx form-control mt-1 mb-3" id="new_option_name"  required />
    </div>

    <div class="col-md-6 col-12">

        Option Type
        <select class="xx yy form-control mt-1 mb-3 selectpicker" id="new_option_type" required data-live-search="true" title="Select" >
            <option value="SC1">Single - Required</option>
            <option value="SC0">Single - Non Required</option>
            <option value="MC1">Multiple - At Least 1 Required</option>
            <option value="MC0">Multiple - Non Required</option>
        </select>
    </div>
</div>
<div class="row mb-3" style="overflow: hidden;overflow-y: scroll;height:200px">
<?php
for ($i = 0; $i<10; $i++)
{
    ?>
    <div class="col-6 mb-2">
        <input type="text" class="xx form-control" id="opt_choice_<?=$i;?>" name="opt_choice_<?=$i;?>"  placeholder="Choice Name #<?=($i+1);?>"/>
    </div>

    <div class="col-6 mb-2">
        <input type="text" class="xx form-control" id="opt_price_<?=$i;?>"  name="opt_price_<?=$i;?>" placeholder="Price Change #<?=($i+1);?>"/>
    </div>
    <?php
}
?>
    <div class="col-12">
        <button type="button" id="btnAddCustomization" class="btn btn-success btn-block">ADD CUSTOMIZATION</button>
    </div>
</div>