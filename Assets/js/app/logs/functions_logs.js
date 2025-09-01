let table;
window.addEventListener("load", () => {
  loadTable();
  setTimeout(() => {
    loadReport();
    filterTable();
    clearFilters();
  }, 500);
});
//Funcion que se encarga de listar la tabla
function loadTable() {
  table = $("#table").DataTable({
    aProcessing: true,
    aServerSide: true,
    ajax: {
      url: "" + base_url + "/Logs/getLogs",
      data: function (d) {
        // Se agrega el parámetro del filtro al objeto que se envía al servidor
        d.filterType = $("#filter-type").val();
        d.minData = $("#min-datetime").val();
        d.maxData = $("#max-datetime").val();
      },
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "l_title" },
      { data: "tl_name" },
      { data: "u_fullname" },
      { data: "l_registrationDate" }, // Fecha con hora
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
          columns: [1, 2, 3, 4],
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fa fa-file-excel-o'></i> Excel",
        title: "Reporte de logs en Excel",
        className: "btn btn-success",
        exportOptions: {
          columns: [1, 2, 3, 4],
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de logs en CSV",
        className: "btn btn-info",
        exportOptions: {
          columns: [1, 2, 3, 4],
        },
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fa fa-file-pdf-o'></i> PDF",
        title: "Reporte de logs en PDF",
        className: "btn btn-danger",
        orientation: "vertical",
        pageSize: "LEGAL",
        exportOptions: {
          columns: [1, 2, 3, 4],
        },
      },
    ],
    columnDefs: [
      {
        targets: [0, 5],
        className: "text-center",
        searchable: false,
      },
      {
        targets: [1, 3, 4],
        className: "text-left",
      },
      {
        targets: [2],
        className: "text-center",
        //hacemos que camvie el color del texto dependiendo del tipo de log con badge
        render: function (data, type, row) {
          if (row.tl_name == "Error") {
            return `<span class="badge badge-danger">${data}</span>`;
          } else if (row.tl_name == "Correcto") {
            return `<span class="badge badge-success">${data}</span>`;
          } else if (row.tl_name == "Información") {
            return `<span class="badge badge-info">${data}</span>`;
          } else {
            return data;
          }
        },
      },
    ],
    responsive: true,
    bProcessing: true,
    bDestroy: true,
    iDisplayLength: 100,
    order: [[0, "asc"]],
    language: {
      url: base_url + "/Assets/js/libraries/Spanish-datatables.json",
    },
    //hacemos que se recarguen funciones externas al modificar cualquier dato de la tabla o accion
    fnDrawCallback: function () {
      loadReport();
    },
  });
}
//Funcion que carga los datos en el reporte del modal del usuario
function loadReport() {
  const btnReportItem = document.querySelectorAll(".report-item");
  btnReportItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      //quitamos el d-none del elementLoader
      elementLoader.classList.remove("d-none");
      e.preventDefault();
      //creamos las constantes que capturar los datos de los atributos del boton
      const idLog = item.getAttribute("data-id");
      const title = item.getAttribute("data-title");
      const description = item.getAttribute("data-description");
      const registrationDate = item.getAttribute("data-registrationdate");
      const updateDate = item.getAttribute("data-updatedate");
      const type = item.getAttribute("data-type");
      const fullname = item.getAttribute("data-fullname");
      const email = item.getAttribute("data-email");
      const user = item.getAttribute("data-user");
      //obtene los elementos del modal donde se cargaran los datos
      const reportTitle = document.getElementById("reportTitle");
      const reportCode = document.getElementById("reportCode");
      const reportType = document.getElementById("reportType");
      const reportDescription = document.getElementById("reportDescription");
      const reportFullname = document.getElementById("reportFullname");
      const reportUser = document.getElementById("reportUser");
      const reportEmail = document.getElementById("reportEmail");
      const reportRegistrationDate = document.getElementById(
        "reportRegistrationDate"
      );
      const reportUpdateDate = document.getElementById("reportUpdateDate");
      //asignamos los valores a los elementos del modal
      reportTitle.innerHTML = title;
      reportCode.innerHTML = "#" + idLog;
      reportType.innerHTML = type;
      reportDescription.innerHTML = description
        .replaceAll("|", '"')
        .replaceAll("¬", "'");
      reportFullname.innerHTML = fullname;
      reportUser.innerHTML = user;
      reportEmail.innerHTML = email;
      reportRegistrationDate.innerHTML = registrationDate;
      reportUpdateDate.innerHTML = updateDate;
      setTimeout(() => {
        //add el d-none del elementLoader
        elementLoader.classList.add("d-none");
      }, 500);
      //abrimos el modal
      $("#modalReport").modal("show");
    });
  });
}
//Function que filtra los datos de la tabla
function filterTable() {
  const filterBtn = document.getElementById("filter-btn");
  filterBtn.addEventListener("click", () => {
    //obtenemos los valores de los inputs de la fechas
    const minDate = document.getElementById("min-datetime").value;
    const maxDate = document.getElementById("max-datetime").value;
    //validamos los campos vacios
    if (minDate == "" || maxDate == "") {
      toastr.options = {
        closeButton: true,
        timeOut: 0,
        onclick: null,
      };
      toastr["error"](
        "Debe llenar los campos de fecha",
        "Ocurrio un error inesperado"
      );
      return false;
    }
    //validamos que la fecha maxima sea mayor a la fecha minima
    if (minDate > maxDate) {
      toastr.options = {
        closeButton: true,
        timeOut: 0,
        onclick: null,
      };
      toastr["error"](
        "La fecha minima no debe ser mayor que la fecha maxima",
        "Ocurrio un error inesperado"
      );
      return false;
    }
    table.ajax.reload();
  });
}
//Funcion que limpiar los campos de los filtros
function clearFilters() {
  const clearBtn = document.getElementById("reset-btn");
  clearBtn.addEventListener("click", () => {
    document.getElementById("min-datetime").value = "";
    document.getElementById("max-datetime").value = "";
    table.ajax.reload();
    toastr.options = {
      closeButton: true,
      timeOut: 0,
      onclick: null,
    };
    toastr["success"]("Filtros limpiados correctamente", "Filtros limpiados");
  });
}
