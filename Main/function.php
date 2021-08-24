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

    // Add style for status validation
    $style = 'padding:5px 0;';

    // check full name
    if(strlen($fullname) === 0){
        return "<p style=$style>Please insert full name</p>";
    }

    // check email
    if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        return "<p style=$style>Please insert valid email</p>";
    }else{
        $query = "SELECT email FROM users where email = '$email'";
        mysqli_query($conn, $query);
        if(mysqli_affected_rows($conn) > 0){
            return "<p style=$style>Email is already taken</p>";
        }
    }

    // check username
    if(strlen($username) === 0){
        return "<p style=$style>Please insert username</p>";
    }else {
        $query = "SELECT username FROM users where username = '$username'";
        mysqli_query($conn, $query);
        if(mysqli_affected_rows($conn) > 0){
            return "<p style=$style>Username is already taken</p>";
        }
    }

    // check password
    if(strlen($password) < 6){
        return "<p style=$style>Password must be at least 6 characters</p>";
    }

    // check image
    if(upload($image) === "upload an image"){
        return "<p style=$style>Please upload a profile image</p>";
    }else if(upload($image) === "not valid extension"){
        return "<p style=$style>Image extension must be jpg/jpeg/png</p>";
    }else if(upload($image) === "file's to big"){
        return "<p style=$style>Image size must be under 1 MB</p>";
    }else {
        $imageName = upload($image);
    }

    
    /* --------- Insert User Form to Database----------- */

    // hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // insert data
    $query = "INSERT INTO users(fullname, email, username, password, profile_image) VALUES
                ('$fullname', '$email', '$username', '$password', '$imageName')";
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

    // Add style for status validation
    $style = 'padding:5px 0;';

    // check username
    if(strlen($username) === 0){
        return "<p style=$style>Please insert username</p>";
    }else if(strlen($password) === 0){
        return "<p style=$style>Please insert password</p>";
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
                return "<p style=$style>Wrong username or password</p>";
            }
        }else{
            return "<p style=$style>Wrong username or password</p>";
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

?>