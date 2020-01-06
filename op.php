<?php

include 'func.php';

$c = getDB();


$op = p("op");

if ($op == "login")
{
    $un = p("un");
    $pw = p("pw");
    
    $r = qW1R("select count(*) as 'cnt', id, pn, un from admins where un = :un and pw = :pw", array('un' => $un, 'pw' => $pw), $c);
    if ($r['cnt'] == 0)
    {
        toJSON(array('r' => 0));
    }
    
    if ($r['cnt'] == 1)
    {
        session_start();
        $_SESSION['da_admin_logged'] = 1;
        $_SESSION['id'] = $r['id'];
        $_SESSION['pn'] = $r['pn'];
        $_SESSION['un'] = $r['un'];
        toJSON(array('r' => 1));
    }
}

if ($op == "fpw")
{
    $un = p("em");
    $r = qW1R("select count(*) as 'cnt', pn, un, pw from admins where un = :un", array('un' => $un), $c);
    
    if ($r['cnt'] == 0)
    {
        toJSON(array('r' => 0));
    }
    
    if ($r['cnt'] == 1)
    {
        $title = "Password Reminder";
        $msg = "Dear ".$r['pn']." Your Password Is : ".$r['pw'];
        sendMail($r['un'], $title, $msg);
        
        toJSON(array('r' => 1));
    }
    
}

if ($op == "change_pw")
{
    checkSession();
    $id = s("id");
    
    $opw = p("opw");
    $npw = p("npw");
    
    $cnt = qW1R("select count(*) as 'cnt' from admins where id = $id and pw = :pw", array('pw' => $opw), $c)['cnt'];
    if ($cnt == 0)
    {
        toJSON(array('r' => 0));
    }
    if ($cnt == 1)
    {
        qWNR("update admins set pw = :pw where id = $id", array('pw' => $npw), $c);
        toJSON(array('r' => 1));
    }
}

if ($op == "add_customer")
{
    checkSession();
    
    $cnt1 = qW1R("select count(*) as 'cnt' from customers where em = :em", array('em' => p("em")), $c)['cnt'];
    $cnt2 = qW1R("select count(*) as 'cnt' from customers where tel = :tel", array('tel' => p("tel")), $c)['cnt'];
    
    if ($cnt1 == 1)
    {
        toJSON(array('r' => -1)); // Email Registered
        exit;
    }
    
    if ($cnt2 == 1)
    {
        toJSON(array('r' => -2)); // Tel Registered
        exit;
    }
    
    $params = array('fn' => p("fn"), 'em' => p("em"), 'pw' => p("pw"), 'tel' => p("tel"), 'balance' => p("balance"), 'can_transfer' => p("can_transfer"), 'can_receive' => p("can_receive"));
    qWNR("insert into customers values (0, :fn, :em, :pw, :tel, :balance, :can_transfer, :can_receive)", $params, $c);
    
    $id = $c->lastInsertId();
    go("updCustomer.php?id=$id");
}

if ($op == "upd_customer")
{
    checkSession();
    
    $params = array('id' => p("id"), 'fn' => p("fn"), 'em' => p("em"), 'pw' => p("pw"), 'tel' => p("tel"), 'cust_balance' => p("balance"), 'can_transfer' => p("can_transfer"), 'can_receive' => p("can_receive"));
    qWNR("update customers set cust_name = :fn, cust_em = :em, cust_pw = :pw, cust_tel = :tel, cust_balance = :cust_balance, can_transfer_balance = :can_transfer, can_receive_balance = :can_receive where id = :id", $params, $c);
    
    $id = p("id");
    go("updCustomer.php?id=$id");
}

