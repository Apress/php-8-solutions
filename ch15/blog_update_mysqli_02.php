<?php
require_once '../includes/connection.php';
require_once '../includes/utility_funcs.php';
// initialize flags
$OK = false;
$done = false;
// create database connection
$conn = dbConnect('write');
// initialize statement
$stmt = $conn->stmt_init();
// get details of selected record
if (isset($_GET['article_id']) && !$_POST) {
    // prepare SQL query
    $sql = 'SELECT article_id, title, article
            FROM blog WHERE article_id = ?';
    if ($stmt->prepare($sql)) {
        // bind the query parameter
        $stmt->bind_param('i', $_GET['article_id']);
        // execute the query, and fetch the result
        $OK = $stmt->execute();
        // bind the results to variables
        $stmt->bind_result($article_id, $title, $article);
        $stmt->fetch();
    }
}
// redirect if $_GET['article_id'] not defined
if (!isset($_GET['article_id'])) {
    $url = 'http://localhost/php8sols/admin/blog_list_mysqli.php';
    header("Location: $url");
    exit;
}
// get error message if query fails
if (isset($stmt) && !$OK && !$done) {
    $error = $stmt->error;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Blog Entry</title>
    <link href="../styles/admin.css" rel="stylesheet" type="text/css">
</head>

<body>
<h1>Update Blog Entry</h1>
<p><a href="blog_list_mysqli.php">List all entries </a></p>
<?php if (isset($error)) {
    echo "<p class='warning'>Error: $error</p>";
}
if($article_id == 0) { ?>
    <p class="warning">Invalid request: record does not exist.</p>
<?php } else { ?>
<form method="post" action="blog_update_mysqli.php">
    <p>
        <label for="title">Title:</label>
        <input name="title" type="text" id="title" value="<?= safe($title) ?>">
    </p>
    <p>
        <label for="article">Article:</label>
        <textarea name="article" id="article"><?= safe($article) ?></textarea>
    </p>
    <p>
        <input type="submit" name="update" value="Update Entry">
        <input name="article_id" type="hidden" value="<?= $article_id ?>">
    </p>
</form>
<?php } ?>
</body>
</html>