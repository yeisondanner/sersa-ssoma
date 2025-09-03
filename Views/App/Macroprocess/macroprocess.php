<?= headerAdmin($data) ?>
<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1 class="text-primary"><i class="fa fa-university"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-university fa-lg"></i></li>
            <li class="breadcrumb-item"><a
                    href="<?= base_url() ?>/<?= $data['page_view'] ?>"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>
    <div class="tile">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalSave"><i
                class="fa fa-plus"></i> Nuevo</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Fecha de registro</th>
                                    <th>Fecha de actualización</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= footerAdmin($data) ?>

<!-- Seccion de Modals -->
<!-- Modal Save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-labelledby="modalSaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSaveLabel">Nuevo Macroproceso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Registro de Usuario -->
                <div class="tile-body">
                    <form id="formSave" enctype="multipart/form-data" autocomplete="off">
                        <?= csrf(); ?>
                        <div class="bg-light p-2 rounded">
                            <div class="row">
                                <!-- Campo Nombre -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="txtName">Nombre <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="txtName" name="txtName" required
                                                placeholder="Ingrese el nombre" 
                                                minlength="10" maxlength="255"
                                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,255}$"
                                                title="Solo se permiten: letras (con tilde y Ñ/ñ), números, espacios, punto, coma, punto y coma, dos puntos, guion alto, guion bajo, paréntesis, exclamación e interrogación. Longitud mínima 10, máxima 255.">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconNombre">
                                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small id="helpNombre" class="form-text text-muted">
                                            <span class="text-danger">*</span>
                                            Permitido un mínimo de 10 - 255 caracteres.
                                        </small>
                                    </div>
                                </div>

                                <!-- Campo Descripción -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="txtDescription">Descripción</label>
                                        <div class="input-group">
                                            <textarea class="form-control" id="txtDescription" name="txtDescription"
                                                rows="3" placeholder="Ingrese una breve descripción"
                                                minlength="10"
                                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,}$"
                                                title="Solo se permiten: letras (con tilde y Ñ/ñ), números, espacios, punto, coma, punto y coma, dos puntos, guion alto, guion bajo, paréntesis, exclamación e interrogación. Longitud mínima 10."
                                                aria-describedby="iconDescription helpDescription"></textarea>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconDescription">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small id="helpDescription" class="form-text text-muted">
                                            <span class="text-danger">*</span>
                                            Permitido un mínimo de 10 caracteres a más.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón -->
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fa fa-fw fa-lg fa-save"></i> Guardar
                            </button>
                        </div>


                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete-->
<div class="modal fade" id="confirmModalDelete" tabindex="-1" role="dialog" aria-labelledby="confirmModalDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalLabel">Confirmación de Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-exclamation-triangle fa-5x text-danger mb-3"></i>
                <p class="font-weight-bold">¿Estás seguro?</p>
                <p class="" id="txtDelete"></p>
                <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" data-token="<?= csrf(false) ?>" id="confirmDelete">
                    <i class="fa fa-check"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Report -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="modalReportLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold" id="modalReportLabel">Reporte de Macroproceso</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Contenedor principal con foto y datos -->
                <div class="d-flex justify-content-between  align-items-center">
                    <!-- Nombre -->
                    <div>
                        <h3 class="text-uppercase font-weight-bold text-primary" id="reportTitle">--Titulo--</h3>
                    </div>
                </div>
                <!-- Datos del registro -->
                <h6 class="text-uppercase font-weight-bold text-danger mt-4">Información detallada</h6>
                <hr>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Código</strong></td>
                            <td id="reportCode">--Code--</td>
                        </tr>
                        <tr>
                            <td><strong>Descripción</strong></td>
                            <td id="reportDescription">--Description--</td>
                        </tr>

                        <tr>
                            <td><strong>Estado</strong></td>
                            <td id="reportEstado">--Estado--</td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-3 bg-light border rounded">
                    <p class="text-muted mb-1">
                        <strong>Fecha de registro:</strong> <span class="text-dark"
                            id="reportRegistrationDate">29/01/2025</span>
                    </p>
                    <p class="text-muted mb-0">
                        <strong>Fecha de actualización:</strong> <span class="text-dark"
                            id="reportUpdateDate">29/01/2025</span>
                    </p>
                </div>
            </div>
            <!-- Pie del Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update-->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalUpdateLabel">Actualizar información del Macroproceso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Registro de Usuario -->
                <div class="tile-body">
                    <form id="formUpdate" autocomplete="off">
                        <?= csrf(); ?>
                        <input type="hidden" id="update_txtId" name="update_txtId" value="">
                        <div class="bg-light p-2 rounded">
                            <div class="row">
                                <!-- Campo Nombre -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="update_txtName">Nombre <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="update_txtName"
                                                name="update_txtName" required placeholder="Ingrese el nombre"
                                                minlength="10" maxlength="255"
                                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,255}$"
                                                title="Solo se permiten: letras (con tilde y Ñ/ñ), números, espacios, punto, coma, punto y coma, dos puntos, guion alto, guion bajo, paréntesis, exclamación e interrogación. Longitud mínima 10, máxima 255."
                                                aria-describedby="iconNombre helpNombre">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconNombre">
                                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small id="helpNombre" class="form-text text-muted">
                                            <span class="text-danger">*</span>
                                            Permitido un mínimo de 10 - 255 caracteres.
                                        </small>
                                    </div>
                                </div>

                                <!-- Campo Descripción -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="update_txtDescription">Descripción</label>
                                        <div class="input-group">
                                            <textarea class="form-control" id="update_txtDescription"
                                                name="update_txtDescription" rows="3"
                                                placeholder="Ingrese una breve descripción"
                                                minlength="10"
                                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,}$"
                                                title="Solo se permiten: letras (con tilde y Ñ/ñ), números, espacios, punto, coma, punto y coma, dos puntos, guion alto, guion bajo, paréntesis, exclamación e interrogación. Longitud mínima 10."
                                                aria-describedby="iconDescription helpDescription"></textarea>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconDescription">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small id="helpDescription" class="form-text text-muted">
                                            <span class="text-danger">*</span>
                                            Permitido un mínimo de 10 caracteres a más.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="update_slctStatus">Estado</label>
                                        <div class="input-group">
                                            <select class="form-control" id="update_slctStatus" name="update_slctStatus"
                                                aria-describedby="iconDescription">
                                                <option value="Activo">Activo</option>
                                                <option value="Inactivo">Inactivo</option>
                                            </select>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconDescription">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-success btn-block" type="submit">
                                <i class="fa fa-fw fa-lg fa-pencil"></i>Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>