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
    // hash password using default algorithm
    $password = password_hash($password, PASSWORD_DEFAULT);
    // open the file in append mode
    $file = fopen($userfile, 'a+');
    // if filesize is zero, no names yet registered
    // so just write the username and password to file as CSV
    if (filesize($userfile) === 0) {
        fputcsv($file, [$username, $password]);
        $result = "$username registered.";
    } else {
        // if filesize is greater than zero, check username first
        // move internal pointer to beginning of file
        rewind($file);
        // loop through file one line at a time
        while (!feof($file)) {
            $data = fgetcsv($file);
            // skip empty lines
            if (!$data) continue;
            if ($data[0] == $username) {
                $result = "$username taken - choose a different username.";
                break;
            }
        }
        // if $result not set, username is OK
        if (!isset($result)) {
            // insert new CSV record
            fputcsv($file, [$username, $password]);
            $result = "$username registered.";
        }
        // close the file
        fclose($file);
    }
}