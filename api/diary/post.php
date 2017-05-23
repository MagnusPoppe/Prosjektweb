<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 14/01/2017
 * Time: 15:46
 */

// CONNECTING TO MODEL:
require_once "../../classified/logon.php";
require_once "../../common/log.php";

$connection = connectLive();

if ($connection->connect_errno)
    die(displayMessage("Database error: ". $connection->errno . ": " . $connection->error));

if (!isset($_GET['title']))
    die(displayMessage("A title is required for GETing."));

else if (!isset($_GET['content']))
    die(displayMessage("Some content is required for GETing."));

else if (!isset($_GET['owner']))
    die(displayMessage("Select the owner of the document. This is required for GETing."));

else if (isset($_GET['owner']))
{
    $query = "SELECT id FROM prosjektweb_person WHERE id=?";
    if ( $stmt = $connection->prepare($query) )
    {
        $stmt->bind_param("i", $_GET['owner']);
        $stmt->execute();
        $stmt->bind_result($userid);
        if (! $stmt->fetch())
            die(displayMessage("Owner does not exist in database"));
        $stmt ->close();
    }
}

$query = "INSERT INTO prosjektweb_diary(owner, title, date, content) VALUES (?,?,NOW(),?)";

if ( $stmt = $connection->prepare($query) )
{
    if ($stmt->errno)
        die(displayMessage("Database error: ". $stmt->errno. ": " . $stmt->error));

    $stmt->bind_param("sss", $_GET["owner"], $_GET["title"], $_GET["content"]);
    $stmt->execute();
    echo displayMessage("POST successful!");
}
else {
    echo displayMessage(" Something went wrong.");
}


// LOGGING VISIT:
logVisit($_SERVER['REMOTE_ADDR'], 2);
