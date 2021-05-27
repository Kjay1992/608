<?php
include "checksession.php";
checkUser();
loginStatus(); 
?>
<!DOCTYPE HTML>
<html><head><title>Browse members with AJAX autocomplete</title>
<script>

function searchResult(searchstr) {
  if (searchstr.length==0) {

    return;
  }
  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
    //take JSON text from the server and convert it to JavaScript objects
    //mbrs will become a two dimensional array of our members much like 
    //a PHP associative array
      var mbrs = JSON.parse(this.responseText);              
      var tbl = document.getElementById("tblMembers"); //find the table in the HTML
      
      //clear any existing rows from any previous searches
      //if this is not cleared rows will just keep being added
      var rowCount = tbl.rows.length;
      for (var i = 1; i < rowCount; i++) {
         //delete from the top - row 0 is the table header we keep
         tbl.deleteRow(1); 
      }      
      
      //populate the table
      //mbrs.length is the size of our array
      for (var i = 0; i < mbrs.length; i++) {
         var mbrid = mbrs[i]['memberID'];
         var fn    = mbrs[i]['firstname'];
         var ln    = mbrs[i]['lastname'];
      
         //concatenate our actions urls into a single string
         var urls  = '<a href="viewmember.php?id='+mbrid+'">[view]</a>';
             urls += '<a href="editmember.php?id='+mbrid+'">[edit]</a>';
             urls += '<a href="deletemember.php?id='+mbrid+'">[delete]</a>';
         
         //create a table row with three cells  
         tr = tbl.insertRow(-1);
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = fn; //firstname
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = ln; //lastname      
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = urls; //action URLS            
        }
    }
  }
  //call our php file that will look for a member or members matchign the seachstring
  xmlhttp.open("GET","membersearch.php?sq="+searchstr,true);
  xmlhttp.send();
}
</script>
</head>
<body>

<h1>Member list search by lastname</h1>
<h2><a href='registermember.php'>[Create new member]</a></h2>
<form>
  <label for="lastname">Lastname: </label>
  <input id="lastname" type="text" size="30" 
         onkeyup="searchResult(this.value)" 
         onclick="javascript: this.value = ''" 
         placeholder="Start typing a last name">

</form>
<table id="tblMembers" border="1">
<thead><tr><th>Lastname</th><th>Firstname</th><th>actions</th></tr></thead>



</table>
</body>
</html>
  