<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 06/03/2017
 * Time: 14:32
 */

$query = <<<_EOF
    SELECT 
        request_ip, 
        request_host_name, 
        City, 
        Country, 
        Postcode, 
        COUNT(request_ip) as visits 
    FROM `prosjektweb_visitor_log` 
    
    group by request_ip having visits >= 1
_EOF;

require_once "../logon.php";

$connection = connectLive();

$payload = Array();

if ( $result = $connection->query( $query ) )
{
    $i = 0; // INDEX FOR

    while ($row = $result->fetch_assoc())
    {
        $payload[$i++] = Array(
            "ip"        => $row["request_ip"],
            "hostname"  => $row["hostname"],
            "city"      => $row["City"],
            "country"   => $row["Country"],
            "postal"    => $row["postal"],
            "visits"    => $row["visits"]
        );
    }

    echo json_encode($payload, JSON_UNESCAPED_UNICODE);

}
else die(displayMessage("MySQL error \"". $connection->errno . ": " . $connection->error ."\""));