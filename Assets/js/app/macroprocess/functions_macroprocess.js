let table;
window.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();
  loadTable();
  setTimeout(() => {
    saveData();
    confirmationDelete();
    deleteData();
    loadDataUpdate();
    updateDate();
    loadReport();
    loadPermissionRol();
    senDataPermission();
  }, 1500);
});

// Función que carga la tabla con los datos
function loadTable() {
  table = $("#table").DataTable({
    aProcessing: true,
    aServerSide: true,
    ajax: {
      url: "" + base_url + "/Macroprocess/getMacroprocess",
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "r_name" },
      { data: "r_description" },
      { data: "status" },
      { data: "actions" },
    ],
    dom: "lBfrtip",
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fa fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary",
        exportOptions: {
          columns: [0, 1, 2, 3],
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fa fa-file-excel-o'></i> Excel",
        title: "Reporte de roles en Excel",
        className: "btn btn-success",
        exportOptions: {
          columns: [0, 1, 2, 3],
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de roles en CSV",
        className: "btn btn-info",
        exportOptions: {
          columns: [0, 1, 2, 3],
        },
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fa fa-file-pdf-o'></i> PDF",
        title: "Reporte de roles en PDF",
        className: "btn btn-danger",
        orientation: "vertical",
        pageSize: "LEGAL",
        exportOptions: {
          columns: [0, 1, 2, 3],
        },
      },
    ],
    columnDefs: [
      {
        targets: [0],
        orderable: true,
        className: "text-center",
        searchable: false,
      },
      {
        targets: [1],
        orderable: true,
        className: "text-center",
        searchable: true,
      },
      {
        targets: [2],
        orderable: true,
        className: "text-justify",
        searchable: true,
      },
      {
        targets: [3],
        orderable: true,
        className: "text-center",
        searchable: true,
      },
      {
        targets: [4],
        orderable: false,
        className: "text-center",
        searchable: false,
      },
    ],
    responsive: "true",
    bProcessing: true,
    destroy: true,
    iDisplayLength: 10,
    order: [[0, "asc"]],
    language: {
      url: base_url + "/Assets/js/libraries/Spanish-datatables.json",
    },
    fnDrawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-sm");
    },
  });
}
