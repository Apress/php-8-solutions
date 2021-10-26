<?php
use Php8Solutions\File\Upload;
// set the maximum upload size in bytes
$max = 51200;
if (isset($_POST['upload'])) {
    // define the path to the upload folder
    $path = 'C:/upload_test/';
    require_once '../Php8Solutions/File/Upload.php';
    try {
        $loader = new Upload('image', $path);
        $result = $loader->getMessages();
    } catch (Throwable $t) {
        echo $t->getMessage();
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta  charset="utf-8">
    <title>Upload File</title>
</head>

<body>
<?php
if (isset($result)) {
    echo '<ul>';
    foreach ($result as $message) {
        echo "<li>$message</li>";
    }
    echo '</ul>';
}
?>
<form action="file_upload.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="image">Upload image:</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $max ?>">
        <input type="file" name="image" id="image">
    </p>
    <p>
        <input type="submit" name="upload" id="upload" value="Upload">
    </p>
</form>
</body>
</html>