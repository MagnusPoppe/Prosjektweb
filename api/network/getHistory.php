<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 13/03/2017
 * Time: 19:07
 */

if (!isset($_GET['ip']))
{
    die(displayMessage("No IP => no data."));
}

$query = <<<_EOF
SELECT 
	date
FROM `prosjektweb_visitor_log` 
WHERE request_ip=?
_EOF;

require_once "../logon.php";

$connection = connectLive();

$payload = Array();

if ( $stmt = $connection->prepare( $query ) )
{
    $stmt->bind_param("s", $_GET["ip"]);
    $stmt->execute();
    $stmt->bind_result($date);

    $i = 0; // INDEX FOR

    while ($stmt->fetch())
    {
        $payload[$i++] = Array("date" => $date);
    }

    echo json_encode($payload, JSON_UNESCAPED_UNICODE);

}
else die(displayMessage("MySQL error \"". $connection->errno . ": " . $connection->error ."\""));