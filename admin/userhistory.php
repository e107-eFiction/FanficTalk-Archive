<?php 


$current="User History";
$displayform = 1;
$output .= "<h1>User History Search</h1><br><p>Please enter the username you'd like to lookup and click search</p><br>";

$output .= "<form action=\"admin.php?action=userhistory\" method=\"post\"><input type=\"text\" name=\"searchterm\" value=\"";
if(isset($_POST['searchterm'])) $output .= $_POST['searchterm']; else $output .= "Username";
$output .="\"><input type=\"submit\" value=\"Search\"></form><br><br>";


if(isset($_POST['searchterm'])) {
$searchterm = escapestring($_POST['searchterm']); trim ($searchterm);
$query = "SELECT * FROM `fanfiction_log` WHERE `log_action` like '%".$searchterm."%'";

$result = dbquery($query);
if (!$result) {
echo mysql_error();}
$output.= "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style><table>";
$output.= "<tr><th>Date</th><th>Message</th></tr>";
while ($row =dbassoc($result)){
$output.= "<tr>";
$output.= "<td>".$row['log_timestamp']."</td>";
$output.= "<td>".$row['log_action'];"</tr>";
}}
$output .= "</table>";
$tpl->assign("output", $output);
		$tpl->printToScreen();
		dbclose( );			
		exit( );



