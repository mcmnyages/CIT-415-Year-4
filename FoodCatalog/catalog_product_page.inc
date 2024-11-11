<html>
<head><title><?php echo $page['title'] ?></title></head>
<body>
<div style='margin-left: .1in; margin-right: .1in'>
<h1 align='center'><?php echo $page['top'] ?></h1>
<p><font size='+2'><b><?php echo $_POST['interest'] ?></b></font>
<p align='right'>(<?php echo $n_products ?> products found)
<table border='0' cellpadding='3' width='100%'>
<tr>
<?php
foreach($table_heads as $heading) {
    echo "<th>$heading</th>";
}
?>
</tr>
<?php
for ($i = $n_start; $i <= $n_end; $i++) {
    echo "<tr>";
    echo "<td align='right'>{$products[$i]['catalog_number']}</td>";
    echo "<td>{$products[$i]['name']}</td>";
    echo "<td>{$products[$i]['description']}</td>";
    echo "<td style='text-align: center'>\${$products[$i]['price']}/lb</td>";
    echo "<td style='text-align: center'><img src='images/{$products[$i]['pix']}' width='55' height='60'></td>";
    echo "</tr>";
}
?>
</table>
<form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
<input type='hidden' name='n_end' value='<?php echo $n_end ?>'>
<input type='hidden' name='interest' value='<?php echo $_POST['interest'] ?>'>
<input type='submit' value='Select another category'>
<?php
if($n_end > $n_per_page) {
    echo "<input type='submit' name='Products' value='Previous'>";
}
if($n_end < $n_products) {
    echo "<input type='submit' name='Products' value='Next $n_per_page'>";
}
?>
</form>
<p style='text-align: center; font-size: 75%'><?php echo $page['bottom'] ?></p>
</div>
</body></html>