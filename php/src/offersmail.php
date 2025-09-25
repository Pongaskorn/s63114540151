<?php
session_start();
include "db.php";

if (isset($_POST["email"])) {
    $email = $_POST['email'];
    $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";

    if (empty($email)) {
        echo "
            <div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Please fill this field..!</b>
            </div>
        ";
        exit();
    } else {
        if (!preg_match($emailValidation, $email)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>This $email is not valid..!</b>
                </div>
            ";
            exit();
        }

        // 🔍 ตรวจสอบว่า email มีอยู่แล้วหรือยัง
        $sql = "SELECT email_id FROM email_info WHERE email = $1 LIMIT 1";
        $check_query = pg_query_params($con, $sql, array($email));

        if (!$check_query) {
            die("❌ Query failed: " . pg_last_error($con));
        }

        if (pg_num_rows($check_query) > 0) {
            echo "
                <div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Email Address is already available</b>
                </div>
            ";
            exit();
        } else {
            // 📝 เพิ่ม email ใหม่
            $insert_sql = "INSERT INTO email_info (email) VALUES ($1)";
            $insert_query = pg_query_params($con, $insert_sql, array($email));

            if ($insert_query) {
                echo "
                    <div class='alert alert-success'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <b>Thanks for subscribing</b>
                    </div>
                ";
            } else {
                echo "
                    <div class='alert alert-danger'>
                        <b>Error: " . pg_last_error($con) . "</b>
                    </div>
                ";
            }
        }
    }
}
?>
