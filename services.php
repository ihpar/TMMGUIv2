<?php
    error_reporting(E_ERROR | E_PARSE);
    try {
        $str_json = file_get_contents("php://input");
        $client_params = json_decode($str_json, true);

        $makam = $client_params["makam"];
        $notes = $client_params["notes"];

        $venv_dir = "D:/Deve/Pyt/TmmGui/venv/Scripts/";
        $worker_dir = "D:/Deve/Pyt/TmmGui/src/";
        $worker = "phpworker.py ";
        $worker_args = json_encode($makam) . " " . json_encode($notes);
        $cmd = $venv_dir . "python " . $worker_dir . $worker . $worker_args;

        pclose(popen("start /b " . $cmd, "r"));

        $res = [
            "res" => "OK",
            "makam" => $makam,
            "notes" => $notes
        ];

        echo(json_encode($res));

    } catch (Exception $e) {
        echo "error-exception-" . $e->getMessage();
    }
?>
