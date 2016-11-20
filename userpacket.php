<?php
/**
 *
 */

define("USER_DIR", "c_users/");
define("INVALID_CREATION", 0);
define("VALID_CREATION", 1);
define("NON_NULL", "valid");

if (isset($_GET["mode"])) {
    $mode = $_GET["mode"];
    if (isset($_GET["username"])) {
        $username = $_GET["username"];
        if ($mode == "make" && isset($_GET["password"])) {
            $password = $_GET["password"];
            $success = make_user_packet($username, $password, NON_NULL);
            if ($success == INVALID_CREATION) {
                echo("User already created.");
            }
        } elseif ($mode == "del") {
            del_user_packet($username);
        }
    }
}

function del_user_packet($username) {
    $file_path = USER_DIR.$username.".json";
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

function add_user_mobile($username, $password) {
    $file_path = USER_DIR.$username.".json";
    if (!file_exists($file_path)) {
        $file = fopen($file_path, "w");
        $user_packet = json_decode($file);
        if ($user_packet.password == $password &&
            $user_packet.mobile == null) {
            // TODO add whole rebuild


        }
        fclose($file);
        return VALID_CREATION;
    } else {
        return INVALID_CREATION;
    }
}

function make_user_packet($username, $password, $main) {
    $file_path = USER_DIR.$username.".json";
    if (!file_exists($file_path)) {
        $file = fopen($file_path, "w");
        $n_user_packet = Array(
            "username" => $username,
            "password" => $password,
            "main" => $main,
            "mobile" => null
        );

        fwrite($file, json_encode($n_user_packet));
        fclose($file);
        return VALID_CREATION;
    } else {
        return INVALID_CREATION;
    }
}

function get_user_packet($username, $password) {
    $file = fopen(USER_DIR.$username.".json", "r+");
    $user_packet = json_decode($file);

    if ($user_packet && $user_packet.password == $password) {

    }
}

?>