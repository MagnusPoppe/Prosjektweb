<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 23/01/2017
 * Time: 18:11
 */


// CONNECTING TO MODEL:
require_once "../logon.php";
$connection = connectLive();
//$connection = connectLocal();

if ($connection->connect_errno)
    die(displayMessage("Database error: ". $connection->errno . ": " . $connection->error));

// PREPARING NESESARY DATA:
$query = "SELECT * FROM prosjektweb_person";
$payload = array();

// GETTING RESULT
if ( $result = $connection->query( $query ) )
{
    // CREATING A ASSOC TABLE FOR THE RECIVED DATA:
    $i = 0;
    while ($row = $result->fetch_assoc())
        $payload[$i++] = array(
            "id"        => $row["id"],
            "firstname" => $row["firstname"],
            "lastname"  => $row["lastname"],
            "phone"     => $row["tlf"],
            "email"     => $row["email"],
            "bio"       => $row["bio"]
        );

    $result->close();

    // FORMATTING DATA TO JSON AND RETURNING:
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
}
else
    die(displayMessage("No users found."));

$connection->close();
?>