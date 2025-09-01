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
        //obtenemos todos los macroprocesos
        $data = $this->model->select_macroprocess();
        $cont = 1;
        foreach ($data as $key => $value) {
            $data[$key]['cont'] = $cont++;
            $data[$key]['mp_registrationDate'] = dateFormat($value['mp_registrationDate']);
            $data[$key]['mp_updateDate'] = dateFormat($value['mp_updateDate']);
            $data[$key]['actions'] = ' <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-success update-item"  type="button"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-info report-item"  type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>      
                                            <button class="btn btn-danger delete-item"  type="button"><i class="fa fa-remove"></i></button>
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
        permissionInterface(4);
        // Validación del método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado al registrar un nuevo macroproceso", 1, $_SESSION['login_info']['idUser']);
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
        validateFields(["txtName", "txtDescription"]);
        // Limpieza de los inputs
        $strName = strClean($_POST["txtName"]);
        $strDescription = strClean($_POST["txtDescription"]);
        // Validación de campos vacíos
        validateFieldsEmpty(array(
            "NOMBRE" => $strName
        ));
        // Validación del formato de texto en el nombre del macroproceso (solo letras y espacios, mínimo 4 caracteres, máximo 250)
        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,250}", $strName)) {
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
        $request = $this->model->insert_macroprocess($strName, $strDescription); //insert  roles in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El macroproceso se ha registrado correctamente, al momento de registrar un usuario", 2, $_SESSION['login_info']['idUser']);
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
}