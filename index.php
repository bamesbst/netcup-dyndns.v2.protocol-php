<?php

// Load config
require_once 'config.php';
require_once 'api/dynamic-dns-netcup-modified-api/update.php';

// Register Result-Function
register_shutdown_function('giveResult');

// Authenticate service-user
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="DDNS Auth"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Access is not granted.';
    giveResult();
    exit;
} else {
    if ($_SERVER['PHP_AUTH_USER'] == SUSER && $_SERVER['PHP_AUTH_PW'] == SPASSWORD) {
        executeUpdate();
    } else {
        outputStdout("Wrong user-password-combination. Access is not granted.");
        define('IPV4RESULT', 'badauth');
    }
}

// Initiate the domain-update using the api-client
function executeUpdate() {
    outputStdout("Access granted!\n\n");
    outputStdout("=============================================");
    outputStdout("Running dynamic DNS client using the dyndns-v2-protocol for netcup 2.0");
    outputStdout("This script is not affiliated with netcup.");
    outputStdout("Author: Stefan Bamesberger");
    outputStdout("With usage of the api-client, created by: Lars-Sören Steck");
    outputStdout("=============================================\n");

    if (!isset($_GET["myip"])) {
        outputStdout("No ip defined.");
    } else {
        outputStdout("Processing ip-update");
        updateDomain($_GET["myip"]);
    }
}

// Return update-result and write logfile
function giveResult() {
    outputStdout("\n\nResult-Code is: ");
    if (defined('IPV4RESULT')) {
        if (LOG) {
            putLog(sprintf("%s - Result: %s - IP: %s \n", date(DATE_ATOM), IPV4RESULT, $_GET["myip"]));
        }

        echo IPV4RESULT;
    } else {
        if (LOG) {
            putLog(sprintf("%s - Error! - IP: %s \n", date(DATE_ATOM), $_GET["myip"]));
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            putLog(sprintf("---- Link: %s \n", $actual_link));
        }

        echo '911';
    }
}

function putLog($logtext) {
    file_put_contents('logfiles/main.log', $logtext, FILE_APPEND);
}