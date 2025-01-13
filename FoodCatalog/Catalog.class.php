<?php
class Catalog {
    private $cxn;
    private $catalog_name;
    private $host;
    private $user;
    private $password;

    function __construct($filename) {
        if(is_string($filename)) {
            include($filename);
        } else {
            throw new Exception("Parameter is not a filename");
        }

        $this->cxn = new mysqli($host, $user, $passwd);
        if(mysqli_connect_errno()) {
            throw new Exception("Database is not available. Try again later.");
            exit();
        }

        $this->host = $host;
        $this->user = $user;
        $this->password = $passwd;
    }

    function selectCatalog($database) {
        $db = $this->cxn->select_db($database);
        if(mysqli_errno($this->cxn)) {
            if(mysqli_errno($this->cxn) == 1049) {
                throw new Exception("$database does not exist");
            } else {
                throw new Exception("Database is not available. Try again later");
            }
        }
        $this->catalog_name = $database;
    }

    function getCategoriesAndTypes() {
        $sql = "SELECT DISTINCT category, type FROM Food ORDER BY category, type";
        if(!$result = $this->cxn->query($sql)) {
            throw new Exception(mysqli_error($this->cxn));
        }
        
        while($row = $result->fetch_array()) {
            $array_cat_type[$row['category']][] = $row['type'];
        }
        return $array_cat_type;
    }

    function getAllofType($type) {
        if(!is_string($type)) {
            throw new Exception("$type is not a type.");
        }

        $sql = "SELECT * FROM Food WHERE type=? ORDER BY name";
        $stmt = $this->cxn->prepare($sql);
        $stmt->bind_param("s", $type);
        
        if(!$stmt->execute()) {
            throw new Exception(mysqli_error($this->cxn));
        }

        $result = $stmt->get_result();
        $n = 1;
        while($row = $result->fetch_object()) {
            $array_all[$n] = $row;
            $n++;
        }
        return $array_all;
    }

    function displayCategories() {
        $food_categories = $this->getCategoriesAndTypes();
        include("fields_index_page.inc");
        include("catalog_index_page.inc");
    }

    function displayAllofType($type, $page) {
        if(!is_string($type)) {
            throw new Exception("$type is not a type.");
        }
        
        if(!is_int($page)) {
            throw new Exception("$page is not an integer.");
        }

        $n_per_page = $page;
        $all = $this->getAllofType($type);
        $n_products = sizeof($all);

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
        if($n_end >= $n_products) {
            $n_end = $n_products;
        }

        include("fields_products_page.inc");
        include("catalog_product_page-oo.inc");
    }
}
?>