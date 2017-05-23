<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 12/02/2017
 * Time: 12:52
 */


// CONNECTING TO MODEL:
require_once "../../classified/logon.php";
$connection = connectLive();

// CHECKING INPUT FOR ERRORS:
if ($connection->connect_errno)
    die(displayMessage("Database error: ". $connection->errno . ": " . $connection->error));

if (!isset($_GET['id']))
    die(displayMessage("A unique id is required for updating a unique GET."));

if (!isset($_GET['title']))
    die(displayMessage("A title is required for GETing."));

else if (!isset($_GET['content']))
    die(displayMessage("Some content is required for GETing."));

else if (!isset($_GET['owner']))
    die(displayMessage("Select the owner of the document. This is required for GETing."));


// AUTHENICATING USER ID WITH DATABASE
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

// PERFORMING THE PUT REQUEST:
$query = "UPDATE prosjektweb_diary SET owner=?, title=?, date=NOW(), content=? WHERE postID=?";

if ( $stmt = $connection->prepare($query) )
{
    if ($stmt->errno)
        die(displayMessage("Database error: ". $stmt->errno. ": " . $stmt->error));

    $stmt->bind_param("sssi", $_GET["owner"], $_GET["title"], $_GET["content"], $_GET['id']);
    $stmt->execute();
    echo displayMessage("PUT successful!");
}

// SOMETHING WENT WRONG WITH THE PUT REQUEST.
else
{
    echo displayMessage(" Something went wrong.");
}

