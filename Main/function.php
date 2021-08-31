<?php
$conn = mysqli_connect("localhost","root", "", "oww-chat");  

function upload($file){
    // get file info
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $fileTmp = $file["tmp_name"];

    // check file uploaded or not
    if($fileName === ""){
        return "upload an image";
    }

    //valid extension initialization
    $validFile = ["jpg","jpeg","png"];
    $explodeFile = explode(".", $fileName);
    $fileExt = strtolower(end($explodeFile));

    // check file extension
    if(!in_array($fileExt, $validFile)){
        return "not valid extension";
    }else{
        // check file size
        if($fileSize > 1000000){
            return "file's to big";
        }else {
            // rename file to unique file name
            $fileName = uniqid().'.'.$fileExt;

            // move file to directory
            move_uploaded_file($fileTmp,'../../img/' . $fileName);

            // return file name
            return $fileName;
        }
    }
}

function register($fullname,$email, $username, $password, $image){
    /* --------- Validate User Input ----------- */

    // get global scope of database
    global $conn;


    // check full name
    if(strlen($fullname) === 0){
        return "<p>Please insert full name</p>";
    }

    // check email
    if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        return "<p>Please insert valid email</p>";
    }else{
        $query = "SELECT email FROM users where email = '$email'";
        mysqli_query($conn, $query);
        if(mysqli_affected_rows($conn) > 0){
            return "<p>Email is already taken</p>";
        }
    }

    // check username
    if(strlen($username) === 0){
        return "<p>Please insert username</p>";
    }else {
        $query = "SELECT username FROM users where username = '$username'";
        mysqli_query($conn, $query);
        if(mysqli_affected_rows($conn) > 0){
            return "<p>Username is already taken</p>";
        }
    }

    // check password
    if(strlen($password) < 6){
        return "<p>Password must be at least 6 characters</p>";
    }

    // check image
    $imageUpload = upload($image);
    if($imageUpload === "upload an image"){
        return "<p>Please upload a profile image</p>";
    }else if($imageUpload === "not valid extension"){
        return "<p>Image extension must be jpg/jpeg/png</p>";
    }else if($imageUpload === "file's to big"){
        return "<p>Image size must be under 1 MB</p>";
    }
    
    
    /* --------- Insert User Form to Database----------- */
    
    // hash password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // insert data
    $query = "INSERT INTO users(fullname, email, username, password, profile_image) VALUES
                ('$fullname', '$email', '$username', '$password', '$imageUpload')";
    mysqli_query($conn, $query);
    
    // check error sql
    if(mysqli_error($conn) > 0){
        return "<p>Error cannot register into database</p> ".mysqli_error($conn);
    }else {
        return "inserted";
    }
}

function login($username, $password){
    /* --------- Validate user input----------- */
   
    // get global scope of database
    global $conn;

    // check username
    if(strlen($username) === 0){
        return "<p>Please insert username</p>";
    }else if(strlen($password) === 0){
        return "<p>Please insert password</p>";
    }else {
        $query = "SELECT username, password FROM users where username = '$username'";
        $result = mysqli_query($conn, $query);
        if(mysqli_affected_rows($conn) === 1){
            // check password
            $row = mysqli_fetch_assoc($result);
            $passwordInDb = $row["password"];
            if(password_verify($password, $passwordInDb)){
                return "found";
            }else {
                return "<p>Wrong username or password</p>";
            }
        }else{
            return "<p>Wrong username or password</p>";
        }
    }
}

function editImage($file,$oldFile, $userId){
    global $conn;

    // get file info
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $fileTmp = $file["tmp_name"];


    if($fileName === ""){
        return $oldFile;
    }

    //valid extension initialization
    $validFile = ["jpg","jpeg","png"];
    $explodeFile = explode(".", $fileName);
    $fileExt = strtolower(end($explodeFile));

    // check file extension
    if(!in_array($fileExt, $validFile)){
        return "not valid extension";
    }else{
        // check file size
        if($fileSize > 1000000){
            return "file's to big";
        }else {
            // check old file name
            $query = "SELECT profile_image from users where user_id = '$userId'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $oldImageName = $row["profile_image"];
            if($fileName === $oldImageName){
                return $oldImageName;
            }else {
                // rename file to unique file name
                $fileName = uniqid().'.'.$fileExt;
    
                // move file to directory
                move_uploaded_file($fileTmp,'../../img/' . $fileName);

                // delete old pic
                unlink("../../img/".$oldImageName);

                // return file name
                return $fileName;
            }
        }
    }
}

