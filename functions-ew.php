<?php






function fetchAllBrand()
{

    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare("SELECT
		BrandName
		FROM " . $db_table_prefix . "brand_tbl"
		);

    $stmt->execute();
    $stmt->bind_result($BrandName);
    while ($stmt->fetch()) {
        $row[] = array(
            'BrandName' => $BrandName
            );
    }
    $stmt->close();
    return ($row);
}

function fetchAllSize() {
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT Size from Size_tbl");
    $stmt->execute();
    $stmt->bind_result(
        $Size

    );

    while ($stmt->fetch()) {
        $row[] = array(
            'Size'  => $Size
        );
    }
    $stmt->close();
    return ($row);
}

function fetchReport($BrandName, $Genre, $Gender, $Size)
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        "Select i.ItemID, i.MSRP, i.quantity
            FROM item_tbl AS i
            JOIN size_tbl AS s
            ON i.SizeID = s.SizeID
            JOIN brand_tbl AS b
            ON i.BrandID = b.BrandID
            JOIN item_genre_tbl AS ig
            ON i.ItemID = ig.ItemID
            JOIN species_tbl AS sp
            ON i.SpeciesID = sp.SpeciesID
            JOIN color_tbl AS col
            ON i.ColorID = col.ColorID
            JOIN Pattern_tbl AS pat
            ON i.PatternID = pat.PatternID
            JOIN genus_tbl AS ge
            ON i.GenusID = ge.GenusID
            JOIN Material_tbl AS m
            ON i.MaterialID = m.MaterialID
            JOIN Country_Origin_tbl AS c
            ON i.CountOrigID = c.CountOrigID
            JOIN genre_tbl AS gr
            ON ig.GenreID = gr.GenreID
            JOIN gender_tbl AS g
            ON i.GenderID = g.GenderID
            WHERE b.BrandName = ?
            AND gr.Genre = ?
            AND g.Gender = ?
            AND s.Size = ?"
    );
    $stmt->bind_param("ssss",$BrandName, $Genre, $Gender, $Size);
    $stmt->execute();
    $stmt->bind_result( $ItemID, $MSRP, $quantity);
    $stmt->execute();
    while ($stmt->fetch()) {
        $row[] = array(

            'ItemID'        => $ItemID,
            'MSRP'          => $MSRP,
            'quantity'      => $quantity

        );
    }
    $stmt->close();
    return ($row);
}


//Check if a user is logged in
/**
 * @return bool
 */
