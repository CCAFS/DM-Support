<?php
include('../../sites/default/settings.php'); 
$data = $databases['default']['default'];
$mysql = mysql_connect($data['host'],$data['username'],$data['password']);
$db = mysql_select_db($data['database'],$mysql); 

$r = htmlentities($_GET["r"]);
$s= htmlentities($_GET["s"]);
$c= htmlentities($_GET["c"]);

$sth = mysql_query("SELECT g.name,g.type,g.source, il.importance_level
					FROM dms_importance_levels il
					INNER JOIN dms_categories c ON il.category_id = c.id
					INNER JOIN dms_stages s ON il.stage_id = s.id
					INNER JOIN dms_roles r ON il.role_id = r.id
					INNER JOIN dms_guidelines g ON il.guideline_id = g.id
					WHERE il.role_id = ".$r." and il.stage_id= ".$s." and il.category_id=".$c); 
$rows = array();
while($res = mysql_fetch_assoc($sth)) {
    $rows[] = $res;
    
}
print json_encode($rows); 
?>