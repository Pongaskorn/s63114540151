<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";

/*
 * categoryhome: ส่ง HTML navigation ของ category (ยกเว้น cat_id = 1)
 */
if (isset($_POST["categoryhome"])) {
    $category_query = "SELECT * FROM categories WHERE cat_id != 1 ORDER BY cat_title";
    $run_query = pg_query($con, $category_query) or die(pg_last_error($con));

    echo "
        <!-- responsive-nav -->
        <div id='responsive-nav'>
            <!-- NAV -->
            <ul class='main-nav nav navbar-nav'>
                <li class='active'><a href='index.php'>Home</a></li>
                <li><a href='store.php'>Electronics</a></li>
    ";

    if (pg_num_rows($run_query) > 0) {
        while ($row = pg_fetch_assoc($run_query)) {
            $cid = $row["cat_id"];
            $cat_name = htmlspecialchars($row["cat_title"], ENT_QUOTES);

            // นับสินค้าต่อ category (ใช้ parameterized query)
            $countQ = pg_query_params($con, "SELECT COUNT(*) AS count_items FROM products WHERE product_cat = $1", array($cid));
            $countRow = $countQ ? pg_fetch_assoc($countQ) : null;
            $count = $countRow ? $countRow["count_items"] : 0;

            echo "<li class='categoryhome' cid='$cid'><a href='store.php'>$cat_name</a></li>";
        }
    }

    echo "
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    ";
}


/*
 * pagination (ใช้สำหรับหน้า home ถ้าขอ)
 */
if (isset($_POST["page"])) {
    $sql = "SELECT COUNT(*) AS total FROM products";
    $run_query = pg_query($con, $sql) or die(pg_last_error($con));
    $row = pg_fetch_assoc($run_query);
    $count = (int)$row["total"];

    // original ใช้ pageno = ceil(count/2)
    $pageno = ($count > 0) ? ceil($count / 2) : 1;
    for ($i = 1; $i <= $pageno; $i++) {
        echo "<li><a href='#product-row' page='$i' id='page'>$i</a></li>";
    }
}


/*
 * getProducthome: small widgets (limit 3)
 */
if (isset($_POST["getProducthome"])) {
    $limit = 3;
    if (isset($_POST["setPage"])) {
        $pageno = (int) $_POST["pageNumber"];
        $start = ($pageno - 1) * $limit;
    } else {
        $start = 0;
    }

    $product_query = "
        SELECT p.*, c.cat_title
        FROM products p
        JOIN categories c ON p.product_cat = c.cat_id
        ORDER BY p.product_id DESC
        LIMIT $1 OFFSET $2
    ";
    $run_query = pg_query_params($con, $product_query, array($limit, $start)) or die(pg_last_error($con));

    if (pg_num_rows($run_query) > 0) {
        while ($row = pg_fetch_assoc($run_query)) {
            $pro_id = $row['product_id'];
            $pro_title = htmlspecialchars($row['product_title'], ENT_QUOTES);
            $pro_price = htmlspecialchars($row['product_price'], ENT_QUOTES);
            $pro_image = htmlspecialchars($row['product_image'], ENT_QUOTES);
            $cat_name = htmlspecialchars($row['cat_title'], ENT_QUOTES);

            echo "
                <div class='product-widget'>
                    <a href='product.php?p=$pro_id'>
                        <div class='product-img'>
                            <img src='product_images/$pro_image' alt=''>
                        </div>
                        <div class='product-body'>
                            <p class='product-category'>$cat_name</p>
                            <h3 class='product-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                            <h4 class='product-price'>$pro_price<del class='product-old-price'>$990.00</del></h4>
                        </div>
                    </a>
                </div>
            ";
        }
    }
}


/*
 * gethomeProduct: products for home (example used BETWEEN 71 AND 74 before)
 */
