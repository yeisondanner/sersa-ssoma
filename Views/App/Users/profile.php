<?= headerAdmin($data) ?>
<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1><i class="fa fa-user"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-user fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/dashboard"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>

    <div class="container mt-5">
        <div class="profile-container">
            <img src="<?= ($_SESSION['login_info']['profile'] == "" ? generateAvatar($_SESSION['login_info']['fullName']) : base_url() . "/loadfile/profile/?f=" . $_SESSION['login_info']['profile']) ?>"
                alt="<?= $_SESSION['login_info']['fullName'] ?>" class="profile-img" id="fotoPerfil">
            <div class="">
                <h3 class="mt-3" id="nombresCompletos"><?= $_SESSION['login_info']['fullName'] ?></h3>
                <p class="text-muted">@<span id="usuario"><?= decryption($_SESSION['login_info']['user']) ?></span></p>
            </div>
        </div>
        <div class="tile">
            <p class="font-weight-bold">Datos adicionales</p>
            <hr>
            <p><strong>Email:</strong> <span id="email"><?= decryption($_SESSION['login_info']['email']) ?></span></p>
            <p><strong>DNI:</strong> <span id="dni"><?= $_SESSION['login_info']['dni'] ?></span></p>
            <p><strong>Genero:</strong> <span id="gender"><?= $_SESSION['login_info']['gender'] ?></span>
            </p>
        </div>
        <button class="btn btn-primary btn-edit" data-toggle="modal" data-target="#editarPerfilModal"><i
                class="fa fa-pencil"></i> Editar
            Perfil</button>
    </div>

    <!-- Modal de edición -->
    <div class="modal fade" id="editarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="editarPerfilModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Editar Perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formUpdate" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="userProfile" value="true">
                    <input type="hidden" name="update_txtFotoActual" value="<?= $_SESSION['login_info']['profile'] ?>">
                    <div class="modal-body">
                        <div class="tile-body">
                            <?= csrf(); ?>
                            <h5 class="text-primary"><i class="fa fa-user"></i> Datos Personales</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label" for="update_txtFullName">Nombres Completos <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            <input class="form-control" type="text" id="update_txtFullName"
                                                name="update_txtFullName" required
                                                placeholder="Ingrese sus nombres completos" maxlength="200"
                                                minlength="20"
                                                pattern="^[A-ZÁÉÍÓÚÑa-záéíóúñ]+(\s[A-ZÁÉÍÓÚÑa-záéíóúñ]+)*$"
                                                value="<?= $_SESSION['login_info']['fullName'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="update_txtDNI">DNI <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-address-card"></i></span>
                                            </div>
                                            <input class="form-control" type="text" maxlength="8" minlength="8"
                                                pattern="^\d{8}$" id="update_txtDNI" name="update_txtDNI" required
                                                placeholder="Ingrese su numero de DNI"
                                                value="<?= $_SESSION['login_info']['dni'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Género <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" value="Masculino" type="radio"
                                            <?= $_SESSION['login_info']['gender'] == "Masculino" ? "checked" : "" ?>
                                            name="update_txtGender"> Masculino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" value="Femenino" type="radio"
                                            <?= $_SESSION['login_info']['gender'] == "Femenino" ? "checked" : "" ?>
                                            name="update_txtGender"> Femenino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" value="Otro" type="radio"
                                            <?= $_SESSION['login_info']['gender'] == "Otro" ? "checked" : "" ?>
                                            name="update_txtGender"> Otro
                                    </label>
                                </div>
                            </div>

                            <h5 class="text-primary"><i class="fa fa-lock"></i> Datos de la Cuenta</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="update_txtUser">Usuario <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                            </div>
                                            <input type="text" pattern="^[a-zA-Z0-9_-]{3,15}$" minlength="3"
                                                maxlength="15" class="form-control" id="update_txtUser"
                                                name="update_txtUser" placeholder="Ingrese su usuario"
                                                title="El usuario debe tener entre 3 y 15 caracteres y solo puede contener letras, números, guiones bajos (_) o guiones (-)."
                                                required value="<?= decryption($_SESSION['login_info']['user']) ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="update_txtEmail">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email"
                                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" minlength="2"
                                                class="form-control" id="update_txtEmail" name="update_txtEmail"
                                                placeholder="Ingrese su correo"
                                                title="Por favor, ingrese un correo electrónico válido." required
                                                value="<?= decryption($_SESSION['login_info']['email']) ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="update_txtPassword">Contraseña <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input class="form-control" type="password" id="update_txtPassword"
                                                name="update_txtPassword" placeholder="Ingrese su contraseña"
                                                minlength="8">
                                            <div class="input-group-prepend">
                                                <button class="input-group-text" type="button"
                                                    onclick="(update_txtPassword.type=='password')?(update_txtPassword.type='text'):(update_txtPassword.type='password')""><i id="
                                                    update_passwordicon" class="
                                                    fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="update_flPhoto">Foto de Perfil (JPG,JPEG,PNG) <span
                                        class="text-danger">2 MB</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-image"></i></span>
                                    </div>
                                    <input class="form-control" type="file" id="update_flPhoto" name="update_flPhoto"
                                        accept="image/jpg, image/png, image/jpeg">
                                </div>
                            </div>

                            <div class="d-flex" style="justify-content: center;">
                                <img class="upload-img-profile" id="imgNewProfile" alt="Previsualización"
                                    src="<?= ($_SESSION['login_info']['profile'] == "" ? generateAvatar($_SESSION['login_info']['fullName']) : base_url() . "/loadfile/profile/?f=" . $_SESSION['login_info']['profile']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>
<?= footerAdmin($data) ?>