function isUserLoggedIn()
{
    global $loggedInUser, $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare("SELECT
		UserID,
		Password
		FROM " . $db_table_prefix . "userdetails
		WHERE
		UserID = ?
		AND
		Password = ?
		LIMIT 1");
    $stmt->bind_param("ss", $loggedInUser->user_id, $loggedInUser->hash_pw);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($loggedInUser == NULL) {
        return false;
    } else {
        if ($num_returns > 0) {
            return true;
        } else {
            destroySession("ThisUser");
            return false;
        }
    }
}

//Check if the logged in user is Admin
/**
 * @return bool
 */
function isAdmin()
{
    global $loggedInUser, $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare("SELECT
		Role
		FROM " . $db_table_prefix . "userdetails
		WHERE
		UserID = ?
		AND
		Role = 'Admin'
		LIMIT 1");
    $stmt->bind_param("s", $loggedInUser->user_id);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
        return true;
    }
}

function isDeveloper()
{
    global $loggedInUser, $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare("SELECT
		Role
		FROM " . $db_table_prefix . "userdetails
		WHERE
		UserID = ?
		AND
		Role = 'Developer'
		LIMIT 1");
    $stmt->bind_param("s", $loggedInUser->user_id);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
        return true;
    }
}


//Destroys a session as part of logout
/**
 * @param $name
 */
function destroySession($name)
{
    if (isset($_SESSION[$name])) {
        $_SESSION[$name] = NULL;
        unset($_SESSION[$name]);
    }
}


function fetchAllUsers() {
    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare(
        "SELECT
      UserID,
UserName,
Password,
Role

FROM " . $db_table_prefix . "userdetails"
    );
    $stmt->execute();
    $stmt->bind_result(
        $UserID,
        $UserName,
        $Password,
        $Role

    );

    while ($stmt->fetch()) {
        $row[] = array(
            'UserID'                      => $UserID,
            'UserName'                  =>  $UserName,
            'Password'               => $Password,
            'Role'                    =>  $Role

        );
    }
    $stmt->close();
    return ($row);
}

function fetchThisUser($UserID)
{
    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare(
        "
    SELECT
    UserID,
    UserName,
    Password,
    Role

    FROM " . $db_table_prefix . "userdetails
    WHERE
    UserID = ?
    LIMIT 1"
    );
    $stmt->bind_param("s", $UserID);
    $stmt->execute();
    $stmt->bind_result( $UserID, $UserName, $Password, $Role);
    $stmt->execute();
    while ($stmt->fetch()) {
        $row[] = array(

            'UserID'                  => $UserID,
            'UserName'               => $UserName,
            'Password'               => $Password,
            'Role'                  => $Role

        );
    }
    $stmt->close();
    return ($row);
}


//Update selected users record.

function updateThisRecord($username,$password,$role,$thisuserid)
{
    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare(
        "UPDATE " . $db_table_prefix . "userdetails
		SET
		UserName = ?,
		Password = ?,
		Role = ?
		WHERE
		UserID = ?
		LIMIT 1"
    );
    $stmt->bind_param("ssss",$username,$password,$role,$thisuserid);
    $result = $stmt->execute();
    $stmt->close();
    echo "<p align = 'left'><font color='red' size = '12pt'> The user has been updated successfully!<br />";

    //return $result;
}

Function DeleteThisRecord($thisuserid)
{


    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare(
        "delete from " . $db_table_prefix . "userdetails
      WHERE
      UserID = ? ;"
    );
    $stmt->bind_param("s",$thisuserid);
    $result = $stmt->execute();
    $stmt->close();

    echo "<p align = 'left'><font color='red' size = '10pt'> The user has been deleted successfully!<br />";

}

function getUniqueCode($length = "")
{
    $code = md5(uniqid(rand(), TRUE));
    if ($length != "") {
        return substr($code, 0, $length);
    } else {
        return $code;
    }
}



function generateHash($plainText, $salt = NULL)
{

    if ($salt === NULL) {
        $salt = substr(md5(uniqid(rand(), TRUE)), 0, 25);

    } else {

        $salt = substr($salt, 0, 25);

    }

    return $salt . sha1($salt . $plainText);
}


function createNewUser($username, $password,$role)
{
    global $mysqli, $db_table_prefix;
    //Generate A random userid

    $character_array = array_merge(range('a', 'z'), range(0, 9));
    $rand_string = "";
    for ($i = 0; $i < 6; $i++) {
        $rand_string .= $character_array[rand(
            0, (count($character_array) - 1)
        )];
    }


    $newpassword = generateHash($password);


    $stmt = $mysqli->prepare(
        "INSERT INTO userdetails(
		UserID,
		UserName,
  		Password,
		Role
		)
		VALUES (
		'" . $rand_string . "',
		?,
		?,
		?
		)"
    );
    $stmt->bind_param("sss", $username, $newpassword,$role);
    //print_r($stmt);
    $result = $stmt->execute();
    //print_r($result);
    $stmt->close();
    echo "<p align = 'left'><font color='red' size = '10pt'> The user has been created successfully!<br />";;

}




