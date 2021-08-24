<?php
require_once('Database_con.php');
$query="SELECT direction from base";
$query_result=mysqli_query($mysqli,$query) or die("Sorry there is no value" .mysql_error());
 while($row=mysqli_fetch_object($query_result)){
   echo $row->direction;
}
?>