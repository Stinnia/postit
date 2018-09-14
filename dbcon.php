<?php
$DB_HOST = 'localhost';
$DB_USER = 'stinnia_com_postit';
$DB_PASS = 'Htc1sense';
$DB_NAME = 'stinnia_com_postit';
$DB_PORT = '3306';
//$link = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$link = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
if ($link->connect_error) { 
   die('Connect Error ('.$link->connect_errno.') '.$link->connect_error);
}
$link->set_charset('utf8'); 