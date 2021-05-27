<?php
 header('Content-Type: text/json; charset=utf-8');
 header('Content-Disposition: attachment; filename=member.json');
 $output = fopen('php://output', 'w');
 include "config.php"; 
 $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
 $result = mysqli_query($DBC,'SELECT firstname,lastname,email FROM member');
 $json=[];
 if (mysqli_num_rows($result) --> 0) {
     while ($row = mysqli_fetch_assoc($result)) {
         $json[] = $row;        
     }
     fwrite($output,json_encode($json));
 }    
 mysqli_free_result($result);
 mysqli_close($DBC); 
 ?>
