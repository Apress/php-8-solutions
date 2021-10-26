<?php
function safe($text) {
    return htmlspecialchars($text, double_encode: false);
}
