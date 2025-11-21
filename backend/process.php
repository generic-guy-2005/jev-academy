<?php
session_start();
include '../connection.php';

if (isset($_POST['sign-in'])) {
    $username = $_POST['user-sign-in'];
    $pass = $_POST['password-sign-in'];
    $hash = md5($pass);

    $sql = "SELECT * FROM users WHERE user_name='$username'";
    $query = $connection->query($sql);

    if ($query->num_rows === 0) {
        echo "
                <script> 
                    alert('User not found');
                    window.location.href = 'login.php';
                </script>
            ";
    } else {
        $data = $query->fetch_assoc();

        if ($hash == $data['user_password'] && $username == $data['user_name']) {
            $_SESSION['username'] = $data['user_name'];
            $_SESSION['id'] = $data['user_id'];
            $_SESSION['role'] = $data['user_role'];
            echo "<script>window.location.href = '../index.php';</script>";
        } else {
            echo "
                    <script>
                        alert('Username or password incorrect!');
                        window.location.href = '../login.php';
                    </script>
                ";
        }
    }
} elseif (isset($_POST['sign-up'])) {
    $newUser = $_POST['user-sign-up'];
    $newPass = $_POST['password-sign-up'];
    $newConfirm = $_POST['password-confirm'];
    $newRole = $_POST['role-selection'];

    $preventDouble = "SELECT user_name FROM users WHERE user_name LIKE '$newUser'";
    $execPrevention = $connection->query($preventDouble);

    if ($execPrevention->num_rows > 0) {
        echo "
                <script> 
                    alert('User already exist! Choose another name!');
                    window.location.href = '../login.php?view=signup';
                </script>
            ";
        exit();
    }

    if ($newPass != $newConfirm) {
        echo "
                <script> 
                    alert('Password doesn\'t match!');
                    window.location.href = '../login.php?view=signup';
                </script>
            ";
        exit();
    }

    $newHash = md5($newConfirm);
    $registUser = "INSERT INTO users(user_name, user_password, user_role) VALUES('$newUser', '$newHash', '$newRole')";
    $execRegistration = $connection -> query($registUser);

    if ($registUser === TRUE) {
        echo "
                    <script>
                        alert('You are ready!');
                        window.location.href = '../login.php';
                    </script>
                ";
    } else{
        echo "
                    <script>
                        alert('Something went wrong!');
                        window.location.href = '../login.php';
                    </script>
                ";
    }
}
