<?php
use Php8Solutions\Authenticate\CheckPassword;

require_once __DIR__ . '/../Php8Solutions/Authenticate/CheckPassword.php';
$usernameMinChars = 6;
$formErrors = [];
if (strlen($username) < $usernameMinChars) {
    $formErrors[] = "Username must be at least $usernameMinChars characters.";
}
if (!preg_match('/^[-_\p{L}\d]+$/ui', $username)) {
    $formErrors[] = 'Only alphanumeric characters, hyphens, and underscores are permitted in username.';
}
if ($password != $retyped) {
    $formErrors[] = "Your passwords don't match.";
}
$checkPwd = new CheckPassword($password, minNums: 2, minSymbols: 1);
$errors = array_merge($formErrors, $checkPwd->getErrors());
if (!$errors) {
    // include the connection file
    require_once 'connection.php';
    $conn = dbConnect('write', 'pdo');
    // create a key
    $key = 'takeThisWith@PinchOfSalt';
    try {
    // prepare SQL statement
    $sql = 'INSERT INTO users_2way (username, pwd)
            VALUES (:username, AES_ENCRYPT(:pwd, :key))';
    $stmt = $conn->prepare($sql);
    // bind parameters and insert the details into the database
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':pwd', $password, PDO::PARAM_STR);
    $stmt->bindParam(':key', $key, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $success = htmlentities($username) . ' has been registered. You may now log in.';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $errors[] = htmlentities($username) . ' is already in use. Please choose another username.';
        } else {
            $errors[] = $e->getMessage();
        }
    }
}
