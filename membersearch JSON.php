<?php
//Our member search/filtering engine
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE) or die();

//do some simple validation to check if sq contains a string
$sq = $_GET['sq'];
$searchresult = '';
if (isset($sq) and !empty($sq) and strlen($sq) < 31) {
    $sq = strtolower($sq);
//prepare a query and send it to the server using our search string as a wildcard on surname
    $query = "SELECT memberID,firstname,lastname FROM member WHERE lastname LIKE '$sq%' ORDER BY lastname";
    $result = mysqli_query($DBC,$query);
    $rowcount = mysqli_num_rows($result); 
        //makes sure we have members
    if ($rowcount > 0) {  
        $rows=[];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        $searchresult = json_encode($rows);
        header('Content-Type: text/json; charset=utf-8');
    } else echo "<tr><td colspan=3><h2>No members found!</h2></td></tr>";
} else echo "<tr><td colspan=3> <h2>Invalid search query</h2>";
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

echo  $searchresult;