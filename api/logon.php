<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 14/01/2017
 * Time: 14:40
 */

function connectLocal()
{
    return new mysqli("localhost", "root", "", "byteme_no");
}

function connectLive()
{
    return new mysqli("byteme.no.mysql", "byteme_no", "ganKumyQ", "byteme_no");;
}

function displayMessage( $message )
{
    $output =  <<<_END
<!DOCTYPE html><html lang="en"><head>
    <meta charset="UTF-8">
    <title>6117 - Bachelorprosjekt</title>
    <link rel="stylesheet" href="/public/stylesheets/general.css">
    <link rel="stylesheet" href="/public/stylesheets/design.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head><body><main id="message"><h2>
_END;

    // ADDING MESSAGE WHERE APPROPRIATE
    $output .= $message;
    $output .= "</h2></main></body>";

    return $output;
}
