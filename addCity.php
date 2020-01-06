<?php

include 'func.php';
checkSession();

beginPage('Add City');
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='add_city' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Add City</div>
            <div class='card-body'>
                City Name
                <input type='text' class='form-control mt-1 mb-3' id='city_name' name='city_name' required />
                
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>ADD</button>
            </div>
        </div>
    </div>
</div>
</form>
