<?php
session_start();
include "db.php"; // ใช้ไฟล์ db.php ที่เชื่อมกับ PostgreSQL

if (isset($_SESSION["uid"])) {

    $f_name     = $_POST["firstname"];
    $email      = $_POST['email'];
    $address    = $_POST['address'];
    $city       = $_POST['city'];
    $state      = $_POST['state'];
    $zip        = $_POST['zip'];
    $cardname   = $_POST['cardname'];
    $cardnumber = $_POST['cardNumber'];
    $expdate    = $_POST['expdate'];
    $cvv        = $_POST['cvv'];
    $user_id    = $_SESSION["uid"];
    $cardnumberstr = (string)$cardnumber;
    $total_count   = $_POST['total_count'];
    $prod_total    = $_POST['total_price'];

    // ✅ หา order_id ใหม่
    $sql0 = "SELECT order_id FROM orders_info";
    $runquery = pg_query($con, $sql0);

    if (pg_num_rows($runquery) == 0) {
        $order_id = 1;
    } else {
        $sql2 = "SELECT MAX(order_id) AS max_val FROM orders_info";
        $runquery1 = pg_query($con, $sql2);
        $row = pg_fetch_assoc($runquery1);
        $order_id = $row["max_val"] + 1;
    }

    // ✅ Insert ข้อมูลลงตาราง orders_info
    $sql = "INSERT INTO orders_info
        (order_id, user_id, f_name, email, address, city, state, zip, cardname, cardnumber, expdate, prod_count, total_amt, cvv) 
        VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)";

    $insertOrder = pg_query_params($con, $sql, array(
        $order_id, $user_id, $f_name, $email, $address, $city, $state, $zip,
        $cardname, $cardnumberstr, $expdate, $total_count, $prod_total, $cvv
    ));

    if ($insertOrder) {
        $i = 1;
        while ($i <= $total_count) {
            $prod_id   = $_POST['prod_id_'.$i];
            $prod_price= $_POST['prod_price_'.$i];
            $prod_qty  = $_POST['prod_qty_'.$i];
            $sub_total = (int)$prod_price * (int)$prod_qty;

            // ✅ Insert order_products
            $sql1 = "INSERT INTO order_products (order_pro_id, order_id, product_id, qty, amt) 
                     VALUES (DEFAULT, $1, $2, $3, $4)";
            $insertProduct = pg_query_params($con, $sql1, array(
                $order_id, $prod_id, $prod_qty, $sub_total
            ));

            if ($insertProduct) {
                // ✅ ลบตะกร้าหลังสั่งซื้อ
                $del_sql = "DELETE FROM cart WHERE user_id = $1";
                $deleteCart = pg_query_params($con, $del_sql, array($user_id));

                if ($deleteCart) {
                    echo "<script>window.location.href='store.php'</script>";
                } else {
                    echo "❌ Error: ".pg_last_error($con);
                }
            } else {
                echo "❌ Error Insert order_products: ".pg_last_error($con);
            }
            $i++;
        }
    } else {
        echo "❌ Error Insert orders_info: ".pg_last_error($con);
    }

} else {
    echo "<script>window.location.href='index.php'</script>";
}
?>
