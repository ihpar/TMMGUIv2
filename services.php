<?php
    require_once("phglobals.pxp");
    error_reporting(E_ERROR | E_PARSE);
    try {
        $str_json = file_get_contents("php://input");
        $client_params = json_decode($str_json, true);

        $makam = $client_params["makam"];
        $notes = $client_params["notes"];

        $file_name = "";
        while(true) {
            $file_name = uniqid("TMM_ui_", true);
            if (!file_exists($downloads_dir . $file_name)) break;
        }
        $file_name = str_replace(".", "_", $file_name);
        $worker = "phpworker.py ";
        $worker_args = json_encode($file_name) . " " . json_encode($makam) . " " . json_encode($notes);
        $cmd = $venv_dir . "python " . $worker_dir . $worker . $worker_args;

        pclose(popen("start /b " . $cmd, "r"));

        $res = [
            "res" => "OK",
            "id" => $file_name
        ];

        echo(json_encode($res));

    } catch (Exception $e) {
        $res = [
            "res" => "ERR",
            "msg" => $e->getMessage()
        ];

        echo(json_encode($res));
    }
?>
