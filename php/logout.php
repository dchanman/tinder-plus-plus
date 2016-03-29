<?php
session_save_path("home/n/n4u8/php_sessions");
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: index.php"); // Redirecting To Home Page
}
?>