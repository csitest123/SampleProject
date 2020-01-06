<!doctype html>
<html>
    <head>
        <title>Delivery App : Login</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/7098157216.js"></script>
    </head>
    <body>
        <form id="f">
        <input type="hidden" name="op" value="login" />
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-md-6 col-sm-10 col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-light">Administrator Login</div>
                        <div class="card-body">
                            Username
                            <input type="email" class="form-control mt-1 mb-3" required id="un" name="un" />

                            Password
                            <input type="password" class="form-control mt-1 mb-3" required id="pw" name="pw" />
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">LOG IN</button>
                            <button type="button" id="fPW" class="btn btn-danger">I FORGOT MY PASSWORD</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </body>
</html>
<script>
$("#fPW").click(function()
{
    var em = $("#un").val();
    if (em == "")
    {
        alert("E-Mail Must Be Filled");
        return;
    }
    $.post("op.php", { op : "fpw", em : $("#un").val() }, function(d,s)
    {
        if (d.r == 1)
        {
            alert("Check Your Inbox");
        }
        else
        {
            alert("This E-Mail Is Not Registered");
        }
    });
});    
    
$("#f").submit(function(e)
{
    e.preventDefault();
    var v = $(this).serialize();
    console.log(v);
    $.post("op.php", v ,function(d,s)
    {
        if (d.r == 1)
        {
            location.href = "index.php";
        }
        else
        {
            alert("Invalid Credentials");
        }
    });
    return false;
});
    
</script>