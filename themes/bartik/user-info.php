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
    
    if (!is_null($email) && !is_null($firstName) && !is_null($lastName) && !is_null($instituteName)
            && !is_null($instituteRegions) && !is_null($researchRegions)) {
        if ($userId < 0) {
            // is a new user?
            // Adding user to the database.
            $query = "INSERT INTO dms_person (first_name, last_name, registered, email)
                VALUES ('$firstName', '$lastName', now(), '$email')";
            if (mysql_query($query)) {
                // figure out what's his id.
                $query = "SELECT id FROM dms_person WHERE email ='$email'";
                $userId = mysql_query($query); // false in case id was not found.
                if (!is_numeric($userId)) {
                    echo "Error querying user id: " . $userId . " - " . $db->ErrorMsg();
                }
            } else {
                echo "Error inserting user: " . $db->ErrorMsg();
            }
        }
        // Now is an existing user.
        // lets insert the download information.

        /*
        $query = "INSERT INTO dms_download (user_id, institute, intended_use, date)
                        VALUES ('$userId', '$instituteName', '$use', now())";
        if ($db->Execute($query)) {
            // figure out what was the download id inserted before.
            $query = "SELECT max(id) as id FROM dms_download
                             WHERE user_id = " . $userId;
            $downloadId = $db->GetOne($query);
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
                        echo "Error inserting research regions: " . $db->ErrorMsg();
                    }
                } else {
                    echo "Error inserting institute regions: " . $db->ErrorMsg();
                }
            } else {
                echo "Error querying download id: " . $downloadId . " - " . $db->ErrorMsg();
            }
        } else {
            echo "Error inserting download information: " . $db->ErrorMsg();
        }
		*/
    } else {
        echo "Invalid fields";
    }
}

function getUserInfo() { 
    $email = $_POST["email"];
    if (isset($email) && $email != "") {
        $query = mysql_query("SELECT * FROM dms_person WHERE email ='".$email."' "); 
		$user = array();
		while($res = mysql_fetch_assoc($query)) {
		    $user[] = $res; 
		}
		print json_encode($user); 
    }
}

?>
