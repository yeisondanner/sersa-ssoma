<?php

class Process extends Controllers
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
    public function process()
    {
        $data['page_id'] = 13;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Procesos";
        $data['page_description'] = "Permite gestionar los procesos del sistema GSSOHMA.";
        $data['page_container'] = "Process";
        $data['page_view'] = 'process';
        $data['page_js_css'] = "process";
        $data['page_vars'] = ["login", "login_info", "lastConsult"];
        //requieremos el modelo de macroprocesos
        require_once "Models/MacroprocessModel.php";
        $objMP = new MacroprocessModel();
        $dataMacroprocess = $objMP->select_macroprocess();
        //limpiamos solo registros que estan con el estado activo
        $datosActive = array_filter($dataMacroprocess, function ($var) {
            return $var['mp_status'] !== 'Inactivo';
        });
        //reindexamos el array para que no queden huecos en las claves
        $datosActive = array_values($datosActive);
        $data["page_macroprocess"] = $datosActive;
        //destruimos el objeto
        unset($objMP);
        registerLog("Información de navegación", "El usuario entro a: " . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "process", $data);
    }
    /**
     * Metodo que devuelve todos los macroprocesos a la vista de procesos
     * @return void
     */
    public function getProcess()
    {
        permissionInterface(13);
        //obtenemos todos los procesos
        $data = $this->model->select_process_inner_macroprocess();
        $cont = 1;
        foreach ($data as $key => $value) {
            $data[$key]['cont'] = $cont++;
            $data[$key]['p_registrationDate'] = dateFormat($value['p_registrationDate']);
            $data[$key]['p_updateDate'] = dateFormat($value['p_updateDate']);
            $data[$key]['actions'] = ' <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-success update-item" data-macroprocess-id="' . $value['macroprocess_id'] . '" data-id="' . $value['idProcess'] . '"  data-name="' . $value['p_name'] . '" data-description="' . $value['p_description'] . '" data-status="' . $value['p_status'] . '" type="button"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-info report-item" data-macroprocess-id="' . $value['macroprocess_id'] . '" data-macroprocess-name="' . $value['mp_name'] . '" data-id="' . $value['idProcess'] . '"  data-name="' . $value['p_name'] . '" data-description="' . $value['p_description'] . '" data-status="' . $value['p_status'] . '" data-registration="' . dateFormat($value['p_registrationDate']) . '" data-update="' . dateFormat($value['p_updateDate']) . '" type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>      
                                            <button class="btn btn-danger delete-item" data-id="' . $value['idProcess'] . '" data-name="' . $value['p_name'] . '" data-description="' . $value['p_description'] . '"  type="button"><i class="fa fa-remove"></i></button>
                                        </div>';
        }
        toJson($data);
    }
    /**
     * Metodo que se encarga de obtener los procesos por su ID para la vista de thread
     * @return void
     */
    public function getProcesesById()
    {
        permissionInterface(14);
        validateFields(["id"], 'GET');
        // Obtenemos el ID del proceso
        $id = intval($_GET['id']);
        // Validamos que el ID sea válido
        if ($id <= 0) {
            registerLog("Ocurrió un error inesperado", "Consulta rechazada: el ID de proceso no es válido (<= 0). ID recibido = '" . ($_GET['id'] ?? 'N/D') .
                        "'. Ruta: " . (($_SERVER['REQUEST_URI'] ?? '') ?: 'N/D'), 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El ID del proceso no es válido. Intente nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Obtenemos el proceso por su ID
        $data = $this->model->select_processes_by_id($id);
        if (!$data) {
            registerLog("Ocurrió un error inesperado", "No se encontró el proceso solicitado. ID = " . $id . ". Ruta: " . (($_SERVER['REQUEST_URI'] ?? '') ?: 'N/D'), 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No existe el proceso con ID indicado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos si el p_status es activo si no se lo quita
        $datosActive = array_filter($data, function ($var) {
            return $var['p_status'] !== 'Inactivo';
        });
        //reindexamos el array para que no queden huecos en las claves
        $datosActive = array_values($datosActive);
        $data = $datosActive;
        toJson(["status" => true, "data" => $data]);
    }
    /**
     * Método para registrar un nuevo macroproceso
     * @return void
     */
    public function setProcess()
    {
        permissionInterface(13);
        // Validación del método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Registro de proceso bloqueado: se esperaba POST y se recibió " . ($_SERVER['REQUEST_METHOD'] ?? 'N/D') .
                        ". Ruta: " . (($_SERVER['REQUEST_URI'] ?? '') ?: 'N/D'), 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La solicitud para registrar el proceso no es válida",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validamos que existan los inputs necesarios        
        validateFields(["txtName", "txtDescription", "slctMacroprocess"]);
        // Limpieza de los inputs
        $strName = strClean($_POST["txtName"]);
        $strDescription = strClean($_POST["txtDescription"]);
        $intMacroprocessId = intval($_POST["slctMacroprocess"]);
        // Validación de campos vacíos
        validateFieldsEmpty(array(
            "NOMBRE" => $strName,
            "MACROPROCESO" => $intMacroprocessId
        ));
        // Validación del formato de texto en el nombre del proceso (solo letras y espacios, mínimo 10 caracteres, máximo 250)
        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)]{10,255}", $strName)) {
            registerLog("Ocurrió un error inesperado", "Validación de formato de texto fallida para registrar 'Nombre' de un macroproceso. Regla aplicada: 10–255 caracteres; letras (incl. tildes y Ñ/ñ), números, signos de puntuación básicos (. , ; :), y símbolos simples (- ( ) _ )", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "En el campo 'Nombre' usa entre 10 y 255 caracteres con letras, números, espacios, signos y símbolos permitidos (. , ; : _ ( ) -)",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos que el macro proceso sea numerico
        if (!is_numeric($intMacroprocessId)) {
            registerLog("Ocurrió un error inesperado", "Registro rechazado: el identificador de Macroproceso debe ser numérico. Valor recibido='" . $intMacroprocessId .
                        "'. Ruta: " . (($_SERVER['REQUEST_URI'] ?? '') ?: 'N/D'), 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Selecciona un macroproceso válido. El identificador debe ser numérico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validación del formato de la descripción del rol (permite letras, números, guiones, espacios, mínimo 20 caracteres)
        if ($strDescription != "") {
            if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9 \.,;:!¿\?\(\)\-]{10,}", $strDescription)) {
                registerLog("Ocurrió un error inesperado", "Validación de formato de texto fallida para actualizar 'Descripción' de un macroproceso. Regla aplicada: mínimo 10 caracteres; letras (incl. tildes y Ñ/ñ), números, signos de puntuación básicos (. , ; :), y símbolos simples (- ( ) _ )", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "En el campo 'Descripción' usa al menos 10 caracteres con letras (incl. tildes y Ñ/ñ), números, signos y símbolos permitidos (. , ; : - _ ( ) ! ¿?)",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //falta valida que el nombre no exista en la base de datos
        //validamos que no exista el mismo proceso en un macroproceso existentte bd
        $requestP = $this->model->select_process_by_name_and_macro($strName, $intMacroprocessId);
        if ($requestP) {
            registerLog("Ocurrió un error inesperado", "Registro cancelado debido a que ya existe un proceso con ese nombre en el macroproceso ID={$intMacroprocessId}. Nombre='{$strName}'", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Ya existe un proceso con ese nombre en el macroproceso seleccionado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //convertimos que el nombre tenga la primera letra en mayuscula
        $strName = ucwords($strName);
        $request = $this->model->insert_process($strName, $strDescription, $intMacroprocessId); //insert  process in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El proceso se ha registrado correctamente, al momento de registrar un usuario", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El proceso se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "El proceso no se ha registrado correctamente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El proceso no se ha registrado correctamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Metodo que se encarga de actualizar un proceso
     * @return void
     */
    public function updateProcess()
    {
        permissionInterface(13);
        //validacion del Método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado, al momento de actualizar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validamos que existan los inputs necesarios               
        validateFields(["update_txtId", "update_txtName", "update_txtDescription", "update_slctStatus", "update_slctMacroprocess"]);
        //Captura de datos enviamos
        $update_txtId = strClean($_POST["update_txtId"]);
        $update_txtName = strClean($_POST["update_txtName"]);
        $update_txtDescription = strClean($_POST["update_txtDescription"]);
        $update_slctStatus = strClean($_POST["update_slctStatus"]);
        $update_slctMacroprocess = strClean($_POST["update_slctMacroprocess"]);
        //validacion de los campos que no llegen vacios
        validateFieldsEmpty(array(
            "ID MACROPROCESO" => $update_txtId,
            "NOMBRE DEL MACROPROCESO" => $update_txtName,
            "ESTADO DEL MACROPROCESO" => $update_slctStatus,
            "MACROPROCESO" => $update_slctMacroprocess
        ));
        //Validamos que el macroproceso sea un valor numerico
        if (!is_numeric($update_slctMacroprocess)) {
            registerLog("Ocurrió un error inesperado", "El macroproceso debe ser un valor numérico, al momento de actualizar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El macroproceso debe ser un valor numérico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion de que el id sea numérico
        if (!is_numeric($update_txtId)) {
            registerLog("Ocurrió un error inesperado", "El id del proceso debe ser numérico, al momento de actualizar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del proceso debe ser numérico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que los procesos no sean mayores a 255 caracteres
        if (strlen($update_txtName) > 255) {
            registerLog("Ocurrió un error inesperado", "El nombre del proceso no puede ser mayor a 255 caracteres, al momento de actualizar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El nombre del proceso no puede ser mayor a 255 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos los caracteres permitidos en el nombre
        if (verifyData("(?=.{10,255}$)[\p{L}0-9\.,;:\-_()\s]+", $update_txtName)) {
            registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto al registrar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if ($update_txtDescription != "") {
            if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $update_txtDescription)) {
                registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto al registrar un proceso", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El campo descripción no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //validamos que el id del proceso exista en la base de datos
        $result = $this->model->select_process_by_id($update_txtId);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el proceso, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del proceso no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que exista el macroproceso que se esta eligiendo, para ellos instanciamos el modelo del macroproceso mediante un objeto para luego destruirlo
        require_once "./Models/MacroprocessModel.php";
        $objMP = new MacroprocessModel();
        $dataMP = $objMP->select_macroprocess_by_id($update_slctMacroprocess);
        //validamos si no tiene ningun registro asociado a ese id
        if (!$dataMP) {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el proceso, ya que el macroproceso no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El macroproceso no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //destruimos el obj
        unset($objMP);
        $update_txtName = ucwords($update_txtName);
        //registramos el proceso en la base de datos
        $result = $this->model->update_process($update_txtId, $update_txtName, $update_txtDescription, $update_slctStatus, $update_slctMacroprocess);
        if ($result) {
            registerLog("Proceso actualizado", "Se actualizo la informacion del proceso con el id: " . $update_txtId, 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Proceso actualizado",
                "message" => "Se actualizo el proceso con el id: " . $update_txtId,
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el proceso, al momento de actualizar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se pudo actualizar el proceso, al momento de actualizar un proceso",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Función que se encarga de eliminar un proceso
     * @return void
     */
    public function deleteProcess()
    {
        permissionInterface(13);

        //Validacion de que el Método sea DELETE
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            registerLog("Ocurrió un error inesperado", "Método DELETE no encontrado, al momento de eliminar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método DELETE no encontrado",
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
            registerLog("Ocurrió un error inesperado", "El id del proceso es requerido, al momento de eliminar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del proceso es requerido, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que solo ce acepte numeros en el campo id
        if (!is_numeric($id)) {
            registerLog("Ocurrió un error inesperado", "El id del proceso debe ser numérico, al momento de eliminar un proceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del proceso debe, ser numérico, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        ///validamos que el id del proceso exista en la base de datos
        $result = $this->model->select_process_by_id($id);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar el proceso, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del proceso no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos si el proceso tiene subprocesos asociados
        $dataResult = $this->model->has_associated_threads($id);
        if ($dataResult['totalThreads'] > 0) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar el proceso, ya que tiene subprocesos asociados, elimínalos primero para poder eliminar el proceso", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El proceso tiene subprocesos asociados, elimínalos primero para poder eliminar el proceso",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        $request = $this->model->delete_process($id);
        if ($request) {
            registerLog("Eliminación correcta", "Se eliminó de manera correcta el proceso {$name}", 2, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Eliminación correcta",
                "message" => "Se eliminó de manera correcta el proceso {$name}",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo eliminar el proceso {$name}, por favor inténtalo nuevamente", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logró eliminar de manera correcta el proceso {$name}",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}