if ($op == "del_customer")
{
    checkSession();
    
    $id = p("id");
    qWNR("delete from customers where id = $id", null, $c);
    qWNR("delete from customer_addresses where cust_id = $id", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "add_customer_address")
{
    checkSession();
    $q = "insert into customer_addresses values (0, :cid, :adr_name, :adr_text)";
    qWNR($q, array('cid' => p("cid"), 'adr_name' => p("adr_name"), 'adr_text' => p("adr_text") ), $c);
    toJSON(array('r' => 1));
}

if ($op == "upd_customer_address")
{
    checkSession();
    
    $q = "update customer_addresses set cust_adr_name = :adr_name, cust_adr_text = :adr_text where id = :id";
    qWNR($q, array('adr_name' => p("adr_name"), 'adr_text' => p("adr_text"), 'id' => p("id")), $c);
    toJSON(array('r' => 1));
}

if ($op == "del_customer_address")
{
    checkSession();
    
    $id = p("id");
    
    qWNR("delete from customer_addresses where id = $id", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "add_city")
{
    checkSession();
    
    qWNR("insert into cities values (0, :city_name)", array('city_name' => p("city_name")), $c);
    $id = $c->lastInsertId();
    go("updCity.php?id=$id");
}

if ($op == "upd_city")
{
    checkSession();
    
    qWNR("update cities set city_name = :city_name where id = :id", array('city_name' => p("city_name"), 'id' => p("id")), $c);
    
    $id = p("id");
    go("updCity.php?id=$id");
}

if ($op == "del_city")
{
    checkSession();
    $id = p("id");
    
    qWNR("delete from cities where id = $id", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "add_category")
{
    checkSession();
    
    $dir = "uploads/category_images/";
    $fPath = saveFile($_FILES['img'], $dir);
    
    qWNR("insert into categories values (0, :cat_name, :img)", array('cat_name' => p("cat_name"), 'img' => $fPath), $c);
    $id = $c->lastInsertId();
    go("updCategory.php?id=$id");
    
}

if ($op == "upd_category")
{
    checkSession();
    
    $dir = "uploads/category_images/";
    $fPath = saveFile($_FILES['img'], $dir);
    
    if ($fPath == "")
    {
        qWNR("update categories set cat_name = :cat_name where id = :id", array('id' => p("id"), 'cat_name' => p("cat_name")), $c);
    }
    else
    {
        qWNR("update categories set cat_name = :cat_name, cat_img = :img where id = :id", array('id' => p("id"), 'cat_name' => p("cat_name"), 'img' => $fPath), $c);
    }
    
    go("updCategory.php?id=".p("id"));
}

if ($op == "del_category")
{
    checkSession();
    $id = p("id");
    qWNR("delete from categories where id = $id", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "add_shop")
{
    checkSession();
    
    $dir = "uploads/shop_images/";
    $fPath = saveFile($_FILES['img'], $dir);
    
    $q = "insert into shops values (0, :cat_id, :shop_name, :img, :info, :adr, :city, :loc, :start, :end, '[]', :can_serve, :person, :tel, :un, :pw)";
    
    qWNR($q, array(
        'cat_id' => p("cat_id"),
        'shop_name' => p("shop_name"),
       
        'img' => $fPath,
        'info' => p("shop_info"),
        'adr' => p("shop_adr"),
        'city' => p("shop_city"),
        'loc' => p("shop_loc"),
        'start' => p("shop_start"),
        'end' => p("shop_end"),
        'can_serve' => p("can_serve"),
        'person' => p("shop_person"),
        'tel' => p("shop_tel"),
        'un' => p("shop_un"),
        'pw' => p("shop_pw")
        ), $c);
 
    $id = $c->lastInsertId();
    go("updShop.php?id=$id");
}

if ($op == "upd_shop")
{
    checkSession();
    
    $dir = "uploads/shop_images/";
    $fPath = saveFile($_FILES['img'], $dir);
    
    if ($fPath == "")
    {
      
        $q = "update shops set cat_id = :cat_id, shop_adr = :adr, shop_name = :shop_name, shop_info = :info,  shop_city = :city, shop_loc = :loc, shop_active_start = :start, shop_active_end = :end, can_serve = :can_serve, person = :person, tel = :tel, un = :un, pw = :pw where id = :id ";
        $params = array( 'cat_id' => p("cat_id"), 'shop_name' => p("shop_name"),   'info' => p("shop_info"), 'adr' => p("shop_adr"), 'city' => p("shop_city"), 'loc' => p("shop_loc"), 'start' => p("shop_start"), 'end' => p("shop_end"),  'can_serve' => p("can_serve"), 'id' => p("id"), 'person' => p("shop_person"), 'tel' => p("shop_tel"), 'un' => p("shop_un"), 'pw' => p("shop_pw") );
        qWNR($q, $params, $c);
    }
    else
    {
        $q = "update shops set cat_id = :cat_id, shop_adr = :adr, shop_name = :shop_name,  shop_img = :img, shop_info = :info, shop_adr = :adr,  shop_city = :city, shop_loc = :loc, shop_active_start = :start, shop_active_end = :end, can_serve = :can_serve where id = :id ";
        $params = array( 'cat_id' => p("cat_id"), 'shop_name' => p("shop_name"),  'img' => $fPath, 'info' => p("shop_info"), 'adr' => p("shop_adr"), 'city' => p("shop_city"), 'loc' => p("shop_loc"), 'start' => p("shop_start"), 'end' => p("shop_end"),'can_serve' => p("can_serve"),  'id' => p("id"), 'img' => $fPath );
        qWNR($q, $params, $c);
    }
    
    $id = p("id");
    go("updShop.php?id=$id");
}

if ($op == "set_shop_menu")
{
    checkSession();
    
    qWNR("update shops set shop_js = :js where id = :id", array('js' => p("js"), 'id' => p("id")), $c);
    toJSON(array('r' => 1));
}


if ($op == "del_shop")
{
    checkSession();
    $id = p("id");
    qWNR("delete from shops where id = $id", null, $c);
    
    toJSON(array('r' => 1));
}

if ($op == "add_coupon")
{
    checkSession();
    
    $q = "insert into coupons values (0, '', :min_basket_price, :discount_type, :discount_value, :assigned_to, '', '', '', :valid_until )";
    qWNR($q, array( 'min_basket_price' => p("min_basket_price"), 'discount_type' => p("discount_type"), 'discount_value' => p("discount_value"), 'assigned_to' => p("assigned_to"), 'valid_until' => p("valid_until")), $c);
    $id = $c->lastInsertId();
    $kod = strtoupper(dechex($id));
    qWNR("update coupons set coupon_code = '$kod' where id = $id", null, $c);
    go("updCoupon.php?id=$id");
}


if ($op == "upd_coupon")
{
    checkSession();
    
    qWNR("update coupons set min_basket_price = :min_basket_price, discount_type = :discount_type, assigned_to = :assigned_to, discount_value = :discount_value, valid_until = :valid_until where id = :id", 
            array('min_basket_price' => p("min_basket_price"), 'discount_type' => p("discount_type"), 'discount_value' => p("discount_value"),  'valid_until' => p("valid_until"), 'assigned_to' => p("assigned_to"), 'id' => p("id")) , $c);
     go("updCoupon.php?id=".p("id"));
}

if ($op == "del_coupon")
{
    checkSession();
    
    $id = p("id");
    
    qWNR("delete from coupons where id = $id", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "add_transportation_fee")
{
    checkSession();
    
    $q = "insert into transportation_fees values (0, :city, :min_distance,  :max_distance, :fee)";
    qWNR($q, array('city' => p("city"), 'min_distance' => p("min_distance"), 'max_distance' => p("max_distance"), 'fee' => p("fee") ), $c);
    $id = $c->lastInsertId();
    go("updTransportationFee.php?id=$id");
}

if ($op == "upd_transportation_fee")
{
    checkSession();
    $q = "update transportation_fees set city = :city, min_distance = :min_distance, max_distance = :max_distance, fee = :fee where id = :id";
    qWNR($q, array('city' => p("city"),  'min_distance' => p("min_distance"), 'max_distance' => p("max_distance"), 'fee' => p("fee"), 'id' => p("id")), $c);
    $id = p("id");
    go("updTransportationFee.php?id=$id");
}

if ($op == "del_transportation_fee")
{
    checkSession();
    $id = p("id");
    qWNR("delete from transportation_fees where id = $id", null, $c);
    toJSON(array('r' => 1));
}
   
if ($op == "add_transaction")
{
    checkSession();
    $tId = md5(uniqid());
    $from = p("from");
    $to = p("top");
    $amount = number_format(p("amount"), 2, '.', '.');
    
    qWNR("insert into balance_transactions values (0, :tid, now(), :from, :to, :amount)", array('tid' => $tId, 'from' => $from, 'to' => $to, 'amount' => $amount), $c);
    toJSON(array('r' => 1));
}

if ($op == "clear_transaction_history")
{
    checkSession();
    qWNR("delete from balance_transactions", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "clear_single_transaction_history")
{
    checkSession();
    $id = p("tId");
    qWNR("delete from balance_transactions where transaction_id = :tid", array('tid' => $id), $c);
    toJSON(array('r' => 1));
}

if ($op == "add_section")
{
    checkSession();
    $shopId = p("shop_id");
    $sectionName = p("section_name");
    
    qWNR("insert into menu_sections values (0, :shop_id, :section_name)", array('shop_id' => $shopId, 'section_name' => $sectionName), $c);
    toJSON(array('r' => 1));
}

if ($op == "upd_section")
{
    checkSession();
    $shopId = p("shop_id");
    $sectionId = p("section_id");
    $sectionName = p("section_name");
    
    qWNR("update menu_sections set section_name = :section_name where shop_id = :shop_id and id = :section_id", array('shop_id' => $shopId, 'section_id' => $sectionId, 'section_name' => $sectionName), $c);
    toJSON(array('r' => 1));
}

if ($op == "del_section")
{
    checkSession();
    $shopId = p("shop_id");
    $sectionId = p("section_id");
    qWNR("delete from menu_sections where shop_id = :shop_id and id = :section_id",  array('shop_id' => $shopId, 'section_id' => $sectionId), $c);
    
    // TODO : Section'i Degisken Itemleri Update Et
    qWNR("update menu_items set section_id = '' where section_id = $sectionId and shop_id = $shopId", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "add_item")
{
    checkSession();
    outPOST();
    outFILES();
    
    $dir = "uploads/item_images/";
    $fPath = saveFile($_FILES['item_img'], $dir);
    
    $q = "insert into menu_items values (0, :shop_id, :section_id, :item_name, :item_info, :item_img, :item_price, :item_in_stocks, :js, 0)";
    $params = array(
        'shop_id' => p('shop_id'),
        'section_id' => p('section_id'),
        'item_name' => p('item_name'),
        'item_info' => p('item_info'),
        'item_img' => $fPath,
        'item_price' => p('item_price'),
        'js' => p('js'),
        'item_in_stocks' => p('item_in_stocks')
    );
    
    qWNR($q, $params, $c);
    
    go("editMenu.php?id=".p('shop_id'));
}

if ($op == "get_item")
{
    checkSession();
    $id = p("id");
    toJSON(qW1R("select * from menu_items where id = $id", null, $c));
}

if ($op == "upd_item")
{
    checkSession();
    outPOST();
    outFILES();
    
    $dir = "uploads/item_images/";
    $fPath = saveFile($_FILES['item_img'], $dir);
    
    if ($fPath == "")
    {
        $q = "update menu_items  set  section_id = :item_section, item_name = :item_name, item_info = :item_info, item_price = :item_price, item_in_stocks = :item_in_stocks, js = :js  where id = :item_id and shop_id = :shop_id";
        $params = array
        (
            'item_name' => p("upd_item_name"),
            'item_info' => p("upd_item_info"),
            'item_price' => p("upd_item_price"),
            'item_in_stocks' => p("upd_item_in_stocks"),
            'item_section' => p("upd_item_menu_section"),
            'js' => p("upd_js"),
            'item_id' => p("upd_item_id"),
            'shop_id' => p("upd_shop_id")
        );
        qWNR($q, $params, $c);
    }
    else
    {
        $q = "update menu_items  set  section_id = :item_section, item_name = :item_name, item_info = :item_info, item_img = :item_img, item_price = :item_price, item_in_stocks = :item_in_stocks, js = :js  where id = :item_id and shop_id = :shop_id";
        $params = array
        (
            'item_name' => p("upd_item_name"),
            'item_info' => p("upd_item_info"),
            'item_price' => p("upd_item_price"),
            'item_in_stocks' => p("upd_item_in_stocks"),
            'item_section' => p("upd_item_menu_section"),
            'item_img' => $fPath,
            'js' => p("upd_js"),
            'item_id' => p("upd_item_id"),
            'shop_id' => p("upd_shop_id")
        );
        qWNR($q, $params, $c);
    }
    
    go("editMenu.php?id=".p("upd_shop_id"));
}

if ($op == "del_item")
{
    checkSession();
    $id = p("id");
    qWNR("delete from menu_items where id = $id", null, $c);
}

if ($op == "import_items")
{
    checkSession();
    
    $fPath = saveFile($_FILES['xls'], "uploads/excels/");
    
    require_once 'lib/PHPExcel/IOFactory.php';
    require 'lib/PHPExcel.php';
    
    $xlsReader = PHPExcel_IOFactory::createReader('Excel2007');
    $xls = $xlsReader->load($fPath);
    $sh = new PHPExcel_Worksheet();
    $sh = $xls->getSheet(0);
    
    $q = "insert into pre_defined_items values (0, :itName, :itInfo, :itPrice, :itStocks, :itImg)";
    for ($i = 2; $i<=1001; $i++)
    {
        $itName = $sh->getCellByColumnAndRow(0, $i)->getValue();
        $itInfo = $sh->getCellByColumnAndRow(1, $i)->getValue();
        $itPrice = $sh->getCellByColumnAndRow(2, $i)->getFormattedValue();
        $itInStock = $sh->getCellByColumnAndRow(3, $i)->getValue();
        $itImg = $sh->getCellByColumnAndRow(4, $i)->getValue();
        
        if ($itName == "")
            continue;
        
        if ($itPrice == "") $itPrice =  "0.00";
        
        if ($itInStock == "" || ($itInStock != "YES" && $itInStock != "NO")) $itInStock = "YES";
        
        $params = array(
            'itName' => $itName,
            'itInfo' => $itInfo,
            'itPrice' => $itPrice,
            'itStocks' => $itInStock,
            'itImg' => $itImg
        );
        
        qWNR($q, $params, $c);
        
    }
    
    $sh = null;
    $xls = null;
    unset($fPath);
    
    go("listPreDefinedItems.php");
    
}

if ($op == "add_pre_defined_item")
{
    checkSession();
    $dir = "uploads/item_images/";
    $fPath = saveFile($_FILES['item_img'], $dir);
    
    $q = "insert into pre_defined_items values (0, :itName, :itInfo, :itPrice, :itStock, :itImg)";
    $params = array(
        'itName' => p("item_name"),
        'itInfo' => p("item_info"),
        'itPrice' => p("item_price"),
        'itStock' => p("item_in_stocks"),
        'itImg' => $fPath
    );
    qWNR($q, $params, $c);
    
    $id = $c->lastInsertId();
    go("updPReDefinedItem.php?id=$id");
    
    
}

if ($op == "upd_pre_defined_item")
{
    checkSession();
    $id = p("id");
    
    $fPath = saveFile($_FILES['item_img'], $dir);
    
    if ($fPath == "")
    {
        $q = "update pre_defined_items set item_name = :itName, item_info = :itInfo, item_price = :itPrice, item_in_stocks = :itStock where id = :id";
        $params = array(
        'id' => p("id"),
        'itName' => p("item_name"),
        'itInfo' => p("item_info"),
        'itPrice' => p("item_price"),
        'itStock' => p("item_in_stocks")
        );
        
        qWNR($q, $params, $c);
        
    
    }
    else
    {
        $q = "update pre_defined_items set item_name = :itName, item_info = :itInfo, item_price = :itPrice, item_in_stocks = :itStock, item_img = :itImg where id = :id";
        $params = array(
        'id' => p("id"),
        'itName' => p("item_name"),
        'itInfo' => p("item_info"),
        'itPrice' => p("item_price"),
        'itStock' => p("item_in_stocks"),
        'itImg' => $fPath    
        );
        
        qWNR($q, $params, $c);
    }
    
    go("updPreDefinedItem.php?id=$id");
}

if ($op == "del_pre_defined_item")
{
    checkSession();
    $id = p("id");
    qWNR("delete from pre_defined_items where id = $id", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "upd_order_status")
{
    checkSession();
    
    $id = p("id");
    $order_status = p("status");
    $reason = "";
    if ($order_status == "CANCELLED")
    {
        $reason  = p("reason");
    }
    
    qWNR("update orders set order_status = :stat, cancel_reason = :reason where id = :id", array('stat' => $order_status, 'reason' => $reason, 'id' => $id), $c);
    toJSON(array('r' => 1));
}

if ($op == "edit_help")
{
    checkSession();
    outPOST();
    
    $q = "update help_page set txt = :txt where id = 1";
    qWNR($q, array('txt' => p("txt")), $c);
    go("editHelpPage.php");
}