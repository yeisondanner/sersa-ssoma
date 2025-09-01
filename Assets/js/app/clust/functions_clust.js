const container_files = document.getElementById("container_files");
const folder_container = document.getElementById("folder_container");
const file_container = document.getElementById("file_container");
//menu toggle
document.getElementById("menu-toggle").addEventListener("click", function () {
  document.getElementById("sidebarClust").classList.toggle("active");
});
document.getElementById("menu-close").addEventListener("click", closeMenu);
function closeMenu() {
  document.getElementById("sidebarClust").classList.toggle("active");
}
//carga el DOM
document.addEventListener("DOMContentLoaded", function () {
  loadFiles();
  setTimeout(function () {
    // Código a ejecutar después de 1 segundo
    saveFolder();
  }, 1000);
});
//funcion para cargar los archivos y carpetas
function loadFiles() {
  const container_files = document.getElementById("container_files");
  const url = base_url + "/Clust/getFiles";
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      //mostramos todas la carpetas y archivos cargadas
      folders = data.folders;
      files = data.files;

      //validamos que los arrays no esten vacios
      if (folders.length === 0 && files.length === 0) {
        container_files.innerHTML = `<div class="col-12">
                          <div class="alert alert-info" role="alert">
                              No hay carpetas ni archivos disponibles.
                          </div>
                      </div>`;
        return;
      }

      htmlFolders = "";
      //verificamos el array de carpetas no este vacio
      if (folders && folders.length > 0) {
        folders.forEach((element) => {
          htmlFolders += `  <div class="col-md-2 col-sm-6 mb-4">
                          <div class="card shadow-sm h-100 text-center cursor-pointer"  data-toggle="tooltip" data-placement="top"
                              title="Carpeta de ${element.f_name}">
                              <div class="card-body">
                                  <i class="fa fa-folder fa-3x text-warning mb-2"></i>
                                  <h6 class="mb-0">${element.f_name}</h6>
                              </div>
                          </div>
                      </div>`;
        });
      } else {
        htmlFolders = `<div class="col-12">
                          <div class="alert alert-info" role="alert">
                              No hay carpetas disponibles.
                          </div>
                      </div>`;
      }
      folder_container.innerHTML = htmlFolders;
      //mostramos todos los archivos cargados
      htmlFiles = "";
      if (files && files.length > 0) {
        files.forEach((element) => {
          htmlFiles += `<div class="col-md-2 col-sm-6 mb-4">
                        <div class="card shadow-sm h-100 text-center" data-toggle="tooltip" data-placement="top"
                            title="Archivo PDF">
                            <div class="card-body">
                                <i class="fa fa-file-pdf-o fa-3x text-danger mb-2"></i>
                                <h6 class="mb-0">Informe.pdf</h6>
                            </div>
                        </div>
                    </div>`;
        });
      } else {
        htmlFiles = `<div class="col-12">
                          <div class="alert alert-info" role="alert">
                              No hay archivos disponibles.
                          </div>
                      </div>`;
      }
      file_container.innerHTML = htmlFiles;
    })
    .catch((error) => {
      console.error("Error al cargar archivos:", error);
    });
}

function saveFolder() {
  const formSave = document.getElementById("formSave");
  formSave.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(formSave);
    const url = base_url + "/Clust/createFolder";
    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Cerrar modal
          $("#modalCarpeta").modal("hide");
          // Recargar archivos
          loadFiles();
        } else {
          console.error("Error al crear carpeta:", data.error);
        }
      })
      .catch((error) => {
        console.error("Error al crear carpeta:", error);
      });
  });
}
