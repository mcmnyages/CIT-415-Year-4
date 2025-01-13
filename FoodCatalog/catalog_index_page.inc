<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page['title'] ?></title>
    <!-- Add Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">
            <?php echo $page['top'] ?>
        </h1>
        <hr class="border-gray-300 mb-8">
        
        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST' 
              class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <?php foreach($food_categories as $key => $subarray): ?>
                <h3 class="text-xl font-semibold text-gray-700 mb-3"><?php echo $key ?></h3>
                <ul class="mb-6 space-y-2">
                    <?php foreach($subarray as $type): ?>
                        <li class="flex items-center">
                            <input type='radio' name='interest' 
                                   value='<?php echo $type ?>'
                                   class="w-4 h-4 text-blue-600">
                            <label class="ml-2 text-gray-700 font-medium">
                                <?php echo $type ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
            
            <button type="submit" name="Products" 
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                Select Category
            </button>
        </form>
    </div>
    <footer class="text-center text-gray-500 text-sm mt-8">
        <?php echo $page['bottom'] ?>
    </footer>
</body>
</html>
