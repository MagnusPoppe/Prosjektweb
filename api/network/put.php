<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 05/03/2017
 * Time: 13:42
 */

$ip         = (isset($_GET['ip'])) ? $_GET["ip"] : die(displayMessage("An ip address is required."));

$hostname   = !isset($_GET['hostname']) ? null : $_GET["hostname"];
$City       = !isset($_GET['city'])     ? null : $_GET["city"];
$country    = !isset($_GET['country'])  ? null : $_GET["country"];
$org        = !isset($_GET['org'])      ? null : $_GET["org"];
$postal     = !isset($_GET['postal'])   ? null : $_GET["postal"];


// CONNECTING TO MODEL:
require_once "../logon.php";

$connection = connectLive();
$connection2 = connectLive();
//$connection = connectLocal();
if ($connection->connect_errno)
    die(displayMessage("MySQL error  \"". $connection->errno . ": " . $connection->error . " \""));

$query = "SELECT id from prosjektweb_visitor_log WHERE request_ip=?";

if ( $stmt = $connection->prepare($query) )
{
    $stmt->bind_param("s", $ip);
    $stmt->execute();
    $stmt->bind_result($id);

    while($stmt->fetch())
    {
        $insertQuery = <<<_EOL
            UPDATE prosjektweb_visitor_log 
            SET 
                request_host_name=?,
                City=?,
                Country=?,
                Organisation=?,
                Postcode=?
            WHERE id=?
_EOL;

        if( $insert = $connection2->prepare($insertQuery))
        {
            $insert->bind_param("sssssi", $hostname, $City, $country, $org, $postal, $id);
            $insert->execute();
        }
        else
        {
            die(displayMessage("MySQL error \"". $connection->errno . ": " . $connection->error . "\" for address $ip"));
        }
    }
}
else die(displayMessage("Visitor not found."));

$connection->close();

echo displayMessage("VISIT UPDATE FOR ".$_GET['ip']." WAS A SUCCESS!");