function editProfile($userId, $fullname, $email, $username, $image){
     /* --------- Validate User Input ----------- */

    // get global scope of database
    global $conn;

    $query = "SELECT * from users where user_id = '$userId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $oldEmail = $row["email"];
    $oldUsername = $row["username"];
    $oldImageName = $row["profile_image"];


    // check full name
    if(strlen($fullname) === 0){
        return "<p>Please insert full name</p>";
    }

    // check email
    if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        return "<p>Please insert valid email</p>";
    }else{
        $query = "SELECT email FROM users where email = '$email'";
        $result = mysqli_query($conn, $query);
        if(mysqli_affected_rows($conn) === 1){
            $row = mysqli_fetch_assoc($result);
            if($row["email"] !== $oldEmail){
                return "<p>Email is already taken</p>";
            }
        }
    }

    // check username
    if(strlen($username) === 0){
        return "<p>Please insert username</p>";
    }else {
        $query = "SELECT username FROM users where username = '$username'";
        $result = mysqli_query($conn, $query);
        if(mysqli_affected_rows($conn) === 1){
            $row = mysqli_fetch_assoc($result);
            if($row["username"] !== $oldUsername){
                return "<p>Email is already taken</p>";
            }
        }
    }

    // check image
    $imageUpload = editImage($image, $oldImageName, $userId);
    if($imageUpload === "not valid extension"){
        return "<p>Image extension must be jpg/jpeg/png</p>";
    }else if($imageUpload === "file's to big"){
        return "<p>Image size must be under 1 MB</p>";
    }
    
    
    /* --------- Update User to Database----------- */
    
    // insert data
    $query = "UPDATE users set fullname= '$fullname', email='$email', username='$username', profile_image='$imageUpload' WHERE user_id = '$userId'";
    mysqli_query($conn, $query);
    
    // check error sql
    if(mysqli_error($conn) > 0){
        return "<p>Error cannot edit data into database</p> ".mysqli_error($conn);
    }else {
        return "updated";
    }
}

function searchUser($inputValue, $userId){
    // get global scope of database
    global $conn;

    if($inputValue === ""){
        return "blank value";
    }

    // Search user in database
    $query = "SELECT * from users where username like '%$inputValue%' and user_id != '$userId'";
    $result = mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) > 0){
        $users = [];
        while($row = mysqli_fetch_assoc($result)){
            $users[] = $row;
        }
        return $users;
    }else {
        return "not found";
    }
    
}

function getUserInfo($userId){
    // get global scope of database
    global $conn;

    // get user info
    $query = "SELECT * from users where user_id = $userId";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    return $row;
}

function getUserFriendList($userId){
    // get global scope of database
    global $conn;

    // get list of friend
    $query ="SELECT * FROM person_list, users where person_list.user1_id = $userId and person_list.user2_id = users.user_id OR person_list.user2_id = $userId and person_list.user1_id = users.user_id ORDER BY last_interaction DESC";
    $result = mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) > 0){
        $friendList = [];
        while($row = mysqli_fetch_assoc($result)){
            $friendList[] = $row;
        }

        return $friendList;
    }else {
        return "no friend yet";
    }

}


function sendMessage($msgVal, $userId, $userDestinationId){
    // get global scope of database
    global $conn;

    // check empty message value
    if(preg_match("/^\s*$/", $msgVal)){
        return "<p>Cannot send empty message</p>";
    }
    
    // check person list
    $query = "SELECT * from person_list where user1_id = '$userId' and user2_id = '$userDestinationId' OR user1_id = '$userDestinationId' and user2_id = '$userId'";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) === 0){
        // add in person list
        $query = "INSERT INTO person_list(user1_id,user2_id) values ('$userId', '$userDestinationId')";
        mysqli_query($conn,$query);
        if(mysqli_error($conn) > 0){
            return "<p>Error send message</p> ".mysqli_error($conn);
        }
    }

    // insert text value into chat database
    $query = "INSERT INTO chat_text(from_id,to_id, text) VALUES ('$userId', '$userDestinationId', '$msgVal')";
    mysqli_query($conn, $query);
    if(mysqli_error($conn) > 0){
        return "<p>Error send message</p> ".mysqli_error($conn);
    }else {
        // update last interaction time
        $query = "UPDATE person_list set last_interaction= DEFAULT where user1_id = '$userId' and user2_id = '$userDestinationId' OR user1_id = '$userDestinationId' and user2_id = '$userId'";
        mysqli_query($conn, $query);
        return "message sent";
    }
    
}


function getMessageContent($userId, $userDestinationId){
    // do some stuff
    global $conn;
    
    // query all message
    $query = "SELECT * from chat_text where from_id = $userId and to_id = $userDestinationId OR from_id = $userDestinationId and to_id = $userId";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_affected_rows($conn) > 0){
        $allMsg = [];
        while($row = mysqli_fetch_assoc($result)){
            $allMsg[] = $row;
        }
        return $allMsg;
    }else {
        return "no message";
    }
}

function getLastMessage($userId, $userDestinationId){
    // do some stuff
    global $conn;

    // query message
    $query = "SELECT * from chat_text where from_id = $userId and to_id = $userDestinationId OR from_id = $userDestinationId and to_id = $userId ORDER BY time DESC";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $lastMsg = $row["text"];

    return $lastMsg;
}
?>