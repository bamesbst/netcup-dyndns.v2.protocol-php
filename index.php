<?php

// Load config
require_once 'config.php';
require_once 'api/dynamic-dns-netcup-modified-api/update.php';

// Register Result-Function
register_shutdown_function('giveResult');

// Authenticate service-user
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Access is not granted.';
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

// Return update-result
function giveResult() {
    outputStdout("\n\nResult-Code is: ");
    if (defined('IPV4RESULT')) {
        echo IPV4RESULT;
    } else {
        echo '911';
    }
}