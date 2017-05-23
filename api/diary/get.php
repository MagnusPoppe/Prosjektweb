<?php

// CONNECTING TO MODEL:
require_once "../../classified/logon.php";

 $connection = connectLive();
//$connection = connectLocal();
if ($connection->connect_errno)
    die(displayMessage("Database error: ". $connection->errno . ": " . $connection->error));


$query = <<<_END
    SELECT 	prosjektweb_diary.postID 	AS 'postID', 
	prosjektweb_diary.title  	AS 'title', 
        prosjektweb_diary.date	 	AS 'date', 
        CONCAT(prosjektweb_person.firstname, ' ',prosjektweb_person.lastname)AS 'owner', 
        prosjektweb_diary.content	AS 'content'
FROM prosjektweb_diary, prosjektweb_person
WHERE prosjektweb_diary.owner = prosjektweb_person.id
ORDER BY prosjektweb_diary.date DESC
_END;

$payload = array();

if ( $result = $connection->query( $query ) )
{
    $i = 0; // INDEX FOR

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
        $query2 = "SELECT text, link FROM prosjektweb_links WHERE postID = ?";
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


    // LOGGING VISIT:
    //logVisit($_SERVER['REMOTE_ADDR'], 1);

    // FORMATTING DATA TO JSON:
    echo  json_encode($payload);

}
else
    die(displayMessage("No posts found."));

$connection->close();

?>