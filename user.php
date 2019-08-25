<?php
// session_start();
// require_once "db.php";
// header('Access-Control-Allow-Origin:*');
// echo '123';
$op = $_POST['option'] ? $_POST['option'] : '';

switch($op) {
    case 'registered':
        $account = $_POST['xaccount'];
        $pwd = $_POST['xpassword'];
        $name = $_POST['xname'];
        echo json_encode(registered($account, $pwd, $name));
        break;
    case 'userall':
        // userall();  
        $userid = $_POST['userid'];
        echo json_encode(userall($userid));
        break;
    case 'getBankData':
        // BankData();  
        echo json_encode(BankData());
        break;
    case 'getBankNtd':
        // BankNtd();
        echo json_encode(BankNtd());
        break;
    case 'delitem':
        $aset_id = $_POST['asetid'];
        echo json_encode(delitem($aset_id));
        break;
    case 'login':
        $ac = $_POST['account'];
        $ps = $_POST['password'];
        echo json_encode(login($ac,$ps));
        break;
    case 'postAsetItem':
        $member_id = $_POST['member_id'];
        $BANK = $_POST['Bank'];
        $NTD = $_POST['NTD'];
        $Item = $_POST['Item'];
        $Amount = $_POST['Amount'];
        $Rate = $_POST['Rate'];
        $Pdate = $_POST['Pdate'];
        $Edate = $_POST['Edate'];
        $Mark = $_POST['Mark'];
        echo json_encode(postAsetItem($member_id,$BANK,$NTD,$Item,$Amount,$Rate,$Pdate,$Edate,$Mark));
        break;
    // default:
    //     $account = $_POST['account'];
    //     $pwd = $_POST['password'];
    //     $name = $_POST['name'];
    //     echo json_encode(registered($account, $pwd, $name));
    //     break;
}
// function check($account){
//     require_once 'db.php';
//     $sql = "SELECT * FROM  `member` WHERE `account`= '{$account}'";
//     $res = $conn->query($sql);
//     $row = $res->num_rows;
//     $conn->close();
//     if ($row > 0) {
//         return false;
//     } else {
//         return true;
//     }
// }
function registered($account, $pwd, $name) {
    require_once "db.php";
    // if (check($account)) {
    //     $sql = "INSERT INTO  `member` (`account`, `password`, `nick_name`) VALUES ('$account', '$pwd', '$name')";
    //     $res = $conn->query($sql);
    //     $conn->close();
    //     $data = ['註冊成功'];
    // }
    $sql = "INSERT INTO  `member` (`account`, `password`, `nick_name`) VALUES ('$account', '$pwd', '$name')";
    $res = $conn->query($sql);
    $res = $conn->query($sql);
    $conn->close();
    $data = ['註冊成功'];
     return $data;
}
function postAsetItem($member_id,$BANK,$NTD,$Item,$Amount,$Rate,$Pdate,$Edate,$Mark) {
    require_once "db.php";
    $sql = "INSERT INTO  `AsetItem` (`member_id`,`BANK`,`NTD`,`Item`,`Amount`,`Rate`,`Pdate`,`Edate`,`Mark`) VALUES ('$member_id','$BANK','$NTD','$Item','$Amount','$Rate','$Pdate','$Edate','$Mark')";
    $res = $conn->query($sql);
    $conn->close();
    $data = ['設置成功'];
    return $data;
}
function login($ac, $ps) {
    require_once "db.php";
    $sql = "SELECT * FROM  `member` WHERE `account`= '{$ac}' AND `password`= '{$ps}'";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    if( $ac == $row['account'] && $ps == $row['password']){
        
        $_SESSION['acc']=$ac;
        $_SESSION['pss']=$ps;
        
        $data = [
           'type'=>'success',
           'msg'=>'登入成功',
           'account'=>$row['account'],
           'password'=>$row['password'],
           'userName'=>$row['nick_name'],
           'userId'=>$row['member_id'],
       ];
    }else{
        $data = [
            'type'=>'false',
        ];
    }
    $conn->close();
    // $data = $res;
    return $data;
}

function BankData(){
require_once "db.php";
$sql = "SELECT * FROM `bank`";
    $res = $conn->query($sql);
    $row = $res->fetch_all();
    $conn->close();
    return $row;
    // echo json_encode($row);
}
function userall($userid){
require_once "db.php";

$sql = "SELECT * FROM `asetitem` WHERE `member_id` = {$userid}";

    $res = $conn->query($sql);
    $row = $res->fetch_all();
    $conn->close();
    return $row;
    // echo json_encode($row);
}
function delitem($aset_id){
require_once "db.php";

    $sql = "DELETE FROM `asetitem`WHERE `Aset_id` ={$aset_id}";
    $res = $conn->query($sql);
    $row = $res->fetch_all();
    $conn->close();
    return $row;
}

function BankNtd(){
require_once "db.php"; 
$sql = "SELECT * FROM `ntd`";
    $res = $conn->query($sql);
    $row = $res->fetch_all();
    $conn->close();
    return $row;
    // echo json_encode($row);
}
?>