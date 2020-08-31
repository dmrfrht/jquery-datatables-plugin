<?php


try {
  $db = new PDO('mysql:host=localhost;dbname=meb-mobil-login;charset=utf8', 'root', '');
} catch (PDOException $e) {
 die($e->getMessage());
}