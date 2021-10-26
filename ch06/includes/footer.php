<footer>
        <?php
        $startYear = 2006;
        $thisYear = date('Y');
        if ($startYear == $thisYear) {
            $output = $startYear;
        } else {
            $output = "{$startYear}&ndash;{$thisYear}";
        }
        ?>
    <p>&copy; <?= $output ?> David Powers</p>
</footer>