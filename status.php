<?php
    require_once("phglobals.php");
    error_reporting(E_ERROR | E_PARSE);
    try {
        $str_json = file_get_contents("php://input");
        $client_params = json_decode($str_json, true);

        $makam = $client_params["makam"];
        $file_name = $client_params["fileName"];

        $lines = explode("\n", file_get_contents($downloads_dir . $file_name . ".txt"));
        $last_line = end($lines);
        if(str_contains($last_line, "ERR")) {
            $res = [
                "state" => "ERR",
                "status" => $last_line
            ];
            echo(json_encode($res));
        } else {
            if(str_contains($last_line, "mu2")) {
                $mu2_name = $makam . "-" . $file_name . ".mu2";
                copy($downloads_dir . $mu2_name, $mu2_name);
            }
            $res = [
                "state" => "OK",
                "status" => $last_line
            ];
            echo(json_encode($res));
        }

    } catch (Exception $e) {
        $res = [
            "state" => "ERR",
            "msg" => $e->getMessage()
        ];

        echo(json_encode($res));
    }
?>
