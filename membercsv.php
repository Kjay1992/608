<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=member.csv'); //RFC2183
 
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
 
// output the column headings
fputcsv($output, array('Firstname', 'Lastname', 'Email'));
 
// fetch the data
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
$result = mysqli_query($DBC,'SELECT firstname,lastname,email FROM member');
 
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
}    
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done     
?>