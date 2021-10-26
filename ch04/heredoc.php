<!DOCTYPE HTML>
<html>
<head>
<meta  charset="utf-8">
<title>Heredoc syntax</title>
</head>

<body>
<?php
$fish = 'whiting';
$book['title'] = 'Alice in Wonderland';
$mockTurtle =
"\"Oh, you sing,\" said the Gryphon. \"I've forgotten the words.\"
So they began solemnly dancing round and round Alice, every now and then treading on her toes when they passed too close, and waving their fore-paws to mark the time, while the Mock Turtle sang this, very slowly and sadly:—
\"Will you walk a little faster?\" said a $fish to a snail.
\"There's a porpoise close behind us, and he's treading on my tail.\"
(from {$book['title']})";
echo $mockTurtle;
?>
</body>
</html>
