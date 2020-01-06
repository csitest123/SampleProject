<?php

include 'func.php';

$op = p("op");
$c  = getDB();

if ($op == "send_money")
{
    $from = p("id");
    $to = p("to");
    $amount = p("amount");
    
    $currBalance = qW1R("select format(cust_balance,2) as 'x' from customers where id = $from", null, $c)['x'];
    
    
    if ($currBalance < $amount)
    {
        toJSON(array('r' => -2));
        exit;
    }
    
    $cnt = qW1R("select count(*) as 'cnt' from customers where cust_em = :to and id != $from", array('to' => $to), $c)['cnt'];
    
    if ($cnt != 1)
    {
        toJSON(array('r' => -1));
        exit;
    }
    
    if ($cnt == 1)
    {
        $canReceive = qW1R("select can_receive_balance as 'x' from customers where cust_em = :to", array('to' => $to), $c)['x'];
        if ($canReceive == "NO")
        {
            toJSON(array('r' => 0));
            exit;
        }
        if ($canReceive == "YES")
        {
            $tId = strtoupper(md5(uniqid()));
            $otherId = qW1R("select id from customers where cust_em = :to limit 1", array('to' => $to), $c)['id'];
            qWNR("update customers set cust_balance = cust_balance - $amount where id = $from", null, $c);
            qWNR("update customers set cust_balance = cust_balance + $amount where id = $otherId", null, $c);
            qWNR("insert into balance_transactions values (0, :tid, now(), :from, :to, :amount)", array('tid' => $tId, 'from' => $from, 'to' => $otherId, 'amount' => $amount), $c);
            toJSON(array('r' => 1));
        }
    }
    
    
}

if ($op == "get_balance")
{
    $id = p("id");
    toJSON(qW1R("select can_transfer_balance as 'x', format(cust_balance,2) as 'balance' from customers where id = $id ", null, $c));
}

if ($op == "update_info")
{
    $id = p("id");
    $name = p("name");
    $tel = p("tel");
    
    qWNR("update customers set cust_name = :name, cust_tel = :tel where id = :id", array('id' => $id, 'name' => $name, 'tel' => $tel), $c);
    toJSON(array('r' => 1));
}

if ($op == "change_password")
{
    $id = p("id");
    $opw = p("opw");
    $npw = p("npw");
    
    $cnt = qW1R("select count(*) as 'cnt' from customers where id = :id and cust_pw = :opw", array('id' => $id, 'opw' => $opw), $c)['cnt'];
    if ($cnt == 0)
    {
        toJSON(array('r' => 0));
    }
    if ($cnt == 1)
    {
        qWNR("update customers set cust_pw = :npw where id = :id", array('id' => $id, 'npw' => $npw), $c);
        toJSON(array('r' => 1));
    }
}

if ($op == "register")
{
    $un = p("un");
    $pw = p("pw");
    $fn = p("fn");
    $tel = p("tel");
    
    $cnt = qW1R("select count(*) as 'cnt' from customers where cust_em = :un", array('un' => $un), $c)['cnt'];
    if ($cnt == 1)
    {
        toJSON(array('r' => 0));
    }
    if ($cnt == 0)
    {
        qWNR("insert into customers values (0, :pn, :un, :pw, :tel, 0, 'YES', 'YES')",array('pn' => $fn, 'un' => $un, 'pw' => $pw, 'tel' => $tel), $c );
        toJSON(array('r' => 1));
    }
}

if ($op == "login")
{
    $un = p("un");
    $pw = p("pw");
    
    $r = qW1R("select count(*) as 'r', id, cust_name, cust_em, cust_tel, cust_balance, can_transfer_balance, can_receive_balance from customers where cust_em = :un and cust_pw = :pw", array('un' => $un, 'pw' => $pw), $c);
    toJSON($r);
}

if ($op == "forget_pw")
{
    $un = p("un");
    $r = qW1R("select count(*) as 'cnt', cust_em, cust_pw, cust_name from users where cust_em = :un", array('un' => $un), $c);
    if ($r['cnt'] == 1)
    {
        $baslik = "Hoob Hoob - Password Reminder";
        $body = "Dear ".$r['cust_name'].";<br>Your Password Is : ".$r['cust_pw']."<br><br>";
        sendMail($r['cust_em'], $baslik, $body);
        toJSON(array('r' => 1));
    }
    else 
    {
        toJSON(array('r' => 0));
    }
}

