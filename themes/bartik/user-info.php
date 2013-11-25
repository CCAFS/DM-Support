<?php
include('../../sites/default/settings.php'); 
$data = $databases['default']['default'];
$mysql = mysql_connect($data['host'],$data['username'],$data['password']);
$db = mysql_select_db($data['database'],$mysql); 

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
   
    $userId = isset($_POST["userId"]) ? $_POST["userId"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : null;
    $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : null;
    $instituteName = isset($_POST["instituteName"]) ? $_POST["instituteName"] : null;
    $instituteRegions = isset($_POST["instituteRegions"]) ? $_POST["instituteRegions"] : null;
    $researchRegions = isset($_POST["researchRegions"]) ? $_POST["researchRegions"] : null;
    $use = isset($_POST["use"]) ? $_POST["use"] : null;

    if (!is_null($email) && !is_null($firstName) && !is_null($lastName) && !is_null($instituteName)
            && !is_null($instituteRegions) && !is_null($researchRegions) && !is_null($use)) {
        if ($userId < 0) {
            // is a new user?
            // Adding user to the database.
            $query = "INSERT INTO dms_person (first_name, last_name, registered, email)
                VALUES ('$firstName', '$lastName', now(), '$email')";
            if (mysql_query($query)) {
                // figure out what's his id. 
                $query = mysql_query("SELECT id FROM dms_person WHERE email ='$email'"); // false in case id was not found.
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

       
        $query = "INSERT INTO dms_download (user_id, institute, intended_use, date)
                        VALUES ('$userId', '$instituteName', '$use', now())";
        if (mysql_query($query)) {
            // figure out what was the download id inserted before.
            $query = "SELECT max(id) as id FROM dms_download
                             WHERE user_id = " . $userId;
            $downloadId = mysql_query($query);
            $downloadId  = mysql_fetch_assoc($downloadId); 
    		$downloadId = $downloadId['id'];
            if (is_numeric($downloadId)) {
                // lets insert institute regions.
                $query = "INSERT INTO dms_downloadinstitutelocation (download_id";
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
                    $query = "INSERT INTO dms_downloadresearchlocation (download_id";
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
        FROM dms_person dp, dms_download dd, dms_downloadresearchlocation ddr, dms_downloadinstitutelocation ddi
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