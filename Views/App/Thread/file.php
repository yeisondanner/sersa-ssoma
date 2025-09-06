<?= headerAdmin($data) ?>
<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1 class="text-primary"><i class="fa fa-tag"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-tag fa-lg"></i></li>
            <li class="breadcrumb-item"><a
                    href="<?= base_url() ?>/<?= strtolower($data['page_container']) ?>/<?= $data['page_view'] ?>/<?= encryption($data['page_thread']['idThreads']) ?>"><?= $data["page_title"] ?></a>
            </li>
        </ul>
    </div>
    <div class="tile d-flex justify-content-between">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalSave"><i
                class="fa fa-plus"></i> Nuevo</button>
        <button type="button" class="btn btn-success" onclick="window.location.href=`<?= base_url() ?>/thread`"><i
                class="fa fa-arrow-left" aria-hidden="true"></i>
            Regresar</button>
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
                                    <th>Macroproceso</th>
                                    <th>Proceso</th>
                                    <th title="Se asocia al id del subproceso que hace en este caso de padre">Subproceso
                                        Padre</th>
                                    <th>Id Subproceso</th>
                                    <th>Subproceso</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Fecha registro</th>
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
<!-- Modal Save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-labelledby="modalSaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSaveLabel">Nuevo archivo</h5>
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
                                        <label class="control-label" for="flFile">Archivo <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="flFile" name="flFile" required
                                                aria-describedby="iconFile">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconFile">
                                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label" for="txtName">Nombre <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="txtName" name="txtName" required
                                                placeholder="Ingrese el nombre" minlength="1" maxlength="255"
                                                pattern="^[A-Z0-9 _-]{1,255}$"
                                                title="Solo se permiten letras mayúsculas (A-Z), números, espacios, guiones bajos (_) y guiones medios (-). Máximo 255 caracteres."
                                                aria-describedby="iconNombre">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconNombre">
                                                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="slctDonwload">¿Se puede descargar? <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select type="text" class="form-control" id="slctDonwload"
                                                name="slctDonwload" required aria-describedby="iconDonwload">
                                                <option value="Yes">Si</option>
                                                <option value="No" selected>No</option>
                                            </select>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="iconDonwload">
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
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