let table;
window.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();
  loadTable();
  setTimeout(() => {
    saveData();
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
      { data: "mp_name" },
      { data: "mp_description" },
      { data: "mp_status" },
      { data: "mp_registrationDate" },
      { data: "mp_updateDate" },
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
          columns: [0, 1, 2, 3, 4, 5],
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fa fa-file-excel-o'></i> Excel",
        title: "Reporte de gestion de macroprocesos en Excel",
        className: "btn btn-success",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de gestion de macroprocesos en CSV",
        className: "btn btn-info",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fa fa-file-pdf-o'></i> PDF",
        title: "Reporte de gestion de macroprocesos en PDF",
        className: "btn btn-danger",
        orientation: "vertical",
        pageSize: "LEGAL",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
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
      },
      {
        targets: [2],
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
        targets: [3],
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
        targets: [4, 5],
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
// Función que guarda los datos en la base de datos
function saveData() {
  const formSave = document.getElementById("formSave");
  formSave.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(formSave);
    const header = new Headers();
    const config = {
      method: "POST",
      headers: header,
      node: "no-cache",
      cors: "cors",
      body: formData,
    };
    const url = base_url + "/Macroprocess/setMacroprocess";
    //quitamos el d-none del elementLoader
    elementLoader.classList.remove("d-none");
    fetch(url, config)
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Error en la solicitud " +
              response.status +
              " - " +
              response.statusText
          );
        }
        return response.json();
      })
      .then((data) => {
        toastr.options = {
          closeButton: true,
          onclick: null,
          showDuration: "300",
          hideDuration: "1000",
          timeOut: "5000",
          progressBar: true,
          onclick: null,
        };
        if (!data.status) {
          toastr[data.type](data.message, data.title);
          return false;
        }
        //limpiar el formulario
        formSave.reset();
        //ocultar el modal abierto
        $("#modalSave").modal("hide");
        //actualizar la tabla
        table.ajax.reload(null, false);
        toastr[data.type](data.message, data.title);
        //recargar las funciones
        setTimeout(() => {
          //quitamos el d-none del elementLoader
          elementLoader.classList.add("d-none");
        }, 500);
        return true;
      })
      .catch((error) => {
        toastr.options = {
          closeButton: true,
          timeOut: 0,
          onclick: null,
        };
        toastr["error"](
          "Error en la solicitud al servidor: " +
            error.message +
            " - " +
            error.name,
          "Ocurrio un error inesperado"
        );
      });
  });
}
