<?php

//sleep(2);
require __DIR__ . '/connection.php';

$sql = 'SELECT * FROM students ';
$where = [];

$order = ['student_id', 'DESC'];
$column = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$column]['data'];
$columnOrder = $_POST['order'][0]['dir'];

if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
  $order[0] = $columnName;
  $order[1] = $columnOrder;
}

if (!empty($_POST['search']['value'])) {
  foreach ($_POST['columns'] as $column) {
    $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%"';
  }
}

if (count($where) > 0) {
  $sql .= ' WHERE ' . implode(' || ', $where);
}

$sql .= ' ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';

if ($_POST['length'] != -1)
  $sql .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

$students = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$response = [];
$response['data'] = [];
$total = $db->query('SELECT count(student_id) as total FROM students')->fetch(PDO::FETCH_ASSOC);
$response['recordsTotal'] = $total['total'];
$response['recordsFiltered'] = $db->query('SELECT count(student_id) as total FROM students ' . (count($where) > 0 ? ' WHERE ' . implode(' || ', $where) : null))->fetch(PDO::FETCH_ASSOC)["total"];

foreach ($students as $student) {
  $response['data'][] = [
    'student_id' => $student['student_id'],
    'student_phone' => $student['student_phone'],
    'student_name' => $student['student_name'],
    'student_surname' => $student['student_surname'],
    'student_email' => $student['student_email'],
    'actions' => [
      [
        'title' => 'Düzenle',
        'url' => 'edit.php?id=' . $student['student_id'],
        'class' => 'btn btn-outline-success btn-sm'
      ],
      [
        'title' => 'Sil',
        'url' => 'delete.php?id=' . $student['student_id'],
        'class' => 'btn btn-outline-danger btn-sm'
      ]
    ]
  ];
}

echo json_encode($response);
