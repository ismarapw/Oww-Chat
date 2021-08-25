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
        return mysqli_error($conn);
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

function searchUser($inputValue){
    // get global scope of database
    global $conn;

    if($inputValue === ""){
        return "blank value";
    }

    // Search user in database
    $query = "SELECT * from users where username like '%$inputValue%'";
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


function sendMessage($msgVal, $userId, $userDestinationId){
    // get global scope of database
    global $conn;

    // check empty message value
    if(preg_match("/^\s*$/", $msgVal)){
        return "<p>Cannot send empty message</p>";
    }
    
    // check is friend or not yet
    $query = "SELECT * from friend_list where user_id = '$userId' and friend_id = '$userDestinationId'";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) === 0){
        // add friend
        $query = "INSERT INTO friend_list(user_id,friend_id) values ('$userId', '$userDestinationId')";
        mysqli_query($conn,$query);
        if(mysqli_error($conn) > 0){
            return "<p>Error send message</p>".mysqli_error($conn);
        }
    }

    // insert text value into chat database
    for($i = 1 ; $i <= 2 ; $i++){
        if($i === 1){
            $user1 = $userId;
            $user2 = $userDestinationId;
            $status = "sender";
        }else{
            $user1 = $userDestinationId;
            $user2 = $userId;
            $status = "receiver";
        }
        

        $query = "INSERT INTO text_chat(user_id, friend_id, text,text_status) VALUES ('$user1', '$user2', '$msgVal','$status')";
        mysqli_query($conn, $query);
        if(mysqli_error($conn) > 0){
            return "<p>Error send message</p>".mysqli_error($conn);
        }
    }
    
    return "message sent";
}

?>