<!DOCTYPE html>
<html>
    <head>
    <title>W3.CSS Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
    include "checksession.php";
    checkUser();
    ?>
<h1>BIT608 Web Programming </h1>
<h2>Assessment case study web applicaiton temporary launch page</h2>
<?php
include "/conertedtemplate/header.php";
include "./converted%20template/menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '    <ul>
    <li><a href="listcustomers.php">Customer listing</a></li>
    <li><a href="listrooms.php">Rooms listing</a></li>
    <li><a href="listbookings.php">Bookings listing</a></li>
    <li><a href="login.php">Login</a></li>
    </ul>';


echo '<div id="content">';
include "content.php";

echo '</div></div>';
include "footer.php";
?>


</body>
</html>
