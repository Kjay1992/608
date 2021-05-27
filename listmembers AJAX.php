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
    document.getElementById("memberlist").innerHTML="";
    return;
  }
  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("memberlist").innerHTML=this.responseText;
    }
  }
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

<div id="memberlist"></div>

</body>
</html>
  