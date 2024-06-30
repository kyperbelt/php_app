<?php
use io\kyperbelt\util\Templates;
use io\kyperbelt\util\DirUtils;

$content = $content ?? "";
$navigation = $navigation ?? array("home" => "/", "about" => "/about");
// $htmx = DirUtils::getProjectRoot()."vendor".DIRECTORY_SEPARATOR."htmx".DIRECTORY_SEPARATOR."htmx.min.js";
$htmx = "vendor/htmx/htmx.min.js";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/style.css" rel="stylesheet">
        <script src="<?=$htmx?>"></script>
    </head>
    <body>
        <header>
            <?php Templates::render("component/nav", ["navigation" => $navigation]); ?>
        </header>
        <main id="content">
            <?= $content?> 
        </main>
        <footer>
            
        </footer>
    </body>
</html>

