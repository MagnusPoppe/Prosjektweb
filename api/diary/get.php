<?php

    $NUMBER_OF_POSTS = 100;

    $connection = new mysqli("localhost", "root", "", "byteme_no");

    $query = "SELECT * FROM posts ORDER BY date DESC";
    if ( $stmt = mysqli-prepare($connection, $query) )
    {
        $stmt->bind_param("i", $NUMBER_OF_POSTS);
        $stmt->execute();
        $stmt->bind_result($title, $owner, $date, $content);

        while ($stmt->fetch())
            $payload = array(
                "title"   => $title,
                "owner"   => $owner,
                "date"    => $date,
                "content" => $content,
                "links"   => ""
            );

        $stmt->close();
    }

    $payload["links"] = array(
        "link" => "",
        "text" => ""
    );
    $connection->close();


    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
?>