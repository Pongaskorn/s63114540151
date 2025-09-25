<?php
include "db.php";
session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // ตรวจสอบ user login (แบบ plain password ก่อน)
    $sql = "SELECT * FROM user_info WHERE email = $1 AND password = $2";
    $run_query = pg_query_params($con, $sql, array($email, $password));

    if (!$run_query) {
        die("❌ Query failed: " . pg_last_error($con));
    }

    $count = pg_num_rows($run_query);

    if ($count == 1) {
        $row = pg_fetch_assoc($run_query);
        $_SESSION["uid"] = $row["user_id"];
        $_SESSION["name"] = $row["first_name"];
        $ip_add = getenv("REMOTE_ADDR");

        // ถ้ามี cookie product_list => merge cart
        if (isset($_COOKIE["product_list"])) {
            $p_list = stripslashes($_COOKIE["product_list"]);
            $product_list = json_decode($p_list, true);

            for ($i = 0; $i < count($product_list); $i++) {
                $verify_cart = "SELECT id FROM cart WHERE user_id = $1 AND p_id = $2";
                $result = pg_query_params($con, $verify_cart, array($_SESSION["uid"], $product_list[$i]));

                if (pg_num_rows($result) < 1) {
                    // update cart
                    $update_cart = "UPDATE cart SET user_id = $1 WHERE ip_add = $2 AND user_id = -1";
                    pg_query_params($con, $update_cart, array($_SESSION["uid"], $ip_add));
                } else {
                    // delete duplicate product
                    $delete_existing_product = "DELETE FROM cart WHERE user_id = -1 AND ip_add = $1 AND p_id = $2";
                    pg_query_params($con, $delete_existing_product, array($ip_add, $product_list[$i]));
                }
            }

            // clear cookie
            setcookie("product_list", "", time() - 3600, "/");

            echo "cart_login";
            exit();
        }

        // login success
        echo "login_success";

        if (!isset($_SERVER['HTTP_REFERER'])) {
            header('Location: index.php');
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        exit();
    } else {
        // ถ้าไม่เจอใน user → ลองเช็ค admin
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        $sql = "SELECT * FROM admin_info WHERE admin_email = $1 AND admin_password = $2";
        $run_query = pg_query_params($con, $sql, array($email, $password));

        if (!$run_query) {
            die("❌ Query failed: " . pg_last_error($con));
        }

        $count = pg_num_rows($run_query);

        if ($count == 1) {
            $row = pg_fetch_assoc($run_query);
            $_SESSION["uid"] = $row["admin_id"];
            $_SESSION["name"] = $row["admin_name"];
            $ip_add = getenv("REMOTE_ADDR");

            echo "login_success";
            echo "<script> location.href='admin/addproduct.php'; </script>";
            exit();
        } else {
            echo "<span style='color:red;'>Please register before login..!</span>";
            exit();
        }
    }
}
?>
