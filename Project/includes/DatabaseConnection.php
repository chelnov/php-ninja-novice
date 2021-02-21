<?php
$pdo = new PDO('mysql:host=192.168.10.10;dbname=ijdb;charset=utf8', 'mocaradio', 'podo1212@');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);