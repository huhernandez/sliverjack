<?php
include 'inc/functions.php';

$start = microtime(true);
?>

<html>
    <head>
        <title> Silverjack </title>
        <meta charset="utf-8"/>
        <style>
            @import url("css/styles.css");
        </style>
        <link href="https://fonts.googleapis.com/css?family=Baloo+Tammudu" rel="stylesheet">
    </head>
    <body>
        <h1>Silverjack</h1>
        <div id="main">
            <?php
                play();
            ?>
            <FORM>
                <INPUT TYPE="submit" VALUE="Play Again">
            </FORM>
        </div>
    </body>
</html>

<?php

$elapsedSecs = microtime(true) - $start;
echo $elapsedSecs . " secs";
?>