if ($op == "get_categories")
{
    toJSON(qWMR("select * from categories", null, $c));
}

if ($op == "add_address")
{
    $id = p("id");
    $name = p("name");
    $adr = p("adr");
    $building = p("building");
    $floor = p("floor");
    $door = p("door");
    $city = p("city");
    $lat = p("lat");
    $lng = p("lng");
    $rTmp = qW1R("select count(*) as 'cnt', id from cities where city_name = :cname", array('cname' => $city), $c);
    $cnt = $rTmp['cnt'];
    $cityId = "";
    if ($cnt != 0)
    {
        $cityId = $rTmp['id'];
    }
    $q = "insert into customer_addresses values (0, :id, :name, :adr, :building, :floor, :door, :lat, :lng, :city)";
    qWNR($q, array('id' => $id, 'name' => $name, 'city' => $cityId, 'adr' => $adr, 'building' => $building, 'floor' => $floor, 'door' => $door, 'lat' => $lat, 'lng' => $lng), $c);
    toJSON(array('r' => 1));
}

if ($op == "get_addresses")
{
    $id = p("id");
    $rs = qWMR("select a.id, a.cust_id, a.cust_adr_name, a.cust_adr_text, a.cust_adr_building, a.cust_adr_floor, a.cust_adr_door, a.cust_adr_lat, a.cust_adr_lng, a.cust_adr_city, (select city_name from cities where id = a.cust_adr_city) as 'city_name' from customer_addresses a where a.cust_id = $id", null, $c);
    $data = array();
    //$data[] = array('id' => 0, 'address_name' => 'LOCATION', 'address' => 'LOCATION', 'city' =>  'LOCATION', 'building_no' => 'LOCATION', 'floor_no' => 'LOCATION', 'door_no' => 'LOCATION', 'lat' => 0.0, 'lng' => 0.0);
    foreach($rs as $r)
    {
        $data[] = $r;
    }
    toJSON($data);
}

if ($op == "delete_address")
{
    $id = p("id");
    $uid = p("user_id");
    qWNR("delete from customer_addresses where id = $id and cust_id = $uid", null, $c);
    toJSON(array('r' => 1));
}

if ($op == "search")
{
    $search = p("search");
    $cat = p("cat");
    
    
    $rs = array();
    if ($search != "")
    {
        if ($cat != "-1")
        {
            $rs = qWMR("select * from shops where shop_name like '%$search%' and cat_id = $cat", null, $c);    
        }
        if ($cat == "-1")
        {
            $rs = qWMR("select * from shops where shop_name like '%$search%'", null, $c);    
        }
        
    }
    else 
    {
        if ($cat != "-1")
        {
            $rs = qWMR("select * from shops where cat_id = $cat", null, $c);    
        }
        if ($cat == "-1")
        {
            $rs = qWMR("select * from shops", null, $c);    
        }
    }
    
    
    toJSON($rs);
}

if ($op == "get_data")
{
    $data = array();
    $data['cities'] = qWMR("select * from cities", null, $c);
    $data['cats'] = qWMR("select * from categories", null, $c);
    
    
    toJSON($data);
}

if ($op == "get_menu")
{
    $id = p("id");
    $search = p("search");
    
    $data = array();
    
    $rsMenuSections = qWMR("select * from menu_sections where shop_id = $id", null, $c);
    foreach($rsMenuSections as $section)
    {
        $row = array('type' => 0, 'id' => '-1', 'ad' => $section['section_name'], 'info' => '', 'price' => '', 'img' => '', 'in_stock' => '', 'js' => '');
        $data[] = $row;
        $sectionId = $section['id'];
        $menuItems = qWMR("select id, item_name, item_info, format(item_price,2) as 'item_price', item_img, item_in_stocks, js from menu_items where shop_id = $id and section_id  = $sectionId and (item_name like '%$search%' or item_info like '%$search%')", null, $c);
        foreach($menuItems as $item)
        {
            $row = array('type' => 1,  'id' => $item['id'], 'ad' => $item['item_name'], 'info' => $item['item_info'], 'price' => $item['item_price'],  'img' => $item['item_img'], 'in_stock' => $item['item_in_stocks'], 'js' => $item['js']);
            $data[] = $row;
        }
        
    }
    
    toJSON($data);
}


closeDB($c);

?>
