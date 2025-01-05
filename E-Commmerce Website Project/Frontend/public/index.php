<?php
include 'src/components/nav.php';


echo "
<div class='container mx-auto px-4'>
    <header class='text-center py-5'>
        <h1 class='text-4xl font-bold text-gray-800'>Welcome to My Ecommerce Website</h1>
        <p class='text-lg text-gray-600 mt-2'>Find the best products at unbeatable prices</p>
    </header>
    
    <section class='my-10'>
        <h2 class='text-2xl font-bold text-gray-800 mb-5'>Featured Products</h2>
        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
            <div class='bg-white rounded-lg shadow-md overflow-hidden'>
                <img src='https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.mL9GqnkuX82xRnPyV7lvJAHaHa%26pid%3DApi&f=1&ipt=fba28d4a882be412129ccd0de3300e8a5d359e151ff92f81228b2f65fc11f323&ipo=images' alt='Product 1' class='w-full h-48 object-cover'>
                <div class='p-4'>
                    <h2 class='text-xl font-semibold text-gray-800'>Product 1</h2>
                    <p class='text-gray-600 mt-2'>Description of product 1.</p>
                </div>
            </div>
            <div class='bg-white rounded-lg shadow-md overflow-hidden'>
                <img src='https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.TqRgd0FAlCJEdKQrIgyqtAHaE8%26pid%3DApi&f=1&ipt=e096d765fce49dce657506b1b6a00bbcc13791f990c9b7122fe3a9822e086b31&ipo=images' alt='Product 2' class='w-full h-48 object-cover'>
                <div class='p-4'>
                    <h2 class='text-xl font-semibold text-gray-800'>Product 2</h2>
                    <p class='text-gray-600 mt-2'>Description of product 2.</p>
                </div>
            </div>
            <div class='bg-white rounded-lg shadow-md overflow-hidden'>
                <img src='https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.2aVmvU0AmupnKGFco_6XLgHaE0%26pid%3DApi&f=1&ipt=803f9d58e55fe3fdf40b3f54e4c85de3929caf32fb918024d6fdde00ee1d6def&ipo=images' alt='Product 3' class='w-full h-48 object-cover'>
                <div class='p-4'>
                    <h2 class='text-xl font-semibold text-gray-800'>Product 3</h2>
                    <p class='text-gray-600 mt-2'>Description of product 3.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class='my-10'>
        <h2 class='text-2xl font-bold text-gray-800 mb-5'>Customer Testimonials</h2>
        <div class='bg-white rounded-lg shadow-md p-6'>
            <p class='text-gray-600'>'I love shopping here! The products are amazing and the prices are unbeatable.' - Jane Doe</p>
        </div>
        <div class='bg-white rounded-lg shadow-md p-6 mt-4'>
            <p class='text-gray-600'>'Great customer service and fast shipping. Highly recommend!' - John Smith</p>
        </div>
    </section>
    
    <section class='my-10'>
        <h2 class='text-2xl font-bold text-gray-800 mb-5'>Subscribe to Our Newsletter</h2>
        <form class='bg-white rounded-lg shadow-md p-6'>
            <div class='mb-4'>
                <label for='email' class='block text-gray-700'>Email:</label>
                <input type='email' id='email' name='email' class='w-full px-3 py-2 border border-gray-300 rounded-md' required>
            </div>
            <button type='submit' class='bg-blue-500 text-white px-4 py-2 rounded-md'>Subscribe</button>
        </form>
    </section>
</div>
";

include 'src/components/footer.php';
?>
