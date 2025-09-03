let table;
window.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();
  loadTable();
  setTimeout(() => {
    saveData();
    loadDataUpdate();
    updateDate();
    loadReport();
    confirmationDelete();
    deleteData();
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
        orientation: "landscape",
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
      {
        targets: [6],
        orderable: false,
        searchable: false,
        className: "text-center",
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
      loadDataUpdate();
      loadReport();
      confirmationDelete();
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
        //librerias de alertas
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
          elementLoader.classList.add("d-none");
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
          loadDataUpdate();
          loadReport();
          confirmationDelete();
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
//funcion que se encarga de mostrar el modal para actualizar los datos deel macroproceso
function loadDataUpdate() {
  const btnUpdateItem = document.querySelectorAll(".update-item");
  btnUpdateItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      //quitamos el d-none del elementLoader
      elementLoader.classList.remove("d-none");
      //obtenemos los atributos del btn update y los almacenamos en una constante
      const id = item.getAttribute("data-id");
      const name = item.getAttribute("data-name");
      const description = item.getAttribute("data-description");
      const status = item.getAttribute("data-status");
      //asignamos los valores obtenidos a los inputs del modal
      document.getElementById("update_txtId").value = id;
      document.getElementById("update_txtName").value = name;
      document.getElementById("update_txtDescription").value = description;
      document.getElementById("update_slctStatus").value = status;
      setTimeout(() => {
        //quitamos el d-none del elementLoader
        elementLoader.classList.add("d-none");
      }, 500);
      //abrir el modal
      $("#modalUpdate").modal("show");
    });
  });
}
//funcion que actualiza los datos del macroproceso enviandolos al servidor
function updateDate() {
  const formUpdate = document.getElementById("formUpdate");
  formUpdate.addEventListener("submit", (e) => {
    //enviamos el formulario por metodo PUT con todo archivo de imagen
    e.preventDefault();
    const formData = new FormData(formUpdate);
    const header = new Headers();
    const config = {
      method: "POST",
      headers: header,
      node: "no-cache",
      cors: "cors",
      body: formData,
    };
    const url = base_url + "/Macroprocess/updateMacroprocess";
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
          elementLoader.classList.add("d-none");
          return false;
        }
        //limpiar el formulario
        formUpdate.reset();
        //ocultar el modal abierto
        $("#modalUpdate").modal("hide");
        //actualizar la tabla
        table.ajax.reload(null, false);
        toastr[data.type](data.message, data.title);
        //recargar las funciones
        setTimeout(() => {
          loadDataUpdate();
          loadReport();
          confirmationDelete();
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
//Funcion que carga los datos en el reporte del modal del macroproceso
function loadReport() {
  const btnReportItem = document.querySelectorAll(".report-item");
  btnReportItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      //quitamos el d-none del elementLoader
      elementLoader.classList.remove("d-none");
      ///obtenemos los atributos del btn update y los almacenamos en una constante
      const id = item.getAttribute("data-id");
      const name = item.getAttribute("data-name");
      const description = item.getAttribute("data-description");
      const dataStatus = item.getAttribute("data-status");
      const dataRegistrationDate = item.getAttribute("data-registration");
      const dataUpdateDate = item.getAttribute("data-update");
      //asignamos los valores obtenidos a los inputs del modal
      document.getElementById("reportTitle").innerHTML = name;
      document.getElementById("reportCode").innerHTML = "#" + id;
      document.getElementById("reportDescription").innerHTML = description;
      document.getElementById("reportEstado").innerHTML = dataStatus;
      document.getElementById("reportRegistrationDate").innerHTML =
        dataRegistrationDate;
      document.getElementById("reportUpdateDate").innerHTML = dataUpdateDate;
      //quitamos el d-none del elementLoader
      elementLoader.classList.add("d-none");
      //abrimos el modal
      $("#modalReport").modal("show");
    });
  });
}
// Función que confirma la eliminación
function confirmationDelete() {
  const arrBtnDeleteItem = document.querySelectorAll(".delete-item");
  arrBtnDeleteItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      //obtenemos los atributos del btn delete y los almacenamos en una constante
      const name = item.getAttribute("data-name");
      const id = item.getAttribute("data-id");
      //Preguntamos en el modal si esta seguro de eliminar el registro
      document.getElementById("txtDelete").innerHTML =
        "¿Está seguro de eliminar el Macroproceso <strong>" +
        name +
        " </strong>?";
      //Asiganamos los valores obtenidos y los enviamos a traves de un atributo dentro del btn de confirmacion de eliminar
      const confirmDelete = document.getElementById("confirmDelete");
      confirmDelete.setAttribute("data-id", id);
      confirmDelete.setAttribute("data-name", name);
      //abrimos el modal de confirmacion
      $("#confirmModalDelete").modal("show");
    });
  });
}
// Función que se encarga de eliminar un registro
function deleteData() {
  const confirmDelete = document.getElementById("confirmDelete");
  confirmDelete.addEventListener("click", (e) => {
    e.preventDefault();
    //recibimos las variables del atributo del btn de confirmacion de eliminar en sus constantes
    const id = confirmDelete.getAttribute("data-id");
    const name = confirmDelete.getAttribute("data-name");
    const token = confirmDelete.getAttribute("data-token");
    //creamos un array con los valores recuperados
    const arrValues = {
      id: id,
      name: name,
      token: token,
    };
    const header = { "Content-Type": "application/json" };
    const config = {
      method: "DELETE",
      headers: header,
      body: JSON.stringify(arrValues),
    };
    //La ruta donde se apunta del controlador
    const url = base_url + "/Macroprocess/deleteMacroprocess";
    //quitamos el d-none del elementLoader
    elementLoader.classList.remove("d-none");
    fetch(url, config)
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Error en la solicitud" +
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
          elementLoader.classList.add("d-none");
          return false;
        }
        //ocultar el modal abierto
        $("#confirmModalDelete").modal("hide");
        //actualizar la tabla
        table.ajax.reload(null, false);
        toastr[data.type](data.message, data.title);
        ///recargar las funciones
        setTimeout(() => {
          confirmationDelete();
          loadDataUpdate();
          loadReport();
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
        elementLoader.classList.add("d-none");
      });
  });
}
