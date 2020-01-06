<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php
        include 'func.php';
        $c = getDB();
        $txt = qW1R("select txt from help_page where id = 1", null, $c)['txt'];
        echo $txt;
        ?>
        
    </body>
</html>