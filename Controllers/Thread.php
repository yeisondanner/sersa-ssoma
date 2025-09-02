<?php

class Thread extends Controllers
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
    public function thread()
    {
        $data['page_id'] = 14;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Subprocesos";
        $data['page_description'] = "Permite gestionar los subprocesos del sistema GSSOHMA.";
        $data['page_container'] = "Thread";
        $data['page_view'] = 'thread';
        $data['page_js_css'] = "thread";
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
        $this->views->getView($this, "thread", $data);
    }
    /**
     * Metodo que devuelve todos los subprocesos a la vista de threads
     * @return void
     */
    public function getThreads()
    {
        permissionInterface(13);
        //obtenemos todos los procesos
        $data = $this->model->select_thread_inner_process_inner_macroprocess();
        $cont = 1;
        foreach ($data as $key => $value) {
            $data[$key]['cont'] = $cont++;
            $data[$key]['t_registrationDate'] = dateFormat($value['t_registrationDate']);
            $data[$key]['t_updateDate'] = dateFormat($value['t_updateDate']);
            $data[$key]['actions'] = ' <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-success update-item" type="button"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-info report-item"  type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>      
                                            <button class="btn btn-danger delete-item" data-id="' . $value['idThreads'] . '" data-name="' . $value['t_name'] . '" type="button"><i class="fa fa-remove"></i></button>
                                        </div>';
        }
        toJson($data);
    }
    /**
     * Metodo que se encarga de obtener los subprocesos por su id asociado a un proceso en especifico, esto devuelve a la vista de thread
     * @return void
     */
    public function getThreadsById()
    {
        permissionInterface(14);
        validateFields(["id"], 'GET');
        // Obtenemos el ID del proceso
        $id = intval($_GET['id']);
        // Validamos que el ID sea válido
        if ($id <= 0) {
            registerLog("Ocurrió un error inesperado", "ID de Proceso no válido", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "ID de proceso no válido",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Obtenemos el proceso por su ID
        $data = $this->model->select_threads_by_process_id($id);
        if (!$data) {
            registerLog("Ocurrió un error inesperado", "No se encontró ningun subproceso asociado al macroproceso con  ID $id", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontro ningun subproceso asociado a este Proceso",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos si el t_status es activo si no se lo quita
        $datosActive = array_filter($data, function ($var) {
            return $var['t_status'] !== 'Inactivo';
        });
        //reindexamos el array para que no queden huecos en las claves
        $datosActive = array_values($datosActive);
        $data = $datosActive;
        //validamos si no esta vacios el array final
        if (empty($data)) {
            toJson(["status" => false, "message" => "No se encontraron subprocesos activos", "type" => "error", "title" => "Ocurrio un Error Inesperado"]);
        }
        toJson(["status" => true, "data" => $data]);
    }
    /**
     * Método para registrar un nuevo subproceso
     * @return void
     */
    public function setThread()
    {
        permissionInterface(14);
        // Validación del método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado al registrar un nuevo subproceso", 1, $_SESSION['login_info']['idUser']);
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
        validateFields(["slctMacroprocess", "slctProcess", "slctSubProcess", "txtName", "slctType"]);
        // Limpieza de los inputs
        $slctMacroprocess = strClean($_POST["slctMacroprocess"]);
        $slctProcess = strClean($_POST["slctProcess"]);
        $slctSubProcess = strClean($_POST["slctSubProcess"]);
        $txtName = strClean($_POST["txtName"]);
        $txtDescription = strClean($_POST["txtDescription"]);
        $slctType = strClean($_POST["slctType"]);
        // Validación de campos vacíos
        validateFieldsEmpty(array(
            "MACROPROCESO" => $slctMacroprocess,
            "PROCESO" => $slctProcess,
            "NOMBRE" => $txtName,
            "TIPO" => $slctType
        ));
        // Validación del formato de texto en el nombre del macroproceso (solo letras y espacios, mínimo 4 caracteres, máximo 250)
        if (verifyData("[\p{L}\p{M}\p{N}\. ]{10,255}", $txtName)) {
            registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto al registrar un subprocesos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos que el macro proceso sea numerico
        if (!is_numeric($slctProcess)) {
            registerLog("Ocurrió un error inesperado", "El campo proceso no es numérico", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo proceso debe ser un número, por favor recargue la página e inténtelo de nuevo.",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos que el campo subproceso sea numerico
        if (!is_numeric($slctSubProcess)) {
            registerLog("Ocurrió un error inesperado", "El campo subproceso no es numérico", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo subproceso debe ser un número, por favor recargue la página e inténtelo de nuevo.",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validación del formato de la descripción del rol (permite letras, números, guiones, espacios, mínimo 20 caracteres)
        if ($txtDescription != "") {
            if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $txtDescription)) {
                registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto al registrar un subproceso", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El campo descripción no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //falta valida que el nombre no exista en la base de datos
        //convertimos que el nombre tenga la primera letra en mayuscula
        $txtName = ucwords($txtName);
        $request = $this->model->insert_thread($txtName, $txtDescription, $slctProcess, $slctSubProcess, $slctType); //insert  subproceso in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El subproceso se ha registrado correctamente, al momento de registrar un usuario", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El proceso se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "El subproceso no se ha registrado correctamente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El subproceso no se ha registrado correctamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Función que se encarga de eliminar un subproceso
     * @return void
     */
    public function deleteThread()
    {
        permissionInterface(14);

        //Validacion de que el Método sea DELETE
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            registerLog("Ocurrió un error inesperado", "Método DELETE no encontrado, al momento de eliminar un subproceso", 1, $_SESSION['login_info']['idUser']);
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
        $result = $this->model->select_thread_by_id($id);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar el subproceso, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del subproceso no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }


        $request = $this->model->delete_thread($id);
        if ($request) {
            registerLog("Eliminación correcta", "Se eliminó de manera correcta el subproceso {$name}", 2, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Eliminación correcta",
                "message" => "Se eliminó de manera correcta el subproceso {$name}",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo eliminar el subproceso {$name}, por favor inténtalo nuevamente", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logró eliminar de manera correcta el subproceso {$name}",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}