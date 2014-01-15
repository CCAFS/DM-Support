<?php
include('../../sites/default/settings.php'); 
$data = $databases['default']['default'];
$mysql = mysql_connect($data['host'],$data['username'],$data['password']);
$db = mysql_select_db($data['database'],$mysql); 
$PREFIX = "dmsp_";


$context = isset($_POST["context"]) ? $_POST["context"] : null;


if($context == "guidelines-lvl"){
	$r = htmlentities($_POST["r"]);
	$s= htmlentities($_POST["s"]);
	$c= htmlentities($_POST["c"]);
	$sth = mysql_query("SELECT g.id,g.name,g.type,g.source, il.importance_level
					FROM ".$PREFIX."importance_levels il
					INNER JOIN ".$PREFIX."categories c ON il.category_id = c.id
					INNER JOIN ".$PREFIX."stages s ON il.stage_id = s.id
					INNER JOIN ".$PREFIX."roles r ON il.role_id = r.id
					INNER JOIN ".$PREFIX."guidelines g ON il.guideline_id = g.id
					WHERE il.role_id = ".$r." and il.stage_id= ".$s." and il.category_id=".$c); 
	$rows = array();
	while($res = mysql_fetch_assoc($sth)) {
	    $rows[] = $res;
	    
	}
	print json_encode($rows); 

}

if($context == "guidelines-search"){
	$q = htmlentities($_POST["q"]); 
	$q = trim($q);
	$sth = mysql_query("SELECT g.id,g.name,g.type,g.source
						FROM ".$PREFIX."guidelines g 
						WHERE ((g.name LIKE '%$q%') OR (g.source LIKE '%$q%'))
						"); 
	$rows = array();
	while($res = mysql_fetch_assoc($sth)) {
	    $rows[] = $res;
	    
	}
	print json_encode($rows); 

}


?>