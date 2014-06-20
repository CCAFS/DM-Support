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

include('../../sites/default/settings.php'); 
$data = $databases['default']['default'];
$mysql = mysql_connect($data['host'],$data['username'],$data['password']);
$db = mysql_select_db($data['database'],$mysql); 
$PREFIX = "dmsp_";

$context = isset($_POST["context"]) ? $_POST["context"] : null;

if (!is_null($context)) {
    switch ($context) {
        case "user-info":
            getUserInfo();
            break;
        case "submit-user":
            addUserInfo();
            break;
    }
}

function addUserInfo() {
    global $PREFIX;
    $userId = isset($_POST["userId"]) ? $_POST["userId"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : null;
    $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : null;
    $instituteName = isset($_POST["instituteName"]) ? $_POST["instituteName"] : null;
    $instituteRegions = isset($_POST["instituteRegions"]) ? $_POST["instituteRegions"] : null;
    $researchRegions = isset($_POST["researchRegions"]) ? $_POST["researchRegions"] : null;
    $use = isset($_POST["use"]) ? $_POST["use"] : null;
    $ftype = isset($_POST["ftype"]) ? $_POST["ftype"] : null;
    $guideSelected = isset($_POST["guideSelected"]) ? $_POST["guideSelected"] : null;

    if (!is_null($email) && !is_null($firstName) && !is_null($lastName) && !is_null($instituteName)
            && !is_null($instituteRegions) && !is_null($researchRegions) && !is_null($use)) {
        if ($userId < 0) {
            // is a new user?
            // Adding user to the database.
            $query = "INSERT INTO ".$PREFIX."person (first_name, last_name, registered, email)
                VALUES ('$firstName', '$lastName', now(), '$email')";
            if (mysql_query($query)) {
                // figure out what's his id. 
                $query = mysql_query("SELECT id FROM ".$PREFIX."person WHERE email ='$email'"); // false in case id was not found.
                $row  = mysql_fetch_assoc($query); 
    			$userId = $row['id'];
                if (!is_numeric($userId)) {
                    echo "Error querying user id: " . $userId . " - " . mysql_error();
                }
            } else {
                echo "Error inserting user: " . mysql_error();
            }
        }
        // Now is an existing user.
        // lets insert the download information.

       
        $query = "INSERT INTO ".$PREFIX."download (user_id, institute, intended_use,filter_type, date)
                        VALUES ('$userId', '$instituteName', '$use','$ftype', now())";
        if (mysql_query($query)) {
            // figure out what was the download id inserted before.
            $query = "SELECT max(id) as id FROM ".$PREFIX."download
                             WHERE user_id = " . $userId;
            $downloadId = mysql_query($query);
            $downloadId  = mysql_fetch_assoc($downloadId); 
    		$downloadId = $downloadId['id'];
            if (is_numeric($downloadId)) {
                // Guidelines downloaded
                foreach ($guideSelected as $guide) {
                    $query = "INSERT INTO ".$PREFIX."guidelines_downloaded (download_id,guideline_id)
                        VALUES ('$downloadId', '$guide')";
                    mysql_query($query);
                }

                // lets insert institute regions.
                $query = "INSERT INTO ".$PREFIX."downloadinstitutelocation (download_id";
                foreach ($instituteRegions as $region) {
                    $query .= ", " . $region;
                }
                $query .= ") VALUES (" . $downloadId;
                foreach ($instituteRegions as $region) {
                    $query .= ", 1";
                }
                $query .= ")";
                if (mysql_query($query)) {
                    // lets insert research regions.
                    $query = "INSERT INTO ".$PREFIX."downloadresearchlocation (download_id";
                    foreach ($researchRegions as $region) {
                        $query .= ", " . $region;
                    }
                    $query .= ") VALUES (" . $downloadId;
                    foreach ($researchRegions as $region) {
                        $query .= ", 1";
                    }
                    $query .= ")";
                    if (mysql_query($query)) {
                        echo $downloadId;
                    } else {
                        echo "Error inserting research regions: " . mysql_error();
                    }

                } else {
                    echo "Error inserting institute regions: " . mysql_error();
                }
            } else {
                echo "Error querying download id: " . $downloadId . " - " . mysql_error();
            }
        } else {
            echo "Error inserting download information: " . mysql_error();
        }
		/**/



    } else {
        echo "Invalid fields";
    }
}

function getUserInfo() { 
    global $PREFIX;
    $email = $_POST["email"];
    if (isset($email) && $email != "") {
        $query = mysql_query("
        SELECT
        -- Person
        dp.id, dp.first_name, dp.last_name, dp.registered, dp.email,
        -- Download
        dd.institute, dd.date,
        -- Institute Locations
        ddi.africa as i_africa,
        ddi.asia as i_asia,
        ddi.oceania as i_oceania,
        ddi.central_america_caribbean as i_central_america_caribbean,
        ddi.europe as i_europe,
        ddi.middle_east_north_africa as i_middle_east_north_africa,
        ddi.north_america as i_north_america,
        ddi.south_america as i_south_america,
        -- Research Locations
        ddr.africa as r_africa,
        ddr.asia as r_asia,
        ddr.oceania as r_oceania,
        ddr.central_america_caribbean as r_central_america_caribbean,
        ddr.europe as r_europe,
        ddr.middle_east_north_africa as r_middle_east_north_africa,
        ddr.north_america as r_north_america,
        ddr.south_america as r_south_america
        FROM ".$PREFIX."person dp, ".$PREFIX."download dd, ".$PREFIX."downloadresearchlocation ddr, ".$PREFIX."downloadinstitutelocation ddi
        WHERE dp.email = '$email'
        AND dp.id = dd.user_id
        AND dd.id = ddr.download_id
        AND dd.id = ddi.download_id
        ORDER BY dd.id DESC limit 1;
        "); 
		$user = array();
		while($res = mysql_fetch_assoc($query)) {
		    $user[] = $res; 
		}
		print json_encode($user); 
    }
}

?>
