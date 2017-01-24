<?php

// CONNECTING TO MODEL:
require_once "../logon.php";
 $connection = connectLive();
//$connection = connectLocal();
if ($connection->connect_errno)
    die(displayMessage("Database error: ". $connection->errno . ": " . $connection->error));


$NUMBER_OF_POSTS = 100;
$query = "SELECT * FROM prosjektweb_diary ORDER BY prosjektweb_diary.date DESC";
$payload = array();

if ( $result = $connection->query( $query ) )
{
    $i = 0;
    $query2 = "SELECT text, link FROM prosjektweb_links WHERE postID = ?";

    while ($row = $result->fetch_assoc())
    {
        $payload[$i] = array(
            "id"      => $row["postID"],
            "title"   => $row["title"],
            "owner"   => $row["owner"],
            "date"    => $row["date"],
            "content" => $row["content"],
            "links"   => ""
        );
        // GETTING LINKS:
        $j = 0;
        if ( $stmt = $connection->prepare($query2) )
        {
            $stmt->bind_param("i", $row['postID']);
            $stmt->execute();
            $stmt->bind_result($link, $text);

            while ($stmt->fetch())
                $payload["links"][$j++] = array(
                    "link" => $link,
                    "text" => $text
                );
            $stmt->close();
        }
        $i++;
    }
    $result->close();


    // FORMATTING DATA TO JSON:
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
}
else
    die(displayMessage("No posts found."));

$connection->close();
?>