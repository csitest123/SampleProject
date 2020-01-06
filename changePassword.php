<?php

include 'func.php';
checkSession();

beginPage('Change Password');
?>

<form id='f'>
<input type='hidden' name='op' value='change_pw' />    
<div class='row mt-3 justify-content-center'>
    <div class='col-md-4 col-12'>
        <div class='card'>
            <div class='card-header bg-dark text-light'>Change Password</div>
            <div class='card-body'>
                Current Password
                <input type='password' class='form-control mt-1 mb-3' id='opw' name='opw' required />
                New Password
                <input type='text' class='form-control mt-1 mb-3' id='npw' name='npw' required />
            </div>
            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-success'>CHANGE PASSWORD</button>
            </div>
        </div>
    </div>
</div>
</form>
<?php
endPage();
?>
<script>
$("#f").submit(function(e)
{
    e.preventDefault();
    $.post("op.php", $(this).serialize(), function(d,s)
    {
        if (d.r == 1)
        {
            alert("Password Changed");
            $("#opw").val('');
            $("#npw").val('');
            
        }
        if (d.r == 0)
        {
            alert("Current Password Is Wrong");
        }
    })
    return false;
});    
</script>