if (isset($_POST["gethomeProduct"])) {
    // หากต้องการปรับเป็น dynamic ให้แก้ WHERE clause ตามที่ต้องการ
    $product_query = "
        SELECT p.*, c.cat_title
        FROM products p
        JOIN categories c ON p.product_cat = c.cat_id
        WHERE p.product_id BETWEEN 71 AND 74
        ORDER BY p.product_id DESC
    ";
    $run_query = pg_query($con, $product_query) or die(pg_last_error($con));

    if (pg_num_rows($run_query) > 0) {
        while ($row = pg_fetch_assoc($run_query)) {
            $pro_id = $row['product_id'];
            $pro_title = htmlspecialchars($row['product_title'], ENT_QUOTES);
            $pro_price = htmlspecialchars($row['product_price'], ENT_QUOTES);
            $pro_image = htmlspecialchars($row['product_image'], ENT_QUOTES);
            $cat_name = htmlspecialchars($row['cat_title'], ENT_QUOTES);

            echo "
                <div class='col-md-3 col-xs-6'>
                    <a href='product.php?p=$pro_id'>
                        <div class='product'>
                            <div class='product-img'>
                                <img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
                                <div class='product-label'>
                                    <span class='sale'>-30%</span>
                                    <span class='new'>NEW</span>
                                </div>
                            </div>
                        </a>
                        <div class='product-body'>
                            <p class='product-category'>$cat_name</p>
                            <h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                            <h4 class='product-price header-cart-item-info'>$pro_price<del class='product-old-price'>$990.00</del></h4>
                            <div class='product-rating'>
                                <i class='fa fa-star'></i><i class='fa fa-star'></i>
                                <i class='fa fa-star'></i><i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                            </div>
                            <div class='product-btns'>
                                <button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
                                <button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
                                <button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
                            </div>
                        </div>
                        <div class='add-to-cart'>
                            <button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
                        </div>
                    </div>
                </div>
            ";
        }
    }
}


/*
 * get_seleted_Category OR search (home)
 */
if (isset($_POST["get_seleted_Category"]) || isset($_POST["search"])) {
    if (isset($_POST["get_seleted_Category"])) {
        $id = (int) $_POST["cat_id"];
        $sql = "SELECT p.*, c.cat_title
                FROM products p
                JOIN categories c ON p.product_cat = c.cat_id
                WHERE p.product_cat = $1";
        $run_query = pg_query_params($con, $sql, array($id));
    } else {
        $keyword = $_POST["keyword"];
        // ใช้ ILIKE เพื่อค้นหาไม่ case-sensitive
        $sql = "SELECT p.*, c.cat_title
                FROM products p
                JOIN categories c ON p.product_cat = c.cat_id
                WHERE p.product_keywords ILIKE '%' || $1 || '%'";
        $run_query = pg_query_params($con, $sql, array($keyword));
    }

    if ($run_query && pg_num_rows($run_query) > 0) {
        while ($row = pg_fetch_assoc($run_query)) {
            $pro_id = $row['product_id'];
            $pro_title = htmlspecialchars($row['product_title'], ENT_QUOTES);
            $pro_price = htmlspecialchars($row['product_price'], ENT_QUOTES);
            $pro_image = htmlspecialchars($row['product_image'], ENT_QUOTES);
            $cat_name = htmlspecialchars($row['cat_title'], ENT_QUOTES);

            echo "
                <div class='col-md-4 col-xs-6'>
                    <a href='product.php?p=$pro_id'>
                        <div class='product'>
                            <div class='product-img'>
                                <img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
                                <div class='product-label'>
                                    <span class='sale'>-30%</span>
                                    <span class='new'>NEW</span>
                                </div>
                            </div>
                        </a>
                        <div class='product-body'>
                            <p class='product-category'>$cat_name</p>
                            <h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                            <h4 class='product-price header-cart-item-info'>$pro_price<del class='product-old-price'>$990.00</del></h4>
                            <div class='product-rating'>
                                <i class='fa fa-star'></i><i class='fa fa-star'></i>
                                <i class='fa fa-star'></i><i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                            </div>
                            <div class='product-btns'>
                                <button class='add-to-wishlist' tabindex='0'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
                                <button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
                                <button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
                            </div>
                        </div>
                        <div class='add-to-cart'>
                            <button pid='$pro_id' id='product' href='#' tabindex='0' class='add-to-cart-btn'><i class='fa fa-shopping-cart'></i> add to cart</button>
                        </div>
                    </div>
                </div>
            ";
        }
    }
}
?>
