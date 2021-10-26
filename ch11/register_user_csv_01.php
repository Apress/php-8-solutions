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

