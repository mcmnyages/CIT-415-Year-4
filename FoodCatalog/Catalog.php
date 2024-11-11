<?php
include("funtions_main.inc");

$n_per_page = 2; // Number of products per page

if(isset($_POST['Products'])) {
    if(!isset($_POST['interest'])) {
        header("location: Catalog.php");
        exit();
    } else {
        // Product page logic
        if(isset($_POST['n_end'])) {
            if($_POST['Products'] == "Previous") {
                $n_start = $_POST['n_end'] - ($n_per_page);
            } else {
                $n_start = $_POST['n_end'] + 1;
            }
        } else {
            $n_start = 1;
        }
        $n_end = $n_start + $n_per_page - 1;

        $connect = connect_to_db("Vars.inc");
        $query_food = "SELECT * FROM Food WHERE type='$_POST[interest]' ORDER BY name";
        $result = mysqli_query($connect, $query_food)
            or die ("query_food: " . mysqli_error($connect));

        $n = 1;
        while($row = mysqli_fetch_assoc($result)) {
            foreach($row as $field => $value) {
                $products[$n][$field] = $value;
            }
            $n++;
        }
        $n_products = sizeof($products);
        if($n_end > $n_products) {
            $n_end = $n_products;
        }

        include("fields_products_page.inc");
        include("catalog_product_page.inc");
    }
} else {
    // Index page logic
    $cxn = connect_to_db("Vars.inc");
    $query = "SELECT DISTINCT category, type FROM Food ORDER BY category, type";
    $result = mysqli_query($cxn, $query)
        or die ("Couldn't execute query. " . mysqli_error($cxn));

    while($row = mysqli_fetch_array($result)) {
        $food_categories[$row['category']][] = $row['type'];
    }

    include("fields_index_page.inc");
    include("catalog_index_page.inc");
}
?>