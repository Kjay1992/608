<?php
//Our member search/filtering engine
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE) or die();


$searchresult = ''; 
//do some simple validation to check if sq contains a string
$sq = $_GET['sq'];
if (isset($sq) and !empty($sq) and strlen($sq) < 31) {
    $sq = strtolower($sq);
//prepare a query and send it to the server using our search string as a wildcard on surname
    $query = "SELECT memberID,firstname,lastname FROM member WHERE lastname LIKE '$sq%' ORDER BY lastname";
    $result = mysqli_query($DBC,$query);
    $rowcount = mysqli_num_rows($result); 
        //makes sure we have members
    if ($rowcount > 0) {  
        $searchresult = '<table border="1"><thead><tr><th>Lastname</th><th>Firstname</th><th>actions</th></tr></thead>';
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['memberID'];	
            $searchresult .= '<tr><td>'.$row['lastname'].'</td><td>'.$row['firstname'].'</td>';
            $searchresult .= '<td><a href="viewmember.php?id='.$id.'">[view]</a>';
            $searchresult .=     '<a href="editmember.php?id='.$id.'">[edit]</a>';
            $searchresult .=     '<a href="deletemember.php?id='.$id.'">[delete]</a></td>';
            $searchresult .= '</tr>'.PHP_EOL;
        }
        $searchresult .= '</table>';
    } else echo "<tr><td colspan=3><h2>No members found!</h2></td></tr>";
} else echo "<tr><td colspan=3> <h2>Invalid search query</h2>";
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

echo  $searchresult;