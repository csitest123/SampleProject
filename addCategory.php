<?php

include 'func.php';
checkSession();

beginPage('Add Category');
?>

<form id='f' method="post" action="op.php" enctype="multipart/form-data">
<input type='hidden' name='op' value='add_category' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Add Category</div>
            <div class='card-body'>
                Category Name
                <input type='text' class='form-control mt-1 mb-3' id='cat_name' name='cat_name' required />
                Image
                <input type='file' accept="image/*" class='form-control mt-1 mb-3' id='img' name='img' required />
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>ADD</button>
            </div>
        </div>
    </div>
</div>
</form>
