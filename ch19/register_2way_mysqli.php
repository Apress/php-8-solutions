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
    $conn = dbConnect('write');
    // create a key
    $key = 'takeThisWith@PinchOfSalt';
    // prepare SQL statement
    $sql = 'INSERT INTO users_2way (username, pwd) VALUES (?, AES_ENCRYPT(?, ?))';
    $stmt = $conn->stmt_init();
    if ($stmt = $conn->prepare($sql)) {
        // bind parameters and insert the details into the database
        $stmt->bind_param('sss', $username, $password, $key);
        $stmt->execute();
    }
    if ($stmt->affected_rows == 1) {
        $success = htmlentities($username) . ' has been registered. You may now log in.';
    } elseif ($stmt->errno == 1062) {
        $errors[] = htmlentities($username) . ' is already in use. Please choose another username.';
    } else {
        $errors[] = $stmt->error;
    }
}
