<?php
require_once __DIR__ . '/init.php';
unset($_SESSION['user']);
session_regenerate_id(true);
header('Location: index.php'); exit;
