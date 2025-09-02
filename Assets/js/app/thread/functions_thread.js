let table;
window.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();
  loadTable();
  setTimeout(() => {
    // Aquí puedes agregar cualquier acción que desees realizar después de 1.5 segundos
  }, 1500);
});

// Función que carga la tabla con los datos
function loadTable() {
  table = $("#table").DataTable({
    aProcessing: true,
    aServerSide: true,
    ajax: {
      url: "" + base_url + "/Thread/getThreads",
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "mp_name" },
      { data: "p_name" },
      { data: "threads_father" },
      { data: "t_name" },
      { data: "t_description" },
      { data: "t_type" },
      { data: "t_status" },
      { data: "t_registrationDate" },
      { data: "t_updateDate" },
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fa fa-file-excel-o'></i> Excel",
        title: "Reporte de gestion de subprocesos en Excel",
        className: "btn btn-success",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de gestion de subprocesos en CSV",
        className: "btn btn-info",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        },
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fa fa-file-pdf-o'></i> PDF",
        title: "Reporte de gestion de subprocesos en PDF",
        className: "btn btn-danger",
        orientation: "landscape",
        pageSize: "LEGAL",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
        className: "text-left",
        searchable: true,
        render: function (data, type, row) {
          //hacemos que se muestre en un bagde con un icono de university
          return `<span class="badge badge-primary"><i class="fa fa-university"></i>  ${data}</span>`;
        },
      },
      {
        targets: [2],
        orderable: true,
        className: "text-left",
        searchable: true,
        render: function (data, type, row) {
          //hacemos que se muestre en un bagde con un icono de university
          return `<span class="badge badge-info"><i class="fa fa-bookmark"></i>  ${data}</span>`;
        },
      },
      {
        targets: [3],
        orderable: true,
        className: "text-center",
        searchable: true,
        render: function (data, type, row) {
          //validamos que si el valor es vacio y si no
          if (data !== "" && data !== null) {
            return `<span class="badge badge-danger"><i class="fa fa-sitemap"></i>  ${data}</span>`;
          } else {
            return `<span class="badge badge-warning"><i class="fa fa-star"></i></span>`;
          }
        },
      },
      {
        targets: [5],
        orderable: true,
        className: "text-justify",
        searchable: true,
        render: function (data, type, row) {
          //validamos que el campo no esté vacío
          if (data !== "" && data !== null) {
            return data;
          } else {
            return `<span class="badge badge-secondary">Sin descripción</span>`;
          }
        },
      },
      {
        targets: [7],
        orderable: true,
        className: "text-center",
        searchable: true,
        render: function (data, type, row) {
          //validamos que el campo no esté vacío
          if (data !== "" && data !== null) {
            //validamos cuando es Activo e Inactivo
            if (data === "Activo") {
              return `<span class="badge badge-success">${data}</span>`;
            } else {
              return `<span class="badge badge-danger">${data}</span>`;
            }
          } else {
            return `<span class="badge badge-secondary">Sin estado</span>`;
          }
        },
      },
      {
        targets: [6],
        className: "text-center",
        render: function (data, type, row) {
          //validamos que el campo no esté vacío
          if (data !== "" && data !== null) {
            //agregamos un icono de acuerdo al tipo open_menu,open_form,open_file
            if (data === "open_menu") {
              return `<span class="badge badge-primary"><i class="fa fa-bars"></i> ${data}</span>`;
            } else if (data === "open_form") {
              return `<span class="badge badge-success"><i class="fa fa-pencil"></i> ${data}</span>`;
            } else if (data === "open_file") {
              return `<span class="badge badge-info"><i class="fa fa-file"></i> ${data}</span>`;
            } else {
              return `<span class="badge badge-secondary"><i class="fa fa-exclamation"></i> ${data}</span>`;
            }
          } else {
            return `<span class="badge badge-secondary">No definido</span>`;
          }
        },
      },
      {
        targets: [8, 9],
        orderable: false,
        className: "text-center",
        searchable: false,
        render: function (data, type, row) {
          //validamos que el campo no esté vacío
          if (data !== "" && data !== null) {
            //agregamos un icono de fechas
            return `<i class="fa fa-calendar text-info"></i> ${data}`;
          } else {
            return `<span class="badge badge-secondary">Sin fecha</span>`;
          }
        },
      },
      {
        targets: [10],
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
