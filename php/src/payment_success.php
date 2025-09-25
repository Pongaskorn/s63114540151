<?php
session_start();
if (!isset($_SESSION["uid"])) {
    header("location:index.php");
    exit();
}

if (isset($_GET["st"])) {
    $trx_id = $_GET["tx"];
    $p_st = $_GET["st"];
    $amt = $_GET["amt"];
    $cc = $_GET["cc"];
    $cm_user_id = $_GET["cm"];
    $c_amt = isset($_COOKIE["ta"]) ? $_COOKIE["ta"] : 0;

    if ($p_st == "Completed") {
        include_once("db.php");

        // ดึงข้อมูลสินค้าจากตะกร้า
        $sql = "SELECT p_id, qty FROM cart WHERE user_id = $1";
        $query = pg_query_params($con, $sql, array($cm_user_id));

        if ($query && pg_num_rows($query) > 0) {
            $product_id = [];
            $qty = [];

            while ($row = pg_fetch_assoc($query)) {
                $product_id[] = $row["p_id"];
                $qty[] = $row["qty"];
            }

            // บันทึกลง orders
            for ($i = 0; $i < count($product_id); $i++) {
                $insert_sql = "INSERT INTO orders (user_id, product_id, qty, trx_id, p_status) 
                               VALUES ($1, $2, $3, $4, $5)";
                pg_query_params($con, $insert_sql, array($cm_user_id, $product_id[$i], $qty[$i], $trx_id, $p_st));
            }

            // ลบ cart หลัง checkout เสร็จ
            $del_sql = "DELETE FROM cart WHERE user_id = $1";
            $del_query = pg_query_params($con, $del_sql, array($cm_user_id));

            if ($del_query) {
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Khan Store</title>
                    <link rel="stylesheet" href="css/bootstrap.min.css"/>
                    <script src="js/jquery2.js"></script>
                    <script src="js/bootstrap.min.js"></script>
                    <script src="main.js"></script>
                    <style>
                        table tr td {padding:10px;}
                    </style>
                </head>
                <body>
                    <div class="navbar navbar-inverse navbar-fixed-top">
                        <div class="container-fluid">    
                            <div class="navbar-header">
                                <a href="#" class="navbar-brand">Khan Store</a>
                            </div>
                            <ul class="nav navbar-nav">
                                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                                <li><a href="profile.php"><span class="glyphicon glyphicon-modal-window"></span> Product</a></li>
                            </ul>
                        </div>
                    </div>
                    <p><br/></p>
                    <p><br/></p>
                    <p><br/></p>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading"></div>
                                    <div class="panel-body">
                                        <h1>Thank you</h1>
                                        <hr/>
                                        <p>Hello <?php echo "<b>".$_SESSION["name"]."</b>"; ?>,
                                        Your payment process is successfully completed and your Transaction id is 
                                        <b><?php echo htmlspecialchars($trx_id); ?></b><br/>
                                        You can continue your Shopping <br/></p>
                                        <a href="index.php" class="btn btn-success btn-lg">Continue Shopping</a>
                                    </div>
                                    <div class="panel-footer"></div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </body>
                </html>
                <?php
            }
        } else {
            header("location:index.php");
            exit();
        }
    }
}
?>
