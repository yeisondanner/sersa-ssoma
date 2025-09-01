<?php

class Logs extends Controllers
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
    public function logs()
    {
        $data['page_id'] = 5;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Historial de registros";
        $data['page_description'] = "Aquí se podran ver los registros de los usuarios, incluyendo los cambios realizados en el sistema";
        $data['page_container'] = "Logs";
        $data['page_view'] = 'logs';
        $data['page_js_css'] = "logs";
        //variables de sesion que se deben mantener activos, para evitar que se pierdan los datos
        $data['page_vars'] = ["login", "login_info"];
        registerLog("Información de navegación", "El usuario entró a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);

        $this->views->getView($this, "logs", $data);
    }
    public function getLogs()
    {
        permissionInterface(5);
        $filter_type = isset($_GET["filterType"]) ? strClean($_GET['filterType']) : 0;
        $minData = (isset($_GET["minData"]) && !empty($_GET["minData"])) ? strClean($_GET['minData']) : 0;
        $maxData = (isset($_GET["maxData"]) && !empty($_GET["maxData"])) ? strClean($_GET['maxData']) : 0;
        $request = $this->model->select_logs($minData, $maxData, $filter_type);
        $cont = 1;
        foreach ($request as $key => $value) {
            $request[$key]['cont'] = $cont;
            $request[$key]['l_registrationDate'] = dateFormat($value['l_registrationDate']);
            $request[$key]['actions'] = '
            <button class="btn btn-info report-item"
                data-id="' . $value['idLog'] . '"
                data-title="' . $value['l_title'] . '"
                data-description="' . str_replace("'", "¬", str_replace('"', '|', $value['l_description'])) . '"
                data-registrationdate="' . dateFormat($value['l_registrationDate']) . '"
                data-updatedate="' . dateFormat($value['l_updateDate']) . '"
                data-type="' . $value['tl_name'] . '"
                data-fullname="' . $value['u_fullname'] . '"
                data-email="' . decryption($value['u_email']) . '"
                data-user="' . decryption($value['u_user']) . '"
            type="button" >
                <i class="fa fa-list" aria-hidden="true"></i>
            </button>
            ';
            ;
            $cont++;
        }
        toJson($request);
    }

}
