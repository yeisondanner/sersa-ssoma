let table;
window.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();
  loadTable();
  setTimeout(() => {
    // Aquí puedes agregar cualquier acción que desees realizar después de 1.5 segundos
    loadSelectProcess();
    loadSelectThreads();
    saveData();
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
      url: "" + base_url + "/Thread/getThreads",
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "mp_name" },
      { data: "p_name" },
      { data: "threads_father" },
      { data: "idThreads" },
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fa fa-file-excel-o'></i> Excel",
        title: "Reporte de gestion de subprocesos en Excel",
        className: "btn btn-success",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de gestion de subprocesos en CSV",
        className: "btn btn-info",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
            return `<span class="badge badge-danger" title="Subproceso tiene asignado un padre de id ${data}" onclick="alert('Subproceso tiene asignado un padre de id ${data}')" style="cursor:pointer;"><i class="fa fa-sitemap"></i>  ${data}</span>`;
          } else {
            return `<span class="badge badge-warning" title="Subproceso no tiene asignado un padre" onclick="alert('Subproceso no tiene asignado un padre, esto significa que es un subproceso raíz')" style="cursor:pointer;"><i class="fa fa-star"></i></span>`;
          }
        },
      },
      {
        targets: [4],
        orderable: true,
        className: "text-center",
        searchable: true,
        render: function (data, type, row) {
          //validamos que el campo no esté vacío
          if (data !== "" && data !== null) {
            return `<span class="badge badge-primary"><i class="fa fa-tag"></i>  ${data}</span>`;
          } else {
            return `<span class="badge badge-secondary">Sin ID</span>`;
          }
        },
      },
      {
        targets: [6],
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
        targets: [8],
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
        targets: [7],
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
        targets: [9, 10],
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
        targets: [11],
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
//Funcion que se encarga de obtener los procesos de acuerdo a la seleccion del macroproceso
function loadSelectProcess() {
  const slctMacroprocess = document.getElementById("slctMacroprocess");
  slctMacroprocess.addEventListener("change", function (e) {
    const selectedValue = this.value;
    elementLoader.classList.remove("d-none");
    // Realiza una solicitud fetch para obtener los procesos del macroproceso seleccionado
    fetch(`${base_url}/Process/getProcesesById?id=${selectedValue}`)
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
        // Aquí puedes llenar el select de procesos con los datos obtenidos y tambien el select que se va vaciar por si tengad datos asociados
        const slctProcess = document.getElementById("slctProcess");
        const slctSubProcess = document.getElementById("slctSubProcess");
        //validamos si el estado llega en false
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
          //limpiamos los selects
          slctProcess.innerHTML = "";
          slctSubProcess.innerHTML = "";
          elementLoader.classList.add("d-none");
          return false;
        }

        //limpiamos los selects
        slctProcess.innerHTML = "";
        slctSubProcess.innerHTML = "";
        data = data.data;
        //creamos un option primero que este sleccionado desactivado y sin valor y que seleccione un elemento
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "Seleccione un subproceso";
        defaultOption.disabled = true;
        defaultOption.selected = true;
        slctProcess.appendChild(defaultOption);
        data.forEach((process) => {
          const option = document.createElement("option");
          option.value = process.idProcess;
          option.textContent = process.p_name;
          slctProcess.appendChild(option);
        });
        elementLoader.classList.add("d-none");
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
//Funcion que se encarga de obtener los subproceso de acuerdo a la seleccion del proceso
function loadSelectThreads() {
  const slctProcess = document.getElementById("slctProcess");
  slctProcess.addEventListener("change", function (e) {
    const selectedValue = this.value;
    elementLoader.classList.remove("d-none");
    // Realiza una solicitud fetch para obtener los subprocesos del proceso seleccionado
    fetch(`${base_url}/Thread/getThreadsById?id=${selectedValue}`)
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
        // Aquí puedes llenar el select de subprocesos con los datos obtenidos
        const slctSubProcess = document.getElementById("slctSubProcess");
        //validamos si el estado llega en false
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
          //limpiamos los selects
          slctSubProcess.innerHTML = "";
          //creamos un option primero que este sleccionado desactivado y sin valor y que seleccione un elemento
          const defaultOption = document.createElement("option");
          defaultOption.value = "0";
          defaultOption.textContent = "Sin Subproceso Padre";
          defaultOption.selected = true;
          slctSubProcess.appendChild(defaultOption);
          elementLoader.classList.add("d-none");
          return false;
        }

        data = data.data;
        slctSubProcess.innerHTML = "";
        //creamos un option primero que este sleccionado desactivado y sin valor y que seleccione un elemento
        const defaultOption = document.createElement("option");
        defaultOption.value = "0";
        defaultOption.textContent = "Sin Subproceso Padre";
        defaultOption.selected = true;
        slctSubProcess.appendChild(defaultOption);
        data.forEach((thread) => {
          const option = document.createElement("option");
          option.value = thread.idThreads;
          if (thread.threads_father === null) {
            option.textContent = `${thread.t_name}`;
          } else {
            option.textContent = `Padre : ${thread.threads_father} - ${thread.t_name}`;
          }
          slctSubProcess.appendChild(option);
        });
        elementLoader.classList.add("d-none");
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
    const url = base_url + "/Thread/setThread";
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
        formSave.reset();
        //ocultar el modal abierto
        $("#modalSave").modal("hide");
        //actualizar la tabla
        table.ajax.reload(null, false);
        toastr[data.type](data.message, data.title);
        //recargar las funciones
        setTimeout(() => {
          //limpiamos los select
          const slctProcess = document.getElementById("slctProcess");
          const slctSubProcess = document.getElementById("slctSubProcess");
          slctProcess.innerHTML = "";
          slctSubProcess.innerHTML = "";

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
        elementLoader.classList.add("d-none");
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
        "¿Está seguro de eliminar el Subproceso <strong>" +
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
    const url = base_url + "/Thread/deleteThread";
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
