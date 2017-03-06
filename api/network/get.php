<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 27/02/2017
 * Time: 16:11
 */



// CONNECTING TO MODEL:
require_once "../logon.php";

$connection = connectLive();
//$connection = connectLocal();
if ($connection->connect_errno)
    die(displayMessage("Database error: ". $connection->errno . ": " . $connection->error));


$query = "SELECT * FROM  prosjektweb_visitor_log";

$payload = array();

if ( $result = $connection->query( $query ) )
{
    $i = 0; // INDEX FOR

    while ($row = $result->fetch_assoc())
    {
        $payload[$i] = array(
           "id"         => $row['id'],
            "date"      => $row["date"],
            "ip"        => $row["request_ip"],
            "hostname"  => $row["request_hostname"],
            "city"      => $row["City"],
            "Country"   => $row["Country"],
            "Org"       => $row["Organisation"],
            "Postcode"  => $row["Postcode"]
        );

        $i++;
    }
    $result->close();


    // LOGGING VISIT:
    $log_query = "INSERT INTO prosjektweb_visitor_log(date, request_ip, request_host_name) VALUES (NOW(), ?, ?)";

    if ( $stmt = $connection->prepare($log_query) )
    {
        $stmt->bind_param("ss", $_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_HOST']);
        $stmt->execute();
    }

    // FORMATTING DATA TO JSON:
    echo  json_encode($payload);

}
else
    die(displayMessage("No posts found."));

$connection->close();
