<?php

session_start();
// 跨域
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

// 控制
$element = isset($_REQUEST['element']) ? $_REQUEST['element'] : '';

switch ($element) {
    case 'signup':
        $userName = isset($_REQUEST['userName']) ? $_REQUEST['userName'] : '';
        $account = isset($_REQUEST['account']) ? $_REQUEST['account'] : '';
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
        $rePassword = isset($_REQUEST['rePassword']) ? $_REQUEST['rePassword'] : '';
        echo json_encode(signUp($userName, $account, $password, $rePassword));
        break;
    case 'login':
        $account = isset($_REQUEST['account']) ? $_REQUEST['account'] : '';
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
        echo json_encode(login($account, $password));
        break;
    case 'checkLogin':
        echo json_encode(checkSession());
        break;
    case 'logout':
        echo json_encode(logout());
        break;
    case 'checkSignUp':
        $account = isset($_REQUEST['account']) ? $_REQUEST['account'] : '';
        echo json_encode(checkSignUpAccount($account));
        break;
    default:
        break;
}

function signUp($userName, $account, $pwd, $rePassword)
{
    if ($pwd !== $rePassword) {
        $data = [
            'type' => '',
            'msg' => '密碼與確認密碼不相同!!',
        ];

        return $data;
    }
    $conn = connectDB();
    $sql = "INSERT INTO `user` (`user_account`, `user_password`, `user_name`)
            VALUES ('{$account}', '{$pwd}', '{$userName}')";
    if ($conn->query($sql) === true) {
        $data = [
            'type' => 'success',
            'msg' => '註冊成功',
            'account' => $account,
            'password' => $pwd,
            'userName' => $userName,
        ];

        return $data;
    } else {
        $data = [
            'type' => 'failed',
            'msg' => '註冊失敗',
        ];

        return $data;
    }
}
function checkSignUpAccount($authData)
{
    $conn = connectDB();
    $sql = "SELECT * FROM `user` WHERE `user_account` = '{$authData}'";
    $res = $conn->query($sql);
    $row = $res->fetch_array();
    if ($row['user_account'] == $authData) {
        $data = [
            'type' => 'is-invalid',
            'msg' => '此帳號已有人使用',
        ];

        return $data;
    } else {
        $data = [
            'type' => 'is-valid',
            'msg' => '此帳號可以使用',
        ];

        return $data;
    }
}
function login($account, $pwd)
{
    $conn = connectDB();
    $sql = "SELECT * FROM `user` WHERE `user_account` = '{$account}' AND `user_password` = '{$pwd}'";
    $res = $conn->query($sql);
    $row = $res->fetch_array();
    if ($account == $row['user_account'] && $pwd == $row['user_password']) {
        $_SESSION['account'] = $account;
        $_SESSION['userName'] = $row['user_name'];
        $data = [
            'type' => 'success',
            'msg' => '登入成功',
            'account' => $row['user_account'],
            'password' => $row['user_password'],
            'userName' => $row['user_name'],
        ];

        return $data;
    } else {
        $data = [
            'type' => 'failed',
            'msg' => '登入失敗',
        ];

        return $data;
    }
}
function checkSession()
{
    if (isset($_SESSION['account']) && isset($_SESSION['userName'])) {
        $data = [
            'isLogin' => true,
            'msg' => '登入中',
            'userName' => $_SESSION['userName'],
        ];

        return $data;
    } else {
        $data = [
            'isLogin' => false,
            'msg' => '尚未登入',
        ];

        return $data;
    }
}
function logout()
{
    session_destroy();
    $data = [
        'isLogin' => false,
        'msg' => '已登出',
    ];

    return $data;
}
function connectDB()
{
    // $servername = 'ah-zheng.com';
    // $username = 'ahzheng_myworks';
    // $password = '@J1e2r3r4y5y6';
    // $dbname = 'ahzheng_myworks';
    $servername = '127.0.0.1';
    $username = 'root';
    $password = '';
    $dbname = 'test';

    $conn = new Mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8');

    return $conn;
}
