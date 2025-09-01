window.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    const radios = document.querySelectorAll(".loader-radio");
    const labels = document.querySelectorAll(".loader-option");

    radios.forEach((radio) => {
      radio.addEventListener("change", function () {
        labels.forEach((label) => label.classList.remove("selected"));
        if (radio.checked) {
          radio.closest("label").classList.add("selected");
        }
      });
    });
    saveData();
  }, 500);
});

//funcion que se encarga de guarda en la tabla
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
    const url = base_url + "/System/setInfoGeneral";
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
        toastr[data.type](data.message, data.title);
        elementLoader.classList.add("d-none");
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
//Funcion que se encarga de previsualizar la imagen del logo
function previewLogo(event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById("logoPreview");
    output.src = reader.result;
    output.classList.remove("d-none");
  };
  reader.readAsDataURL(event.target.files[0]);
}
