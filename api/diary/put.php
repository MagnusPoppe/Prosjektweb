<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 12/02/2017
 * Time: 12:52
 */


// CONNECTING TO MODEL:
require_once "../logon.php";
$connection = connectLive();

// CHECKING INPUT FOR ERRORS:
if ($connection->connect_errno)
    die(displayMessage("Database error: ". $connection->errno . ": " . $connection->error));

if (!isset($_POST['id']))
    die(displayMessage("A unique id is required for updating a unique post."));

if (!isset($_POST['title']))
    die(displayMessage("A title is required for posting."));

else if (!isset($_POST['content']))
    die(displayMessage("Some content is required for posting."));

else if (!isset($_POST['owner']))
    die(displayMessage("Select the owner of the document. This is required for posting."));


// AUTHENICATING USER ID WITH DATABASE
else if (isset($_POST['owner']))
{
    $query = "SELECT id FROM prosjektweb_person WHERE id=?";
    if ( $stmt = $connection->prepare($query) )
    {
        $stmt->bind_param("i", $_POST['owner']);
        $stmt->execute();
        $stmt->bind_result($userid);
        if (! $stmt->fetch())
            die(displayMessage("Owner does not exist in database"));
        $stmt ->close();
    }
}

// PERFORMING THE PUT REQUEST:
$query = "UPDATE prosjektweb_diary SET owner=?, title=?, date=CURDATE(), content=? WHERE postID=?";

if ( $stmt = $connection->prepare($query) )
{
    if ($stmt->errno)
        die(displayMessage("Database error: ". $stmt->errno. ": " . $stmt->error));

    $stmt->bind_param("sssi", $_POST["owner"], $_POST["title"], $_POST["content"], $_POST['id']);
    $stmt->execute();
    echo displayMessage("PUT successful!");
}

// SOMETHING WENT WRONG WITH THE PUT REQUEST.
else
{
    echo displayMessage(" Something went wrong.");
}