function createNewBug($UserName,$Bug_description,$Attach_File,$Priority,$Status)
{
    global $mysqli;
    $character_array = array_merge(range('a', 'z'), range(0, 9));
    $rand_string = "";
    for ($i = 0; $i < 6; $i++) {
        $rand_string .= $character_array[rand(
            0, (count($character_array) - 1)
        )];
    }

    $stmt = $mysqli->prepare(
        "INSERT INTO bug(
		Bug_ID,
		UserName,
		Bug_description,
		Attach_file,
		Priority,
		status
		
		)
		VALUES (
		'" . $rand_string . "',
		?,
		?,
		?,
		?,
		?
		
      	)"
    );
    $stmt->bind_param("sssss", $UserName,$Bug_description,$Attach_File,$Priority,$Status);
    $result = $stmt->execute();
    $stmt->close();
    return $result;

}



/*
function fetchThisBug($Bug_ID)
{
global $mysqli, $db_table_prefix;
$stmt = $mysqli->prepare(
"
SELECT
Bug_ID,
UserName,
Bug_description,
Priority,
Status
FROM bug
WHERE
Bug_ID = ?
LIMIT 1"
);
$stmt->bind_param("s",$Bug_ID);
$stmt->execute();
$stmt->bind_result( $Bug_ID, $UserName,$Bug_description, $Priority,$Status);
$stmt->execute();
while ($stmt->fetch()) {
$row[] = array(

'Bug_ID'  => $Bug_ID,
'UserName'         => $UserName,
'Bug_description'               => $Bug_description,
'Priority'      => $Priority,
'Status'        => $Status

);
}
$stmt->close();
return ($row);
}
*/
function fetchAllbugs() {
    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare(
        "SELECT
Bug_ID,
UserName,
Bug_description,
Priority,
Status


FROM bug WHERE Status='open'"
    );
    $stmt->execute();
    $stmt->bind_result(
        $Bud_ID,
        $UserName,
        $Bug_description,
        $Priority,
        $Status


    );

    while ($stmt->fetch()) {
        $row[] = array(
            'Bug_ID'    => $Bud_ID,
            'UserName'   => $UserName,
            'Bug_description'   => $Bug_description,
            'Priority'      => $Priority,
            'Status'                => $Status
        );
    }
    $stmt->close();
    return ($row);
}

function updateThisBug( $UserName,$Bug_description, $Priority,$Status,$Bug_ID)
{
global $mysqli, $db_table_prefix;
$stmt = $mysqli->prepare(
"UPDATE " . $db_table_prefix . "bug
SET
UserName = ?,
Bug_description = ?,
Priority = ?
WHERE
UserID = ?
LIMIT 1"
);
$stmt->bind_param("ssss",$username,$password,$role,$thisuserid);
$result = $stmt->execute();
$stmt->close();
echo"The user has been updated successfully";
//return $result;
}
function updateStatus($Bud_ID){
    global $mysqli;
    $stmt=$mysqli->prepare("UPDATE bug 
     set Status ='close'
     WHERE Bug_ID=?");
    $stmt->bind_param('s',$Bud_ID);
    $result=$stmt->execute();
    $stmt->close();
    return $result;

}

function fetchClosedBug() {

    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare(
        "SELECT
            Bug_ID,
            Bug_description,
            Priority,
            Status
            FROM " . $db_table_prefix . "bug
            WHERE Status != 'open'"
    );


    $stmt->execute();
    $stmt->bind_result(
        $id,
        $desc,
        $Priority,
        $Status
    );

    while ($stmt->fetch()) {
        $row[] = array(
            'id'                      => $id,
            'desc'                    => $desc,
            'priority'             => $Priority,
            'status'                  => $Status
        );
    }
    $stmt->close();
    return ($row);
}


function fetchBug() {

    global  $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare(
        "SELECT
            Bug_ID,
            Bug_description,
            Priority,
            Status,
            UserName
            FROM " . $db_table_prefix . "bug
            ORDER BY UserName"
    );


    $stmt->execute();
    $stmt->bind_result(
        $id,
        $desc,
        $Priority,
        $Status,
        $UserName

    );

    while ($stmt->fetch()) {
        $row[] = array(
            'id'                      => $id,
            'desc'                    => $desc,
            'priority'             => $Priority,
            'status'                  => $Status,
            'username'                      => $UserName

        );
    }
    $stmt->close();
    return ($row);
}

?>