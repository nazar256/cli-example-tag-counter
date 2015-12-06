#!/usr/bin/env php
<?php
require_once('sys/autoloader.php');
require_once('config/config.php');

$kernel = new Kernel();
$kernel
    ->boot()
    ->executeCommand();
