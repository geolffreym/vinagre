<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 03-30-14
 * Time: 09:16 AM
 */
use core\lib\Template;

?>
<!DOCTYPE html>
<html>
<head>
    <title>
        <?php Template::writeRegion ( 'title' ); ?>
    </title>
    <?php Template::writeRegion ( 'styles' ); ?>
</head>
<body>
<header id="header">
    Hi
    <?php Template::writeRegion ( 'header' ); ?>
</header>
<?php Template::writeRegion ( 'scripts' ); ?>
</body>
</html>