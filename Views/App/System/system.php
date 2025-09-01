<?= headerAdmin($data) ?>
<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1 class="text-primary"><i class="fa fa-gear"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-gear fa-lg"></i></li>
            <li class="breadcrumb-item"><a
                    href="<?= base_url() ?>/<?= $data['page_view'] ?>"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card w-100 p-4">
            <form id="formSave" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <!-- SECCIÓN 1: INFORMACIÓN GENERAL DEL SISTEMA -->
                    <div class="col-md-6 border-right border-bottom pb-2">
                        <h4 class="mt-3 text-primary"><i class="fa fa-info-circle fa-lg"></i> Identidad del Sistema</h4>
                        <p class="text-muted">Configure los elementos fundamentales que identifican su sistema,
                            incluyendo el logo, nombre y descripción que aparecerán en toda la plataforma.</p>
                        <hr>
                        <?= csrf() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">Logo del Sistema</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control form-control-file" id="logo" name="logo"
                                            accept="image/png, image/jpeg" onchange="previewLogo(event)">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" for="logo"><i
                                                    class="fa fa-upload"></i></span>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <img id="logoPreview"
                                            src="<?= base_url() ?>/loadfile/icon?f=<?= (getSystemInfo()) ? getSystemInfo()["c_logo"] : "sin-content.png"; ?> "
                                            alt="Vista previa del logo" class="img-fluid"
                                            style="max-height: 100px; width: 100px;">
                                    </div>
                                </div>
                                <?php if (!empty(getSystemInfo()["c_logo"])) { ?>
                                    <input type="hidden" name="profile_exist" id="profile_exist"
                                        value="<?= getSystemInfo()["c_logo"] ?>">
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombreSistema">Nombre del Sistema <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="nombreSistema" name="nombreSistema" class="form-control"
                                            placeholder="Ej: Sistema de Gestión Académica" required
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_name"] : getSystemName(); ?>"
                                            aria-describedby="iconName">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconName"><i class="fa fa-book"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción Institucional</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                        pattern="^[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+$"
                                        placeholder="Breve descripción sobre el propósito del sistema"><?= (getSystemInfo()) ? getSystemInfo()["c_description"] : getSystemName(); ?></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block mt-3">
                                    <i class="fa fa-save"></i> Guardar Configuración de Identidad
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN 2: DATOS DE CONTACTO INSTITUCIONAL -->
                    <div class="col-md-6 border-left border-bottom pb-2">
                        <h4 class="mt-3 text-primary"> <i class="fa fa-building fa-lg"></i> Datos Institucionales</h4>
                        <p class="text-muted">Información oficial de su institución que aparecerá en documentos,
                            reportes y comunicaciones generadas por el sistema.</p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtNameInsitution">Razón Social <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="txtNameInsitution" name="txtNameInsitution"
                                            class="form-control" placeholder="Ej: Universidad Tecnológica del Perú"
                                            required
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_company_name"] : ''; ?>"
                                            aria-describedby="iconNameCompany">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconNameCompany"><i
                                                    class="fa fa-university" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtRuc">RUC <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="txtRuc" name="txtRuc" class="form-control"
                                            placeholder="Ej: 20123456781" required
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_ruc"] : ''; ?>"
                                            aria-describedby="iconNameRUC">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconNameRUC"><i class="fa fa-id-card"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtAddress">Dirección Fiscal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="txtAddress" name="txtAddress" class="form-control"
                                            placeholder="Ej: Av. Arequipa 123, Lima" required
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_address"] : ''; ?>"
                                            aria-describedby="iconAddress">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconAddress"><i class="fa fa-map-marker"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtPhone">Teléfono/Celular <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="txtPhone" name="txtPhone" class="form-control"
                                            placeholder="Ej: (01) 1234567 | 987654321" required
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_phone"] : ''; ?>"
                                            aria-describedby="iconPhone">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconPhone"><i class="fa fa-phone"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="txtMail">Correo Institucional <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="txtMail" name="txtMail" class="form-control"
                                            placeholder="Ej: contacto@institucion.edu.pe" required
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_mail"] : ''; ?>"
                                            aria-describedby="iconMail">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconMail"><i class="fa fa-envelope"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block mt-3">
                                    <i class="fa fa-save"></i> Guardar Datos Institucionales
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN 3: CONFIGURACIÓN DE API PARA CONSULTAS -->
                    <div class="col-md-6 border-right border-bottom pb-2">
                        <h4 class="mt-3 text-primary"> <i class="fa fa-cloud fa-lg"></i> Conexión con Servicios Externos
                        </h4>
                        <p class="text-muted">Configure las credenciales para integrar con servicios de verificación de
                            datos como RENIEC y SUNAT.</p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtUserAPi">Usuario API <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="txtUserAPi" name="txtUserAPi" class="form-control"
                                            placeholder="Usuario proporcionado por el servicio" required
                                            value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_user_api_reniec_sunat"]) : getSystemName(); ?>"
                                            aria-describedby="iconUserApi">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconUserApi"><i class="fa fa-user-secret"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtPasswordApi">Contraseña API <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" id="txtPasswordApi" name="txtPasswordApi"
                                            class="form-control" placeholder="Contraseña del servicio API" required
                                            value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_password_api_reniec_sunat"]) : getSystemName(); ?>"
                                            aria-describedby="iconPasswordApi">
                                        <div class="input-group-prepend" style="cursor: pointer;">
                                            <span class="input-group-text" id="iconPasswordApi"
                                                onclick="(txtPasswordApi.type=='password')?(txtPasswordApi.type='text'):(txtPasswordApi.type='password')"><i
                                                    class="fa fa-eye" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="txtKeyApi">Llave de Acceso API <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" id="txtKeyApi" name="txtKeyApi" class="form-control"
                                            placeholder="Token o llave de autenticación" required
                                            value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_key_api_reniec_sunat"]) : getSystemName(); ?>"
                                            aria-describedby="iconKeyApi">
                                        <div class="input-group-prepend" style="cursor: pointer;">
                                            <span class="input-group-text" id="iconKeyApi"
                                                onclick="(txtKeyApi.type=='password')?(txtKeyApi.type='text'):(txtKeyApi.type='password')"><i
                                                    class="fa fa-key" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block mt-3">
                                    <i class="fa fa-cloud-upload"></i> Guardar Configuración API
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- SECCIÓN 4: CONFIGURACIÓN DE CORREO ELECTRÓNICO -->
                    <div class="col-md-6 border-left border-bottom pb-2">
                        <h4 class="mt-3 text-primary"><i class="fa fa-envelope-open fa-lg"></i> Configuración de Correo
                            Electrónico</h4>
                        <p class="text-muted">
                            Establezca los parámetros de conexión SMTP para que el sistema pueda enviar correos
                            automáticos
                            (recuperación de contraseñas, notificaciones, reportes, etc.).
                        </p>
                        <hr>
                        <div class="row">
                            <!-- HOST SMTP -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtpHost">Servidor SMTP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="smtpHost" name="smtpHost" class="form-control"
                                            placeholder="Ej: smtp.mi-dominio.com" required
                                            value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_email_server_smtp"]) : ''; ?>"
                                            aria-describedby="iconSmtpHost">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconSmtpHost"><i
                                                    class="fa fa-server"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PUERTO -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="smtpPort">Puerto <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" id="smtpPort" name="smtpPort" class="form-control"
                                            placeholder="Ej: 465" required min="1" max="9999"
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_email_port"] : ''; ?>"
                                            aria-describedby="iconSmtpPort">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconSmtpPort"><i
                                                    class="fa fa-plug"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CIFRADO -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="smtpEncryption">Cifrado <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select id="smtpEncryption" name="smtpEncryption" class="form-control"
                                            aria-describedby="iconSmtpEncryption">
                                            <option value="SSL">SSL</option>
                                            <option value="TLS">TLS</option>
                                            <option value="N/A">Ninguno</option>
                                            <option selected
                                                value="<?= (getSystemInfo()) ? getSystemInfo()["c_email_encryption"] : ''; ?>">
                                                <?= (getSystemInfo()) ? getSystemInfo()["c_email_encryption"] : ''; ?>
                                            </option>
                                        </select>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconSmtpEncryption"><i
                                                    class="fa fa-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- USUARIO -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtpUsername">Usuario SMTP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="smtpUsername" name="smtpUsername" class="form-control"
                                            placeholder="Ej: usuario@dominio.com" required value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_email_user_smtp"]) : ''; ?>"
                                            aria-describedby="iconSmtpUsername">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconSmtpUsername"><i
                                                    class="fa fa-user-circle"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CONTRASEÑA -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtpPassword">Contraseña SMTP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" id="smtpPassword" name="smtpPassword"
                                            class="form-control" placeholder="Contraseña del correo" required
                                            value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_email_password_smtp"]) : ''; ?>" aria-describedby="iconSmtpPassword">
                                        <div class="input-group-prepend" style="cursor: pointer;">
                                            <span class="input-group-text" id="iconSmtpPassword"
                                                onclick="(smtpPassword.type=='password')?(smtpPassword.type='text'):(smtpPassword.type='password')">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- EMAIL REMITENTE -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fromEmail">Correo Remitente <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="email" id="fromEmail" name="fromEmail" class="form-control"
                                            placeholder="Ej: no-reply@dominio.com" required value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_email_sender"]) : ''; ?>"
                                            aria-describedby="iconFromEmail">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconFromEmail"><i
                                                    class="fa fa-paper-plane"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- NOMBRE REMITENTE -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fromName">Nombre Remitente <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="fromName" name="fromName" class="form-control"
                                            placeholder="Ej: Soporte Técnico" required value="<?= (getSystemInfo()) ? decryption(getSystemInfo()["c_email_sender_name"]) : ''; ?>"
                                            aria-describedby="iconFromName">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconFromName"><i
                                                    class="fa fa-id-badge"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- BOTÓN GUARDAR -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block mt-3">
                                    <i class="fa fa-save"></i> Guardar Configuración de Correo
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- SECCIÓN 5: PREFERENCIAS DEL SISTEMA -->
                    <div class="col-md-12 ">
                        <h4 class="mt-3 text-primary"> <i class="fa fa-sliders fa-lg"></i> Personalización del Sistema
                        </h4>
                        <p class="text-muted">Ajuste la apariencia y comportamiento del sistema según sus preferencias
                            institucionales. (Los colores que se establece aqui tambien afectaran a los documentos que
                            el sistema emite)</p>
                        <hr>
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtColorPrimary">Color Principal <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="color" name="txtColorPrimary" id="txtColorPrimary"
                                            class="form-control"
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_color_primary"] : "#007bff"; ?>"
                                            aria-describedby="iconColorPrimary">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconColorPrimary"><i class="fa fa-tint"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Color dominante de la interfaz</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="txtColorSecondary">Color Secundario <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="color" name="txtColorSecondary" id="txtColorSecondary"
                                            class="form-control"
                                            value="<?= (getSystemInfo()) ? getSystemInfo()["c_color_secondary"] : "#6c757d"; ?>"
                                            aria-describedby="iconColorSecondary">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconColorSecondary"><i class="fa fa-tint"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Color para elementos secundarios</small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-gorup">
                                    <label for="txtDurationLock">Tiempo de Inactividad (minutos) <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" id="txtDurationLock" name="txtDurationLock"
                                            class="form-control" required min="0" max="9999"
                                            value="<?= (getSystemInfo()) ? (getSystemInfo()["c_duration_lock"] / 60) : "0."; ?>"
                                            aria-describedby="iconDutationLock">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconDutationLock"><i
                                                    class="fa fa-hourglass-half" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">0 = Desactiva el bloqueo automático</small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-gorup">
                                    <label for="txtTextLoader">Mensaje de Carga <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="txtTextLoader" name="txtTextLoader" class="form-control"
                                            value="<?= (getSystemInfo()) ? (getSystemInfo()["c_textLoader"]) : "Espere un momento..."; ?>"
                                            aria-describedby="iconDutationLock">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="iconDutationLock"><i
                                                    class="fa fa-comment" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Texto que aparece durante la carga</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="container mt-4">
                                        <h5 class="mb-4 text-center">Estilo de Indicador de Carga</h5>
                                        <p class="text-center text-muted mb-4">Seleccione la animación que se mostrará
                                            mientras el sistema procesa información</p>
                                        <div class="row loaders">

                                            <!-- Opciones de Loaders -->
                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 1) ? "selected" : ""; ?>"
                                                    for="loader-default">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-default"
                                                        class="loader-radio" hidden value="1"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 1) ? "checked" : ""; ?>>
                                                    <?= getLoader(1); ?>
                                                    <div class="loader-title">Default</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 2) ? "selected" : ""; ?>"
                                                    for="loader-spinner">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-spinner"
                                                        class="loader-radio" hidden value="2"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 2) ? "checked" : ""; ?>>
                                                    <?= getLoader(2); ?>
                                                    <div class="loader-title">Spinning Circle</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 3) ? "selected" : ""; ?>"
                                                    for="loader-dots">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-dots"
                                                        class="loader-radio" hidden value="3"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 3) ? "checked" : ""; ?>>
                                                    <?= getLoader(3); ?>
                                                    <div class="loader-title">Bouncing Dots</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 4) ? "selected" : ""; ?>"
                                                    for="loader-bar">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-bar"
                                                        class="loader-radio" hidden value="4"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 4) ? "checked" : ""; ?>>
                                                    <?= getLoader(4); ?>
                                                    <div class="loader-title">Sliding Bar</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 5) ? "selected" : ""; ?>"
                                                    for="loader-pulse">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-pulse"
                                                        class="loader-radio" hidden value="5"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 5) ? "checked" : ""; ?>>
                                                    <?= getLoader(5); ?>
                                                    <div class="loader-title">Pulse</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 6) ? "selected" : ""; ?>"
                                                    for="loader-dual-ring">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-dual-ring"
                                                        class="loader-radio" hidden value="6"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 6) ? "checked" : ""; ?>>
                                                    <?= getLoader(6); ?>
                                                    <div class="loader-title">Dual Ring</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 7) ? "selected" : ""; ?>"
                                                    for="loader-ripple">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-ripple"
                                                        class="loader-radio" hidden value="7"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 7) ? "checked" : ""; ?>>
                                                    <?= getLoader(7); ?>
                                                    <div class="loader-title">Ripple</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 8) ? "selected" : ""; ?>"
                                                    for="loader-circle-dots">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-circle-dots"
                                                        class="loader-radio" hidden value="8"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 8) ? "checked" : ""; ?>>
                                                    <?= getLoader(8); ?>
                                                    <div class="loader-title">Circle Dots</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 9) ? "selected" : ""; ?>"
                                                    for="loader-bars">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-bars"
                                                        class="loader-radio" hidden value="9"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 9) ? "checked" : ""; ?>>
                                                    <?= getLoader(9); ?>
                                                    <div class="loader-title">Growing Bars</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 10) ? "selected" : ""; ?>"
                                                    for="loader-flip">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-flip"
                                                        class="loader-radio" hidden value="10"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 10) ? "checked" : ""; ?>>
                                                    <?= getLoader(10); ?>
                                                    <div class="loader-title">Flip Box</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 11) ? "selected" : ""; ?>"
                                                    for="loader-fade-circle">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-fade-circle"
                                                        class="loader-radio" hidden value="11"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 11) ? "checked" : ""; ?>>
                                                    <?= getLoader(11); ?>
                                                    <div class="loader-title">Fade Circle</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 12) ? "selected" : ""; ?>"
                                                    for="loader-rotate-square">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-rotate-square"
                                                        class="loader-radio" hidden value="12"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 12) ? "checked" : ""; ?>>
                                                    <?= getLoader(12); ?>
                                                    <div class="loader-title">Rotate Square</div>
                                                </label>
                                            </div>

                                            <div class="col-md-4 col-lg-3 mb-4">
                                                <label
                                                    class="card text-center p-3 loader-option <?= (getSystemInfo()["c_typeLoader"] == 13) ? "selected" : ""; ?>"
                                                    for="loader-lines">
                                                    <input type="radio" name="rdLoaderSelect" id="loader-lines"
                                                        class="loader-radio" hidden value="13"
                                                        <?= (getSystemInfo()["c_typeLoader"] == 13) ? "checked" : ""; ?>>
                                                    <?= getLoader(13); ?>
                                                    <div class="loader-title">Moving Lines</div>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block mt-3">
                                    <i class="fa fa-save"></i> Guardar Preferencias
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?= footerAdmin($data) ?>