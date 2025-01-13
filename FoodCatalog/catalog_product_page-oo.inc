<html>
<head><title><?php echo $page['title'] ?></title></head>
<body>
<div style='margin-left: .1in; margin-right: .1in'>
    <h1 align='center'><?php echo $page['top'] ?></h1>
    <p><font size='+2'><b><?php echo $_POST['interest'] ?></b></font>
    <p align='right'>(<?php echo $n_products ?> products found)</p>
    
    <table border='0' cellpadding='3' width='100%'>
        <tr>
        <?php foreach($table_heads as $heading): ?>
            <th><?php echo $heading ?></th>
        <?php endforeach; ?>
        </tr>
        
        <?php for($i = $n_start; $i <= $n_end; $i++): ?>
        <tr>
            <td align='right'><?php echo $all[$i]->catalog_number ?></td>
            <td><?php echo $all[$i]->name ?></td>
            <td><?php echo $all[$i]->description ?></td>
            <td style='text-align: center'>$<?php echo $all[$i]->price ?>/lb</td>
            <td style='text-align: center'>
                <img src='images/<?php echo $all[$i]->pix ?>' width='55' height='60'>
            </td>
        </tr>
        <?php endfor; ?>
    </table>

    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
        <input type='hidden' name='n_end' value='<?php echo $n_end ?>'>
        <input type='hidden' name='interest' value='<?php echo $_POST['interest'] ?>'>
        <input type='submit' value='Select another category'>
        <?php if($n_end > $n_per_page): ?>
            <input type='submit' name='Products' value='Previous'>
        <?php endif; ?>
        <?php if($n_end < $n_products): ?>
            <input type='submit' name='Products' value='Next <?php echo $n_per_page ?>'>
        <?php endif; ?>
    </form>
</div>
<hr>
<p style='text-align: center; font-size: 75%'><?php echo $page['bottom'] ?></p>
</body>
</html>