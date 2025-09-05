<?php

class Macroprocess extends Controllers
{
    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        isSession();
        parent::__construct();
    }
    /**
     * Funcion que devuelve la vista de la gestion de usuarios
     * @return void
     */
    public function macroprocess()
    {
        $data['page_id'] = 12;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Macroprocesos";
        $data['page_description'] = "Permite gestionar los macroprocesos del sistema GSSOHMA.";
        $data['page_container'] = "Macroprocess";
        $data['page_view'] = 'macroprocess';
        $data['page_js_css'] = "macroprocess";
        $data['page_vars'] = ["login", "login_info", "lastConsult"];
        registerLog("Información de navegación", "El usuario entro a: " . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "macroprocess", $data);
    }
    /**
     * Metodo que devuelve todos los macroprocesos a la vista de macroprocesos
     * @return void
     */
    public function getMacroprocess()
    {
        permissionInterface(12);
        //obtenemos todos los macroprocesos
        $data = $this->model->select_macroprocess();
        $cont = 1;
        foreach ($data as $key => $value) {
            $data[$key]['cont'] = $cont++;
            $data[$key]['mp_registrationDate'] = dateFormat($value['mp_registrationDate']);
            $data[$key]['mp_updateDate'] = dateFormat($value['mp_updateDate']);
            $data[$key]['actions'] = ' <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-success update-item" data-id="' . $value['idMacroprocess'] . '"  data-name="' . $value['mp_name'] . '" data-description="' . $value['mp_description'] . '" data-status="' . $value['mp_status'] . '" type="button"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-info report-item" data-id="' . $value['idMacroprocess'] . '"  data-name="' . $value['mp_name'] . '" data-description="' . $value['mp_description'] . '" data-status="' . $value['mp_status'] . '" data-registration="' . dateFormat($value['mp_registrationDate']) . '" data-update="' . dateFormat($value['mp_updateDate']) . '" type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>      
                                            <button class="btn btn-danger delete-item" data-id="' . $value['idMacroprocess'] . '" data-name="' . $value['mp_name'] . '" data-description="' . $value['mp_description'] . '"  type="button"><i class="fa fa-remove"></i></button>
                                        </div>';
        }
        toJson($data);
    }
    /**
     * Método para registrar un nuevo macroproceso
     * @return void
     */
    public function setMacroprocess()
    {
        permissionInterface(12);
        // Validación del método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado al registrar un nuevo macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La solicitud para registrar un macroproceso no es válida. Actualiza la página e inténtalo nuevamente desde el formulario",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validamos que existan los inputs necesarios        
        validateFields(["txtName", "txtDescription"]);
        // Limpieza de los inputs
        $strName = strClean($_POST["txtName"]);
        $strDescription = strClean($_POST["txtDescription"]);
        // Validación de campos vacíos
        validateFieldsEmpty(array(
            "NOMBRE" => $strName
        ));
        // Validación del formato de texto en el nombre del macroproceso (solo letras y espacios, mínimo 10 caracteres, máximo 255)
        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,255}", $strName)) {
            registerLog("Ocurrió un error inesperado", "Validación de formato de texto fallida para registrar 'Nombre' de un macroproceso. Regla permitida del formato: letras (incl. tildes y Ñ/ñ), números, espacios, punto, coma, punto y coma, dos puntos, guion alto, guion bajo, paréntesis, exclamación e interrogación. Longitud mínima 10, máxima 255", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "En el campo 'Nombre' usa entre 10 y 255 caracteres con letras (incl. tildes y Ñ/ñ), números, espacios y signos permitidos (. , ; : - _ ( ) ! ¿?)",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // Validación del formato de la descripción del rol (permite letras, números, guiones, espacios, mínimo 10 caracteres)
        if ($strDescription != "") {
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,}", $strDescription)) {
                registerLog("Ocurrió un error inesperado", "Validación de formato de texto fallida para registrar 'Descripción' de un macroproceso. Regla permitida del formato: letras (incl. tildes y Ñ/ñ), números, espacios, punto, coma, punto y coma, dos puntos, guion alto, guion bajo, paréntesis, exclamación e interrogación. Longitud mínima 10", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "En el campo 'Descripción' usa al menos 10 caracteres con letras (incl. tildes y Ñ/ñ), números y signos permitidos (. , ; : - _ ( ) ! ¿?)",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //validamos que no exista el mismo nombre en la bd
        $requestMP = $this->model->select_macroprocess_by_name($strName);
        if ($requestMP) {
            registerLog("Ocurrió un error inesperado", "Registro cancelado debido a que ya existe un macroproceso con el mismo nombre. Nombre ingresado: '" . trim($strName) . "'. Regla: el nombre debe ser único", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Ya existe un macroproceso con ese nombre. Cámbialo e inténtalo nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //convertimos que el nombre tenga la primera letra en mayuscula
        $strName = ucwords($strName);
        $request = $this->model->insert_macroprocess($strName, $strDescription); //insert  macroprocess in database
        if ($request > 0) {
            registerLog("Registro exitoso", "Registro del macroproceso completado: ID =" . $request . "; Nombre ='" . $strName . "'; Descripción ='" . $strDescription . "'.", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El macroproceso se registró correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "Fallo al registrar el macroproceso ya que la operación de inserción no devolvió un ID válido (valor retornado: " . $request . "). Datos enviados: Nombre ='" . $strName . "'; Descripción ='" . $strDescription . "'.", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No logramos registrar el macroproceso. Inténtalo nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Metodo que se encarga de actualizar un macroproceso
     * @return void
     */
    public function updateMacroprocess()
    {
        permissionInterface(12);
        //validacion del Método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado al momento de actualizar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La solicitud para actualizar el macroproceso no es válida",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validamos que existan los inputs necesarios               
        validateFields(["update_txtId", "update_txtName", "update_txtDescription", "update_slctStatus"]);
        //Captura de datos enviamos
        $update_txtId = strClean($_POST["update_txtId"]);
        $update_txtName = strClean($_POST["update_txtName"]);
        $update_txtDescription = strClean($_POST["update_txtDescription"]);
        $update_slctStatus = strClean($_POST["update_slctStatus"]);
        //validacion de los campos que no llegen vacios
        validateFieldsEmpty(array(
            "ID MACROPROCESO" => $update_txtId,
            "NOMBRE DEL MACROPROCESO" => $update_txtName,
            "ESTADO DEL MACROPROCESO" => $update_slctStatus
        ));
        //validacion de que el id sea numérico
        if (!is_numeric($update_txtId)) {
            registerLog("Ocurrió un error inesperado", "Actualización rechazada: el ID del macroproceso debe ser numérico. ID recibido ='" . $update_txtId . "'", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El ID del macroproceso debe ser numérico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que los macroprocesos no sean mayores a 255 caracteres
        if (strlen($update_txtName) > 255) {
            registerLog("Ocurrió un error inesperado", "Actualización rechazada: el campo 'Nombre' excede el límite (255 caracteres)", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El nombre del macroproceso no puede superar los 255 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos los caracteres permitidos en el nombre
        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,255}", $update_txtName)) {
            registerLog("Ocurrió un error inesperado", "Validación de formato de texto fallida para actualizar 'Nombre' de un macroproceso. Regla aplicada: 10–255 caracteres; letras (incl. tildes y Ñ/ñ), números, espacios y signos permitidos (. , ; : - _ ( ) ! ¿?)", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "En el campo 'Nombre' usa entre 10 y 255 caracteres con letras, números, espacios y signos permitidos (. , ; : - _ ( ) ! ¿?)",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if ($update_txtDescription != "") {
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,}", $update_txtDescription)) {
                registerLog("Ocurrió un error inesperado", "Validación de formato de texto fallida para actualizar 'Descripción' de un macroproceso. Regla aplicada: mínimo 10 caracteres; letras (incl. tildes y Ñ/ñ), números, espacios y signos permitidos (. , ; : - _ ( ) ! ¿?). Nota: el campo es opcional; si se envía, debe cumplir la regla", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "Si agregas una descripción, usa al menos 10 caracteres con letras (incl. tildes y Ñ/ñ), números y signos permitidos (. , ; : - _ ( ) ! ¿?)",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //validamos que el id del macroproceso exista en la base de datos
        $result = $this->model->select_macroprocess_by_id($update_txtId);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "Actualización cancelada: el ID especificado no existe en la base de datos. ID recibido ='" . $update_txtId ."'", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No existe un macroproceso con el ID indicado. Actualiza la página e inténtalo nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que no exista el mismo nombre en la bd
        $requestMP = $this->model->select_macroprocess_by_name($update_txtName);
        if (!empty($requestMP)) {
            if ($requestMP["idMacroprocess"] != $update_txtId) {
                if ($requestMP) {
                    registerLog("Ocurrió un error inesperado", "Actualización rechazada debido a que el nombre ya está en uso. Nombre ingresado = '" . $update_txtName .
                                "'; ID del registro a actualizar = " . $update_txtId .
                                "; ID que ya posee ese nombre = " . ($requestMP['idMacroprocess'] ?? 'N/D') . "", 1, $_SESSION['login_info']['idUser']);
                    $data = array(
                        "title" => "Ocurrió un error inesperado",
                        "message" => "Ya existe un macroproceso con ese nombre. Cámbialo e inténtalo nuevamente",
                        "type" => "error",
                        "status" => false
                    );
                    toJson($data);
                }
            }
        }
        //aqui se tranforma la primera letra del texto en mayuscula
        $update_txtName = ucwords($update_txtName);
        //registramos el macroproceso en la base de datos
        $result = $this->model->update_macroprocess($update_txtId, $update_txtName, $update_txtDescription, $update_slctStatus);
        if ($result) {
            registerLog("Macroproceso actualizado", "Actualización exitosa: ID = " . $update_txtId .
                        "; Nombre = '" . $update_txtName .
                        "'; Estado = '" . $update_slctStatus .
                        "'; Descripción = '" . mb_substr($update_txtDescription, 0, 120) . (mb_strlen($update_txtDescription) > 120 ? "…" : "") .
                        "'", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Macroproceso actualizado",
                "message" => "Se actualizó correctamente el macroproceso con ID: " . $update_txtId . "",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo aplicar la actualización en BD. ID = " . $update_txtId .
                        "; Nombre enviado = '" . $update_txtName .
                        "'; Estado enviado = '" . $update_slctStatus .
                        "'; Descripción enviada = '" . mb_substr($update_txtDescription, 0, 120) . (mb_strlen($update_txtDescription) > 120 ? "…" : "") .
                        "'. La operación del modelo no afectó registros o retornó un resultado no válido.", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No logramos actualizar el macroproceso. Inténtalo nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Función que se encarga de eliminar un rol
     * @return void
     */
    public function deleteMacroprocess()
    {
        permissionInterface(12);

        //Validacion de que el Método sea DELETE
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            registerLog("Ocurrió un error inesperado", "Método DELETE no encontrado al momento de eliminar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La solicitud para eliminar el macroproceso no es válida",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // Capturamos la solicitud enviada
        $request = json_decode(file_get_contents("php://input"), true);
        // Validación isCsrf
        isCsrf($request["token"]);
        // Validamos que la solicitud tenga los campos necesarios
        $id = strClean($request["id"]);
        $name = strClean($request["name"]);
        //validamos que los campos no esten vacios
        if ($id == "") {
            registerLog("Ocurrió un error inesperado", "Eliminación rechazada: el campo 'id' no fue enviado en el cuerpo JSON (php://input). "
                        . "Ruta: " . ($_SERVER['REQUEST_URI'] ?? 'N/D')
                        . ", IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/D')
                        . ". Nombre recibido='" . ($name ?? 'N/D') . "'.", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El ID del macroproceso es requerido. Actualiza la página e inténtalo nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que solo se acepte numeros en el campo id
        if (!is_numeric($id)) {
            registerLog("Ocurrió un error inesperado", "Eliminación rechazada: el ID del macroproceso debe ser numérico. ID recibido = '" . $id .
                        "'", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El ID del macroproceso debe ser numérico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        ///validamos que el id del macroproceso exista en la base de datos
        $result = $this->model->select_macroprocess_by_id($id);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "Eliminación cancelada: el ID especificado no existe en la base de datos. ID recibido = '" . $id ."'", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No existe un macroproceso con el ID indicado. Actualiza la página e inténtalo nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos si el macroproceso tiene procesos asociados 
        $dataResult = $this->model->has_associated_records($id);
        if ($dataResult['totalProcess'] > 0) {
            registerLog("Ocurrió un error inesperado", "Eliminación rechazada: el macroproceso ID = " . $id . " tiene " . $dataResult['totalProcess'] . " proceso(s) asociado(s). "
        . "Debe eliminar o reasignar dichas dependencias antes de continuar", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Este macroproceso tiene " . $dataResult['totalProcess'] . " proceso(s) asociados. Elimínelos o reasígnelos antes de continuar",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        $request = $this->model->delete_macroprocess($id);
        if ($request) {
            registerLog("Eliminación correcta", "El macroproceso fue eliminado correctamente. ID = {$id}; Nombre = '{$name}'.", 2, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Eliminación correcta",
                "message" => "Se eliminó correctamente el macroproceso «{$name}»",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo completar la eliminación del macroproceso. ID = {$id}; Nombre = '{$name}'. La operación del modelo no reportó cambios", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logró eliminar el macroproceso «{$name}». Inténtalo nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}
