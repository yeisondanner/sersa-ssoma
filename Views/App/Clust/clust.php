<?= headerAdmin($data) ?>

<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1 class="text-primary"><i class="fa fa-dashboard"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a
                    href="<?= base_url() ?>/<?= $data['page_view'] ?>"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>

    <div class="row bg-white">
        <div class="col-md-3 container-siderbar-storage">
            <!-- Botón Toggle (solo móviles) -->
            <button class="btn btn-light d-md-none toggle-btn" id="menu-toggle">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Sidebar -->
            <div class="sidebar" id="sidebarClust">
                <button class="btn btn-sm btn-light border d-md-none close-sidebar" id="menu-close"
                    aria-label="Cerrar menú">
                    <i class="fa fa-times"></i>
                </button>
                <!-- Dropdown Nuevo -->
                <div class="dropdown">
                    <button class="btn btn-new text-left dropdown-toggle" type="button" id="dropdownNuevo"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus"></i> Nuevo
                    </button>
                    <div class="dropdown-menu w-100" aria-labelledby="dropdownNuevo">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalCarpeta">
                            <i class="fa fa-folder"></i> Carpeta
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalArchivo">
                            <i class="fa fa-file"></i> Archivo
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalSubir">
                            <i class="fa fa-upload"></i> Subir archivo
                        </a>
                    </div>
                </div>
                <!-- Menú -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link active"><i class="fa fa-hdd-o"></i> Mi unidad</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-image"></i> Imagenes</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="fa fa-file-pdf-o"></i> PDF</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="fa fa-file-word-o"></i> Word</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="fa fa-file-excel-o"></i> Excel</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-clock-o"></i> Recientes</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-star"></i> Destacados</a>
                    </li>
                </ul>
                <hr>
                <!-- Almacenamiento -->
                <?= $data['page_components']['storage'] ?>
            </div>
        </div>
        <div class="col-md-9 col-12  p-4">
            <div>
                <!-- Barra de búsqueda -->
                <form action="" class="w-100 mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-pill" placeholder="Buscar carpetas o archivos..."
                            aria-label="Buscar">
                        <div class="input-group-append">
                            <button class="btn btn-primary rounded-pill ml-2" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Encabezado con título y botones de vista -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <h2 class="text-primary mb-2 mb-md-0">Mi unidad</h2>

                    <div class="btn-group" role="group" aria-label="Cambiar vista">
                        <a href="#" class="btn btn-outline-primary btn-sm " aria-pressed="false" data-toggle="tooltip"
                            data-placement="top" title="Vista en lista">
                            <i class="fa fa-list"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm active" aria-pressed="true"
                            data-toggle="tooltip" data-placement="top" title="Vista en cuadrícula">
                            <i class="fa fa-th"></i>
                        </a>
                    </div>
                </div>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-white p-2 mb-0 shadow-sm rounded">
                        <li class="breadcrumb-item"><a href="#">Mi unidad</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
            <!-- Archivos y Carpetas -->
            <div id="container_files">
                <p>Carpetas</p>
                <hr>
                <div class="row" id="folder_container">
                    <!-- Carpeta -->
                    <div class="col-md-2 col-sm-6 mb-4">
                        <div class="card shadow-sm h-100 text-center" data-toggle="tooltip" data-placement="top"
                            title="Carpeta de proyectos">
                            <div class="card-body">
                                <i class="fa fa-folder fa-3x text-warning mb-2"></i>
                                <h6 class="mb-0">Proyectos</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Carpeta -->
                    <div class="col-md-2 col-sm-6 mb-4">
                        <div class="card shadow-sm h-100 text-center" data-toggle="tooltip" data-placement="top"
                            title="Carpeta de documentos">
                            <div class="card-body">
                                <i class="fa fa-folder fa-3x text-warning mb-2"></i>
                                <h6 class="mb-0">Documentos</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <p>Archivos</p>
                <hr>
                <div class="row" id="file_container">
                    <!-- Archivo -->
                    <div class="col-md-2 col-sm-6 mb-4">
                        <div class="card shadow-sm h-100 text-center" data-toggle="tooltip" data-placement="top"
                            title="Archivo PDF">
                            <div class="card-body">
                                <i class="fa fa-file-pdf-o fa-3x text-danger mb-2"></i>
                                <h6 class="mb-0">Informe.pdf</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Archivo -->
                    <div class="col-md-2 col-sm-6 mb-4">
                        <div class="card shadow-sm h-100 text-center" data-toggle="tooltip" data-placement="top"
                            title="Archivo de imagen">
                            <div class="card-body">
                                <i class="fa fa-file-image-o fa-3x text-info mb-2"></i>
                                <h6 class="mb-0">Foto.png</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts necesarios para tooltip -->
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            </script>

        </div>
    </div>


</main>
<?= footerAdmin($data) ?>

<!-- Modal Carpeta -->
<div class="modal fade" id="modalCarpeta" tabindex="-1" role="dialog" aria-labelledby="modalCarpetaLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formSave" class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modalCarpetaLabel">Nueva Carpeta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" placeholder="Nombre de carpeta">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Archivo -->
<div class="modal fade" id="modalArchivo" tabindex="-1" role="dialog" aria-labelledby="modalArchivoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalArchivoLabel">Nuevo Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" placeholder="Nombre del archivo">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Subir -->
<div class="modal fade" id="modalSubir" tabindex="-1" role="dialog" aria-labelledby="modalSubirLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalSubirLabel">Subir Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control-file">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Subir</button>
            </div>
        </div>
    </div>
</div>