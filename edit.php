<?php

require __DIR__ . '/connection.php';

$id = $_GET["id"];

$student_info = $db->query('SELECT * FROM students WHERE student_id = ' . $id)->fetch(PDO::FETCH_ASSOC);

?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-colvis-1.6.3/b-html5-1.6.3/b-print-1.6.3/datatables.min.css"/>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript"
          src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-colvis-1.6.3/b-html5-1.6.3/b-print-1.6.3/datatables.min.js"></script>
  <title><?= $student_info['student_name'] . ' ' . $student_info['student_surname'] ?></title>
  <style>
    body {
      padding: 40px;
    }
  </style>
</head>
<body>

<table class="table table-bordered table-striped table-hovered">
  <thead>
  <tr>
    <th>ID</th>
    <th>Ad</th>
    <th>Soyad</th>
    <th>Email</th>
    <th>Telefon Numarası</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><?= $student_info['student_id'] ?></td>
    <td><?= $student_info['student_name'] ?></td>
    <td><?= $student_info['student_surname'] ?></td>
    <td><?= $student_info['student_email'] ?></td>
    <td><?= $student_info['student_phone'] ?></td>
  </tr>
  </tbody>
</table>

</body>
</html>
