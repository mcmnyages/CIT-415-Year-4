<html>
<head>
    <title><?php echo $page['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-6"><?php echo $page['top'] ?></h1>
    <p class="text-2xl font-bold mb-4"><?php echo $_POST['interest'] ?></p>
    <p class="text-right text-gray-600 mb-4">(<?php echo $n_products ?> products found)</p>
    
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                <?php foreach($table_heads as $heading): ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo $heading ?></th>
                <?php endforeach; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php for($i = $n_start; $i <= $n_end; $i++): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-right whitespace-nowrap"><?php echo $all[$i]->catalog_number ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $all[$i]->name ?></td>
                    <td class="px-6 py-4"><?php echo $all[$i]->description ?></td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">$<?php echo $all[$i]->price ?>/lb</td>
                    <td class="px-6 py-4 text-center">
                        <img src='images/<?php echo $all[$i]->pix ?>' class="w-[55px] h-[60px] inline-block">
                    </td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST' class="mt-6 space-x-4">
        <input type='hidden' name='n_end' value='<?php echo $n_end ?>'>
        <input type='hidden' name='interest' value='<?php echo $_POST['interest'] ?>'>
        <input type='submit' value='Select another category' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <?php if($n_end > $n_per_page): ?>
            <input type='submit' name='Products' value='Previous' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <?php endif; ?>
        <?php if($n_end < $n_products): ?>
            <input type='submit' name='Products' value='Next <?php echo $n_per_page ?>' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <?php endif; ?>
    </form>
</div>
<hr class="my-8">
<p class="text-center text-sm text-gray-500"><?php echo $page['bottom'] ?></p>
</body>
</html>