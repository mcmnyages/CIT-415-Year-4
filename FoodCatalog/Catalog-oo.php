<?php
require_once("Catalog.class.php");

if(isset($_POST['Products'])) {
    if(!isset($_POST['interest'])) {
        header("location: Catalog-oo.php");
        exit();
    } else {
        try {
            $foodcat = new Catalog("Vars.inc");
            $foodcat->selectCatalog("FoodCatalog");
            $foodcat->displayAllofType($_POST['interest'], 2);
        } catch(Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }
} else {
    try {
        $foodcat = new Catalog("Vars.inc");
        $foodcat->selectCatalog("FoodCatalog");
        $foodcat->displayCategories();
    } catch(Exception $e) {
        echo $e->getMessage();
        exit();
    }
}
?>