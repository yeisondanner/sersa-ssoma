let table;
window.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();
  toastr.options = {
    closeButton: true,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    progressBar: true,
    onclick: null,
  };
  setTimeout(() => {
    saveData();
    getDataFile();
  }, 1500);
});

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
    const url = base_url + "/Thread/set_file_on_thread";
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
        if (!data.status) {
          toastr[data.type](data.message, data.title);
          elementLoader.classList.add("d-none");
          return false;
        }
        //limpiar el formulario
        formSave.reset();
        //ocultar el modal abierto
        $("#modalSave").modal("hide");
        toastr[data.type](data.message, data.title);
        //recargar las funciones
        setTimeout(() => {
          //quitamos el d-none del elementLoader
          elementLoader.classList.add("d-none");
        }, 500);
        return true;
      })
      .catch((error) => {
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
//funcion que se encarga de obtener el nombre del archivo seleccionado
function getDataFile() {
  const txtName = document.getElementById("txtName");
  const flFile = document.getElementById("flFile");
  flFile.addEventListener("change", (e) => {
    //otbenemos el nombre pero sin la extension
    txtName.value = cleanNmaeFile(e.target.files[0].name.split(".")[0]);
  });
}
//funcion que limpia lo que se escribe
function cleanNmaeFile(nombre) {
  return nombre
    .replace(/[^a-zA-Z0-9 _-]/g, "") // elimina caracteres no permitidos
    .substring(0, 255);
}
