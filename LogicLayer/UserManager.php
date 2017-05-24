<?php
include "User.php";
include "Assay.php";

class UserManager {
    
    public static function loginUser($tc, $password) {
        global $connection;
        
        
        $stmt = mysqli_prepare($connection, "SELECT tc, firstName, surName, password, address, userRole FROM users WHERE tc = ?");
        mysqli_stmt_bind_param($stmt, "i", $tc);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $tc, $firstName, $surName, $db_password, $address, $userRole);
        mysqli_stmt_fetch($stmt);
        
        $user = new User($tc, $firstName, $surName, NULL, NULL, $db_password, NULL, $address, NULL, NULL, $userRole);
            
        //if(password_verify($password, $user->getPassword())) {
        if($password == $user->getPassword()) {
            $_SESSION['tc']         = $user->getTc();
            $_SESSION['password']   = $user->getPassword();
            $_SESSION['firstName']  = $user->getFirstName();
            $_SESSION['address']    = $user->getAddress();
            $_SESSION['surName']    = $user->getSurName();
            $_SESSION['user_role']  = $user->getUserRole();
            header("Location: /deu-cure/gallery.php");
        }  else {
            header("Location: /deu-cure/about.php");
        }
    }

    public static function registerUser($user) {
        global $connection;

        //$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

        $stmt = mysqli_prepare($connection, "INSERT INTO users (tc, firstName, surName, userRole, birthDate, email, password, gender, telephoneNumber, address, bloodType) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
        mysqli_stmt_bind_param($stmt, "isssssssiss", $user->getTc(), $user->getFirstName(), $user->getSurName(), $user->getUserRole(), $user->getBirthDate(), $user->getEmail(), $user->getPassword(), $user->getGender(), $user->getTel(), $user->getAddress(), $user->getBloodType());
        $flag = mysqli_stmt_execute($stmt);
        if($flag)
            return true;
        return false;
    }

    public static function tcExists($tc) {
        global $connection;
        $query  = "SELECT tc FROM users WHERE tc = '$tc'";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function emailExists($email) {
        global $connection;
        $query  = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function selectUser($tc){
        global $connection;
        $query = "SELECT * FROM users WHERE tc = {$tc}";
        $select_user_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($select_user_query);
        $user = new User($row['tc'], $row['firstName'], $row['surName'], $row['birthDate'], $row['email'], $row['password'], $row['telephoneNumber'], $row['address'], $row['gender'], $row['bloodType'], $row['userRole']);
        return $user;
    }

    public static function updateUser($user){
        global $connection;

        $stmt = mysqli_prepare($connection, "UPDATE users SET firstName = ?, surName = ?, birthDate = ?, email = ?, password = ?, telephoneNumber = ?, address = ?, gender = ?, bloodType = ?, userRole = ? WHERE tc = {$user->getTc()}");
        mysqli_stmt_bind_param($stmt, "sssssissss", $user->getFirstName(), $user->getSurName(), $user->getBirthDate(), $user->getEmail(), $user->getPassword(), $user->getTel(), $user->getAddress(), $user->getGender(), $user->getBloodType(), $user->getUserRole());
        $flag = mysqli_stmt_execute($stmt);
        if($flag)
            return true;
        return false;
    }
    
    public static function getAllUsers () {
        global $connection;
        $query = "SELECT * FROM users";
        $select_user_query = mysqli_query($connection, $query);
        $allUsers = array();

        while($row = mysqli_fetch_assoc($select_user_query)) {
            $user = new User($row['tc'], $row['firstName'], $row['surName'], $row['birthDate'], $row['email'], $row['password'], $row['telephoneNumber'], $row['address'], $row['gender'], $row['bloodType'], $row['userRole']);
            array_push($allUsers, $user);
        }

        return $allUsers;
    }
    
    public static function deleteUser($tc) {
        global $connection;
        $query = "DELETE FROM users WHERE tc = $tc ";
        $delete_query = mysqli_query($connection, $query);
        if($delete_query)
            return true;
        return false;
    }
    
    public static function deleteAssaysByTc($tc){
        global $connection;
        $query = "DELETE FROM assays WHERE tc = $tc ";
        $delete_query = mysqli_query($connection, $query);
        if($delete_query)
            return true;
        return false;
    }
    
    public static function getAssayNumbers($tc){
        global $connection;
        $query = "SELECT * FROM assays WHERE tc = {$tc}";
        $select_assays_query = mysqli_query($connection, $query);
        $allAssays = array();
        while($row = mysqli_fetch_assoc($select_assays_query)){
            $assay = new Assay($row['tc'], $row['assayNumber']);
            array_push($allAssays,$assay);
        }
        
        return $allAssays;
    }
}
?>