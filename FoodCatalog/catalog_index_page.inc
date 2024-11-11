<html>
<head><title><?php echo $page['title'] ?></title></head>
<body>
<div style='margin-left: .1in'>
<h1 align='center'><?php echo $page['top'] ?></h1><hr>
<form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
<?php
foreach($food_categories as $key => $subarray) {
    echo "<h3>$key</h3>";
    echo "<ul>";
    foreach($subarray as $type) {
        echo "<input type='radio' name='interest' value='$type'><b>$type</b><br>\n";
    }
    echo "</ul>";
}
?>
<p><input type='submit' name='Products' value='Select Category'>
</form>
</div>
<hr><font size="-1"><?php echo $page['bottom'] ?></font>
</body></html>