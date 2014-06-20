<?php 
/**
*  This file is part of Data Management Support Pack (DMSP).
*
*  DMSP is free software: you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation, either version 3 of the License, or
*  at your option) any later version.
*
*  DMSP is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with DMSP.  If not, see <http://www.gnu.org/licenses/>.
*
* Copyright 2014 (C) Climate Change, Agriculture and Food Security (CCAFS)
* 
* Created on : 20-12-2013
* @author      Sebastian Amariles Garcia (CIAT/CCAFS)
* @version     1.0
*/

/** bootstrap Drupal **/ 
chdir("../../");
define('DRUPAL_ROOT', "./");
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$PREFIX = "dmsp_"; 
$context = isset($_POST["context"]) ? $_POST["context"] : null;
 
if($context == "guidelines-lvl"){
	$r = htmlentities($_POST["r"]);
	$s= htmlentities($_POST["s"]);
	$c= htmlentities($_POST["c"]);
	$sth = db_query("SELECT g.id,g.name,g.type,g.source, il.importance_level
					FROM ".$PREFIX."importance_levels il
					INNER JOIN ".$PREFIX."categories c ON il.category_id = c.id
					INNER JOIN ".$PREFIX."stages s ON il.stage_id = s.id
					INNER JOIN ".$PREFIX."roles r ON il.role_id = r.id
					INNER JOIN ".$PREFIX."guidelines g ON il.guideline_id = g.id
					WHERE il.role_id = ".$r." and il.stage_id= ".$s." and il.category_id=".$c); 
	$rows = array(); 
	foreach ($sth as $record) {
	  $rows[] = $record;
	} 
	print json_encode($rows); 

}

if($context == "guidelines-search"){
	$q = htmlentities($_POST["q"]); 
	$q = trim($q);
	$sth = db_query("SELECT g.id,g.name,g.type,g.source
						FROM ".$PREFIX."guidelines g 
						WHERE ((g.name LIKE '%$q%') OR (g.source LIKE '%$q%'))
						"); 
	$rows = array(); 
	foreach ($sth as $record) {
	  $rows[] = $record;
	} 
	print json_encode($rows); 

}


?>
