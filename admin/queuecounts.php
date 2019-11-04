<?php 


$current="30 Day Queue Count";
$output .= "<p>This table shows validator counts for the last 30 calendar days.</p><br>";

$query  = "Select COUNT(log_ID) as Total, log_type, penname FROM `fanfiction_log` join fanfiction_authors on log_uid = uid  WHERE `log_uid` IN (SELECT fanfiction_authorprefs.uid FROM `fanfiction_authorprefs` join fanfiction_authors on fanfiction_authorprefs.uid = fanfiction_authors.uid WHERE (level = 1 or level = 3 or level = 2)) and log_timestamp BETWEEN (NOW() - INTERVAL 30 DAY) AND NOW() and (log_type = \"VS\" OR log_type= \"RJ\" OR log_type = \"ED\") group by log_type, penname order by penname, log_type ASC";

$result = dbquery($query);
if (!$result) {
echo mysql_error();}
$output.= "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    padding: 2px;
}
</style><table>";
$output.= "<tr><th>Validator</th><th>Action</th><th>Count</th></tr>";
while ($row =dbassoc($result)){
$output.= "<tr>";
$output.= "<td>".$row['penname']."</td>";
$output.= "<td>".$row['log_type'];"</tr>";
$output.= "<td>".$row['Total'];"</tr>";
}
$output .= "</table>";
$tpl->assign("output", $output);
		$tpl->printToScreen();
		dbclose( );			
		exit( );



