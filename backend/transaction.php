<?php
session_start();
include '../connection.php';
$current_user = $_SESSION['id'];

if (isset($_POST['top-up'])) {
    $id = $_POST['id'];
    $amount = $_POST['top-up-amount'];
    $pass = $_POST['top-up-pass'];
    $conf = $_POST['confirmation'];

    # Minimum Top Up
    if ($amount < 50000) {
        echo "
                <script> 
                    alert('Minimum allowed top is Rp50.000!');
                    window.location.href = '../index.php?page=payment/topup';
                </script>
            ";
        exit();
    }

    # Password Confirmation
    if ($pass !== $conf) {
        echo "
                <script> 
                    alert('Password doesn\'t match!');
                    window.location.href = '../index.php?page=payment/topup';
                </script>
            ";
        exit();
    }

    # Wallet Search
    $hash = md5($pass);
    $queryWallet = "SELECT wallet_id, wallet_user_id, user_id FROM wallet w, users u WHERE w.wallet_user_id = u.user_id";
    $execWallet = $connection -> query($queryWallet);
    $dataWallet = $execWallet -> fetch_assoc();

    $idWallet = $dataWallet['wallet_id'];
    $query_topup = "SELECT * FROM wallet w, users u WHERE w.wallet_user_id = '$current_user' AND u.user_password = '$hash'";
    $exec_topup = $connection->query($query_topup);

    if ($exec_topup->num_rows === 0) {
        echo "
                <script> 
                    alert('Something went wrong!');
                    window.location.href = 'index.php?page=payment/topup';
                </script>
            ";
        exit();
    } else {
        $query_trans = "INSERT INTO topup(topup_amount, topup_wallet_id) VALUES('$amount', '$idWallet')";
        $query_update_wallet = "UPDATE wallet SET wallet_balance = wallet_balance + $amount";
        $exec_trans = $connection->query($query_trans);
        $exec_update_wallet = $connection->query($query_update_wallet);

        if (!$exec_trans) {
            echo "
                <script> 
                    alert('Something went wrong!');
                    window.location.href = '../index.php?page=payment/topup';
                </script>
            ";
            exit();
        } else {
?>
            <script>
                alert('Top up success!');
                window.location.href = '../index.php?page=payment&id=<?= $id ?>';
            </script>
    <?php
        }
    }
} elseif (isset($_POST['pay-course'])) {
    $course = $_POST['course'];

    # Cost
    $query_cost = "SELECT c.course_id, c.course_cost, w.wallet_balance, w.wallet_id FROM courses AS c JOIN wallet AS w ON w.wallet_user_id = '$current_user' WHERE c.course_id = '$course'";

    $exec_cost = $connection->query($query_cost);
    $data_cost = $exec_cost->fetch_assoc();

    $cost = $data_cost['course_cost'];
    $balance = $data_cost['wallet_balance'];
    $wallet_id = $data_cost['wallet_id'];
    $course_id = $data_cost['course_id'];

    # Insufficent
    if ($balance < $cost) {
        echo "
            <script>
                alert('Insufficient balance!');
                window.location.href = '../index.php?page=payment&id=$course';
            </script>
        ";
        exit();
    }

    # Record transaction
    $query_pay = "INSERT INTO payment (payment_cost, payment_item, payment_wallet)
        VALUES ('$cost', '$course', '$wallet_id')
    ";

    # Hitamkan dompetnya
    $query_update = "UPDATE wallet
        SET wallet_balance = wallet_balance - $cost
        WHERE wallet_id = $wallet_id
    ";

    # Masokk
    $query_enroll = "INSERT INTO enrollment(enrollment_student_id, enrollment_course_id)
        VALUES ($current_user, $course);
    ";

    $connection->query($query_pay);
    $connection->query($query_update);
    $connection->query($query_enroll);
    ?>

    <script>
        alert('Payment success!');
        window.location.href = '../index.php?page=course/detail&id=<?= $course_id ?>';
    </script>

<?php
}
?>