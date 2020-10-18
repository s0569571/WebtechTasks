<?php
session_start();

$chatters[] = $_SESSION['idPerson1'];
$chatters[] = $_SESSION['idPerson2'];
$chatters[] = $_SESSION['idPerson3'];

function getSenderName($elemId){
    if($elemId == $_SESSION['idPerson1']){
        return $_SESSION['person1'];
    }elseif($elemId == $_SESSION['idPerson2']){
        return $_SESSION['person2'];
    }elseif($elemId == $_SESSION['idPerson3']){
        return $_SESSION['person3'];
    }
}

function sendResponse($elemId, $msg){
    global $chatters;
    $receiver;
    if($elemId != $chatters[0]){
        $receiver[] = $chatters[0];
    }
    if($elemId != $chatters[1]){
        $receiver[] = $chatters[1];
    }
    if($elemId != $chatters[2]){
        $receiver[] = $chatters[2];
    }
    $response = array('sender' => getSenderName($elemId), 'firstElement' => "$receiver[0]", 'secondElement' => "$receiver[1]", 
        "zweiPersonen" => $_SESSION['zweiPersonen'], 'msg' => $msg);
    echo json_encode($response);
}

$requestHeader = apache_request_headers();
if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['element']) && isset($_POST['msg'])){
        $elem = filter_input(INPUT_POST, 'element');
        $msg = filter_input(INPUT_POST, 'msg');
        $elemId = preg_replace('/[^0-9]/', '', $elem);
        sendResponse($elemId, $msg);
    }
}

if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['session'])){
        $param = filter_input(INPUT_POST, 'session');
        if($param == "end"){
            session_unset();
        }
    }
}