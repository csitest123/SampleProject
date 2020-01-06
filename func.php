<?php

function beginPage($title)
{
?>

<!doctype html>
<html>
    <head>
        <title><?=$title;?></title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/7098157216.js"></script>
        <link rel="stylesheet" href="select.css">
        <script src="select.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/r-2.2.3/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/>
        
        <!--
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        -->
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/r-2.2.3/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="border-bottom:2px solid #DDDDDD">
            <a class="navbar-brand" href="index.php"><b>Delivery App</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active" style="padding-right: 30px"><a class="nav-link" href="listCustomers.php">Customers</a></li>
                    <li class="nav-item active" style="padding-right: 30px"><a class="nav-link" href="listShops.php">Shops</a></li>
                    <li class="nav-item active" style="padding-right: 30px"><a class="nav-link" href="listPreDefinedItems.php">Pre Defined Items</a></li>
                    <li class="nav-item active" style="padding-right: 30px"><a class="nav-link" href="listOrders.php">Orders</a></li>
                
                    <li class="nav-item dropdown active" style="padding-right:30px">
                        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="listCategories.php">Categories</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="listCities.php">Cities</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="listTransportationFees.php">Transportation Fees</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="listBalanceTransactions.php">Balance Transactions</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="listCoupons.php">Coupons</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="editHelpPage.php">Help Page</a>
                            
                            
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown active">
                        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b><?=$_SESSION['pn'];?></b></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="changePassword.php">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="exit.php">Log Out</a>
                    </div>
                    </li>
                </ul>
            
            </div>
        </nav>
        <div class="container-fluid">
<?php    
}

function endPage()
{
?>
</div>            
</body>
</html>
<script>
$(document).ready(function()
{
    $('[data-toggle="tooltip"]').tooltip();
});    
</script>
<?php
}

function getFileExtension($dosyaAdi)
{
    return strtolower(pathinfo($dosyaAdi,PATHINFO_EXTENSION));
}

function getRandomFileName($dosyaAdi)
{
    $dosyaTuru = getFileExtension($dosyaAdi);
    $yeniAd = md5(uniqid(mt_rand(), true)).".".$dosyaTuru;
    return $yeniAd;
}

function saveFile($FILE, $folder)
{
    $fPath = "";
    if ($FILE['size'] != "")
    {
        $dosyaAdi = getRandomFileName(basename($FILE["name"]));
        $fPath = $folder.$dosyaAdi;
        move_uploaded_file($FILE['tmp_name'], $fPath);
    }
    return $fPath;
}

function checkSession()
{
    session_start();
    if (!isset($_SESSION['da_admin_logged']))     
    {
        session_destroy();
        header("Location: exit.php");
    }
}

function outPOST()
{
    echo '<pre>'.print_r($_POST, true).'</pre>';
}

function outSESSION()
{
    echo '<pre>'.print_r($_SESSION, true).'</pre>';
}

function outGET()
{
    echo '<pre>'.print_r($_GET, true).'</pre>';
}

function outFILES()
{
    echo '<pre>'.print_r($_FILES, true).'</pre>';
}

function outDATA($data)
{
    echo '<pre>'.print_r($data, true).'</pre>';
}

function p($op)
{
    return isset($_POST[$op]) ? $_POST[$op] : "NAN";
}

function g($op)
{
    return isset($_GET[$op]) ? $_GET[$op] : "NAN";
}

function s($op)
{
    return isset($_SESSION[$op]) ? $_SESSION[$op] : "NAN";
}

function f($op)
{
    return ($_FILES[$op]['size'] != "") ? $_FILES[$op] : "NAN";
}

function toJSON($arr, $setHeader = true, $return = false)
{
    if ($setHeader)
    {
        header("Content-Type: application/json");
    }
    if (!$return)
    echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    else
        return json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

function toArr($json)
{
    $arr = json_decode($json, true);
    return $arr;
}

function go($page)
{
    header('Location: '.$page);
}

function getDB() 
{
    $test = 0;
    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db_name = "emir_da";
    
    
    if ($test == 0)
    {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db_name = "emir_da";
    }
    
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $user,$pass);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    return $db;
}

function closeDB($c)
{
    $c = null;
}

function qW1R($sqlQuery, $params = array(), PDO $c = null)
{
    try
    {
        $query = $c->prepare($sqlQuery);
        $query->execute($params);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    } 
    catch (Exception $ex) 
    {
        dbError($sqlQuery, $params, $ex);
    }
}

function qWMR($sqlQuery, $params = array(), PDO $c = null)
{
    try
    {
        $query = $c->prepare($sqlQuery);
        $query->execute($params);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } 
    catch (Exception $ex) 
    {
        dbError($sqlQuery, $params, $ex);
    }
}

function qWNR($sqlQuery, $params = array(), PDO $c = null)
{
    try
    {
        $query = $c->prepare($sqlQuery);
        $result = $query->execute($params);
        return $result;
    } 
    catch (Exception $ex) 
    {
        dbError($sqlQuery, $params, $ex);
    }
}

function dbError($sqlQuery, $params = array(), Exception $ex)
{
    echo "<pre>";
    $data = array
    (
        'File' => $ex->getFile(),
        'Line' => $ex->getLine(),
        'Code' => $ex->getCode(),
        'Message' => $ex->getMessage(),
        'SQL' => $sqlQuery,
        'Params' => print_r($params, true)
    );
    print_r($data);
    echo "</pre>";
}

function sendMail($kime, $baslik, $mesaj)
{
    $db  = getDB();
    
    require_once './lib/Mailer/PHPMailer.php';
    require_once './lib/Mailer/Exception.php';
    require_once './lib/Mailer/SMTP.php';
    require_once './lib/Mailer/OAuth.php';
    

    $host = "smtp.yandex.ru";
    $port = "587";
    $protokol = "ssl";
    $mail_ad = "Market Lojistik";
    $mail_user = "market.lojistik@yandex.com";
    $mail_pass = "MLSerkan1453!";
    
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
    $mail->CharSet = 'UTF-8';
    $mail->setFrom($mail_user, $mail_ad);
    $mail->addAddress($kime);
    $mail->Subject = $baslik;
    $mail->Body = $mesaj;
    $mail->isHTML(true);

    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth = TRUE;
   
    $mail->Username = $mail_user;
    $mail->Password = $mail_pass;
    $mail->Port = $port;

    closeDB($db);
    return $mail->send();
}
