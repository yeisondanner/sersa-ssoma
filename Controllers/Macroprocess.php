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
                "message" => "Método POST no encontrado, refresco por favor la pagina en intente nuevamente",
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
        // Validación del formato de texto en el nombre del macroproceso (solo letras y espacios, mínimo 4 caracteres, máximo 250)
        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s\.,;:\-_\(\)!¿\?]{10,255}", $strName)) {
            registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto al registrar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // Validación del formato de la descripción del rol (permite letras, números, guiones, espacios, mínimo 20 caracteres)
        if ($strDescription != "") {
            if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $strDescription)) {
                registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto al registrar un macroproceso", 1, $_SESSION['login_info']['idUser']);
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
        $strName = ucwords($strName);
        $request = $this->model->insert_macroprocess($strName, $strDescription); //insert  macroprocess in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El macroproceso se ha registrado correctamente, con el Nombre = ".$strName." Descripcion = ".$strDescription." con ID = ".$request, 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El macroproceso se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "El macroproceso no se ha registrado correctamente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El macroproceso no se ha registrado correctamente",
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
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado, al momento de actualizar un macroproceso", 1, $_SESSION['login_info']['idUser']);
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
            registerLog("Ocurrió un error inesperado", "El id del macroproceso debe ser numérico, al momento de actualizar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del macroproceso debe ser numérico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que los macroprocesos no sean mayores a 255 caracteres
        if (strlen($update_txtName) > 255) {
            registerLog("Ocurrió un error inesperado", "El nombre del macroproceso no puede ser mayor a 255 caracteres, al momento de actualizar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El nombre del macroproceso no puede ser mayor a 255 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos los caracteres permitidos en el nombre
        if (verifyData("(?=.{10,255}$)[\p{L}0-9\.,;:\-_()\s]+", $update_txtName)) {
            registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto al registrar un macroproceso", 1, $_SESSION['login_info']['idUser']);
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
                registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto al registrar un macroproceso", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El campo descripción no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //validamos que el id del macroproceso exista en la base de datos
        $result = $this->model->select_macroprocess_by_id($update_txtId);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el macroproceso, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del macroproceso no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        $update_txtName = ucwords($update_txtName);
        //registramos el macroproceso en la base de datos
        $result = $this->model->update_macroprocess($update_txtId, $update_txtName, $update_txtDescription, $update_slctStatus);
        if ($result) {
            registerLog("Macroproceso actualizado", "Se actualizo la informacion del macroproceso con el id: " . $update_txtId, 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Macroproceso actualizado",
                "message" => "Se actualizo el macroproceso con el id: " . $update_txtId,
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el macroproceso, al momento de actualizar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se pudo actualizar el macroproceso, al momento de actualizar un macroproceso",
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
            registerLog("Ocurrió un error inesperado", "Método DELETE no encontrado, al momento de eliminar un macroproceso", 1, $_SESSION['login_info']['idUser']);
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
            registerLog("Ocurrió un error inesperado", "El id del macroproceso es requerido, al momento de eliminar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del macroproceso es requerido, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que solo ce acepte numeros en el campo id
        if (!is_numeric($id)) {
            registerLog("Ocurrió un error inesperado", "El id del macroproceso debe ser numérico, al momento de eliminar un macroproceso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del macroproceso debe, ser numérico, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        ///validamos que el id del macroproceso exista en la base de datos
        $result = $this->model->select_macroprocess_by_id($id);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar el macroproceso, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del macroproceso no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos si el macroproceso tiene procesos asociados 
        $dataResult = $this->model->has_associated_records($id);
        if ($dataResult['totalProcess'] > 0) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar el macroproceso, ya que tiene procesos asociados, elimínalos primero para poder eliminar el macroproceso", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El macroproceso tiene procesos asociados, elimínalos primero para poder eliminar el macroproceso",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        $request = $this->model->delete_macroprocess($id);
        if ($request) {
            registerLog("Eliminación correcta", "Se eliminó de manera correcta el macroproceso {$name}", 2, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Eliminación correcta",
                "message" => "Se eliminó de manera correcta el macroproceso {$name}",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo eliminar el macroproceso {$name}, por favor inténtalo nuevamente", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logró eliminar de manera correcta el macroproceso {$name}",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}