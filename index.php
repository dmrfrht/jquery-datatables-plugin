<?php

require __DIR__ . '/connection.php';

$students = $db->query('SELECT * FROM students')->fetchAll(PDO::FETCH_ASSOC);

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
  <title>Jquery Datatables Eklentisi</title>
  <style>
    body {
      padding: 30px;
    }

    .lds-ring {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }

    .lds-ring div {
      box-sizing: border-box;
      display: block;
      position: absolute;
      width: 64px;
      height: 64px;
      margin: 8px;
      border: 8px solid #fff;
      border-radius: 50%;
      animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
      border-color: #fbbd08 transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
      animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
      animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
      animation-delay: -0.15s;
    }

    @keyframes lds-ring {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

    .my-search {
      margin-bottom: 15px;
    }

    .top,
    .bottom {
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>
<body>

<input id="search" type="text" placeholder="Öğrenci Ara." class="form-control my-search">

<table id="table" class="table table-bordered">
  <thead>
  <tr>
    <th>#ID</th>
    <th>Telefon Numarası</th>
    <th>Ad</th>
    <th>Soyad</th>
    <!--<th class="nosort">Email</th>-->
    <th>Email</th>
    <th class="nosort">İşlemler</th>
  </tr>
  </thead>
  <!--<tbody>
  <?php /*foreach ($students as $student): */ ?>
    <tr>
      <td>#<? /*= $student["student_id"]  */ ?></td>
      <td><? /*= $student["student_phone"] */ ?></td>
      <td data-search="id<? /*=$student['student_id']*/ ?>"><? /*= $student["student_name"] */ ?></td>
      <td><? /*= $student["student_surname"] */ ?></td>
      <td><? /*= $student["student_email"] */ ?></td>
    </tr>
  <?php /*endforeach; */ ?>
  </tbody>-->
</table>


<script>
  var table = $('#table').DataTable({
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, 75, 100, -1],
      ['10 Adet', '25 Adet', '50 Adet', '75 Adet', '100 Adet', "Tümü"]
    ],
    order: [
      [2, 'desc']
    ],
    language: {
      "sDecimal": ",",
      "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
      "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
      "sInfoEmpty": "Kayıt yok",
      "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
      "sInfoPostFix": "",
      "sInfoThousands": ".",
      "sLengthMenu": "Sayfada _MENU_ kayıt göster",
      "sLoadingRecords": "Yükleniyor...",
      "sProcessing": "<div class=\"lds-ring\"><div></div><div></div><div></div><div></div></div>",
      "sSearch": "Ara:",
      "sZeroRecords": "Eşleşen kayıt bulunamadı",
      "oPaginate": {
        "sFirst": "İlk",
        "sLast": "Son",
        "sNext": "Sonraki",
        "sPrevious": "Önceki"
      },
      "oAria": {
        "sSortAscending": ": artan sütun sıralamasını aktifleştir",
        "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
      },
      "select": {
        "rows": {
          "_": "%d kayıt seçildi",
          "0": "",
          "1": "1 kayıt seçildi"
        }
      }
    },
    columnDefs: [
      {
        targets: ['nosort'],
        orderable: false
      },
      {
        targets: [1],
        orderable: false
      },
      {
        // class="btn btn-xs btn-primary btn-outline"
        render: function (data, type, row) {
          var html = `<a href="mailto:${data}">${data}</a>`;
          return html;
        },
        targets: 4
      },
      {
        render: function (data, type, row) {
          /*var html = `
            <a href="edit.php?id=${row.student_id}" class="btn btn-outline-success btn-sm">Düzenle</a>
            <a href="delete.php?id=${row.student_id}" class="btn btn-outline-danger btn-sm">Sil</a>
          `;*/

          var html = '';
          $.each(row.actions, function (key, action) {
            html += `<a href="${action.url}" class="${action.class}">${action.title}</a> `;
          });

          return html;


        },
        targets: 5
      }
    ],
    processing: true,
    serverSide: true,
    ajax: {
      url: 'api.php',
      type: 'POST'
    },
    columns: [
      {data: 'student_id'},
      {data: 'student_phone'},
      {data: 'student_name'},
      {data: 'student_surname'},
      {data: 'student_email'}
    ],
    buttons: [
      'copy', 'csv',
      {
        extend: 'excel',
        title: 'Öğrenci Listesi',
        exportOptions: {
          columns: [0, 1, 2, 3, 4]
        }
      },
      {
        extend: 'pdf',
        title: 'Öğrenci Listesi',
        orientation:'landscape',
        customize: function (doc) {
          doc.content[1].table.widths =
            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
        },
        exportOptions: {
          columns: [0, 1, 2, 3, 4]
        }
      }
    ],
    dom: '<"top"lB>rt<"bottom"ip><"clear">',

  });

  $('#search').on('keyup', function () {
    table.search($(this).val()).draw();
  })
</script>

</body>
</html>