<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        isSession();
        parent::__construct();
    }

    public function dashboard($values)
    {
        $arrayIds = explode(",", $values);
        //obtenemos la ruta del servidor
        $query_string = $_SERVER["QUERY_STRING"];
        //validmoas que el array de id no este vacio
        if (!empty($values)) {
            //ahora validamos que todo los datos del array sean numericos
            if (!isNumericArray($arrayIds)) {
                //redireccionamos con js al notfound
                echo "<script>window.location.href='" . base_url() . "/errors/notfound" . "';</script>";
                die();
            }
            //validamos si el array solo es logitud de 1 quiere decir que estamos dentro de un macroprocess
            if (count($arrayIds) == 1) {
                $idMacroprocess = $arrayIds[0];
                $dataMacroprocess = $this->model->select_macroprocess_by_id($idMacroprocess);
                $function = $dataProcess = $this->proceses_associed_macroprocess_by_id($idMacroprocess, $dataMacroprocess);
            }
        } else {
            $function = $this->index();
        }
        $data['page_id'] = 2;
        $data['page_title'] = "Panel de control";
        $data['page_description'] = "Panel de control";
        $data['page_container'] = "Dashboard";
        $data['page_view'] = 'dashboard';
        $data['page_js_css'] = "dashboard";
        $data['page_vars'] = ["login", "login_info"];
        $data['page_widget'] = array(
            array(
                "title" => "Usuarios",
                "icon" => "fa fa-users",
                "value" => $this->model->select_count_users()['CantidadUsuariosActivos'],
                "link" => base_url() . "/users",
                "text" => "Cantidad de usuarios que tienen acceso al sistema y que estan activos",
                "color" => "primary",
            ),
            array(
                "title" => "Roles",
                "icon" => "fa fa-tags",
                "value" => $this->model->select_count_roles()['CantidadRoles'],
                "link" => base_url() . "/roles",
                "text" => "Cantidad de roles que existen en el sistema y que estan activos",
                "color" => "info",
            ),
            array(
                "title" => "Espacio Disponible",
                "icon" => "fa fa-hdd-o",
                "value" => "Dispo.: 1GB de 2GB",
                "link" => base_url() . "/roles",
                "text" => "Cantidad de espacio disponible en el sistema para su cuenta",
                "color" => "warning",
            ),
        );
        $data["page_widget_component"] = $function;
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "dashboard", $data);
    }
    /**
     * Metodo que se encarga de mostrar el componente principal del los componentes del SSOMA
     * @return  string
     */
    public function index()
    {
        $arrayMacroprocess = $this->model->select_macroprocess_active();
        $html = "";
        $html .= '
        <!--Listado de los macroprocesos-->
        <div class="row">';

        foreach ($arrayMacroprocess as $k => $v):
            $html .= '
                <!-- Card 1 -->
                <div class="col-md-4 mb-4">
                    <a href="' . base_url() . '/dashboard/dashboard/' . $v["idMacroprocess"] . '"
                        class="card custom-card p-4 text-center h-100" data-toggle="tooltip" data-placement="top"
                        title="Haz clic para ver más sobre ' . $v["mp_name"] . '">
                        <div class="icon-wrapper bg-primary mx-auto">
                            <i class="fa fa-university"></i>
                        </div>
                        <h5>' . $v["mp_name"] . '</h5>
                        <p class="text-justify" title="' . $v["mp_description"] . '">' . limitarCaracteres($v["mp_description"], 50, "...") . '</p>
                        <div class="date"><i class="fa fa-calendar"></i> ' . dateFormat($v["mp_registrationDate"]) . '</div>
                    </a>
                </div>';
        endforeach;
        $html .= ' </div>
        <!-- Botones Flotantes -->
        <div class="floating-buttons">          
            <!-- Botón Recargar -->
            <button class="btn btn-success" title="Recargar" onclick="location.reload()">
                <i class="fa fa-refresh"></i>
            </button>
        </div>
        <!-- Activar tooltips solo en hover -->
        <script>
            $(function () {
                $(`[data-toggle="tooltip"]`).tooltip({
                    trigger: `hover`
                })
            })
        </script>';
        return $html;
    }
    /** 
     * Metodo que se encarga de obtener el componente con todos procesos vinculados a los macroprocesos
     * @param  int $id
     * @return string
     */
    public function proceses_associed_macroprocess_by_id($id, array $data)
    {
        $dataProcess = $this->model->select_process_by_id($id);
        $html = "";
        $html .= '


        <div class="app-title pt-5">
            <div class="w-100">
                <h1 class="text-primary mb-3"><i class="fa fa-university"></i>' . $data["mp_name"] . '</h1>
                <p class="mb-2">' . $data["mp_description"] . '</p>
                <hr class="w-100">
                    <ul class="app-breadcrumb breadcrumb bg-primary text-white p-2">
                        <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/" class="text-white"><i class="fa fa fa-university fa-lg"></i></a></li>
                        <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/dashboard/' . $data["idMacroprocess"] . '" class="text-white">' . $data["mp_name"] . '</a></li>
                    </ul>
            </div>          
        
        </div>
        
        <!--Listado de los macroprocesos-->
        <div class="row">';

        foreach ($dataProcess as $k => $v):
            $html .= '
                <!-- Card 1 -->
                <div class="col-md-4 mb-4">
                    <a href="' . base_url() . '/dashboard/dashboard/' . $v["idProcess"] . '"
                        class="card custom-card p-4 text-center h-100" data-toggle="tooltip" data-placement="top"
                        title="Haz clic para ver más sobre ' . $v["p_name"] . '">
                        <div class="icon-wrapper bg-primary mx-auto">
                            <i class="fa fa-bookmark"></i>
                        </div>
                        <h5>' . $v["p_name"] . '</h5>
                        <p class="text-justify" title="' . $v["p_description"] . '">' . limitarCaracteres($v["p_description"], 50, "...") . '</p>
                        <div class="date"><i class="fa fa-calendar"></i> ' . dateFormat($v["p_registrationDate"]) . '</div>
                    </a>
                </div>';
        endforeach;
        //metodo que se encarga de configurar los botones de navegacion
        $arrayMacroprocess = $this->model->select_macroprocess_active();
        $position = 0;
        foreach ($arrayMacroprocess as $key => $value) {
            if ($value['idMacroprocess'] == $id) {
                $position = $key;
                break;
            }
        }
        $btnLeft = "";
        if ($position > 0) {
            $btnLeft = '<!-- Botón Anterior -->
            <button class="btn btn-primary" title="Anterior - ' . $arrayMacroprocess[($position - 1)]['mp_name'] . '" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . $arrayMacroprocess[($position - 1)]['idMacroprocess'] . '`">
                <i class="fa fa-arrow-left"></i>
            </button>';
        }
        $btnRight = '';
        if ($position < (count($arrayMacroprocess)-1)) {
            $btnRight = '   <!-- Botón Siguiente -->
            <button class="btn btn-primary" title="Siguiente - ' . $arrayMacroprocess[($position + 1)]['mp_name'] . '" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . $arrayMacroprocess[($position + 1)]['idMacroprocess'] . '`">
                <i class="fa fa-arrow-right"></i>
            </button>';
        }
        $html .= ' </div>
        <!-- Botones Flotantes -->
        <div class="floating-buttons">
            ' . $btnLeft . '
            <!-- Botón Subir nivel -->
            <button class="btn btn-warning" title="Subir un nivel" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . '`">
                <i class="fa fa-arrow-up"></i>
            </button>

            <!-- Botón Recargar -->
            <button class="btn btn-success" title="Recargar" onclick="location.reload()">
                <i class="fa fa-refresh"></i>
            </button>
            ' . $btnRight . '
        </div>
        <!-- Activar tooltips solo en hover -->
        <script>
            $(function () {
                $(`[data-toggle="tooltip"]`).tooltip({
                    trigger: `hover`
                })
            })
        </script>';
        return $html;
    }

}
