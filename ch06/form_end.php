<?php
$currentPage = '/php8sols/ch06/form_end.php';
if ($currentPage !== $_SERVER['PHP_SELF']) {
    header('Location: http://localhost/php8sols/ch06/missing.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PHP_SELF XSS</title>
</head>

<body>
<h1>Prevent XSS with Form</h1>
	<?php
	if (isset($_POST['name'])) {
		echo '<p>Hi there, ' . htmlentities($_POST['name']) . '!</p>';
	}
	?>
<form method="post"  action="<?= $currentPage ?>">
    <p>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
    </p>
    <p>
        <input type="submit" name="submit" id="submit" value="Submit">
    </p>
</form>
</body>
</html>