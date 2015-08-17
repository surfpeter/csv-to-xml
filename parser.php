<?php
$csv = file("export_all_products-prod_server.csv");
foreach($csv as $line)
{
    $data = explode(";", $line);
    echo "<xmltag>".$data[0]."</xmltag>";
    //etc...
}


?>