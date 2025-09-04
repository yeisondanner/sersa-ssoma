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
            //obtencion de informacion generales
            $idMacroprocess = $arrayIds[0];
            $dataMacroprocess = $this->model->select_macroprocess_by_id($idMacroprocess);
            //validamos si el array solo es logitud de 1 quiere decir que estamos dentro de un macroprocess
            if (count($arrayIds) == 1) {
                $function = $this->proceses_associed_macroprocess_by_id($idMacroprocess, $dataMacroprocess);
            } else if (count($arrayIds) == 2) {
                $idProcess = $arrayIds[1];
                $dataProcess = ["Macroprocess" => $dataMacroprocess, "Process" => $this->model->select_process_by_id($idProcess)];
                $function = $this->thread_associed_process_by_id($idProcess, $dataProcess);
            } else {
                $idProcess = $arrayIds[1];
                $dataProcess = ["Macroprocess" => $dataMacroprocess, "Process" => $this->model->select_process_by_id($idProcess)];
                $function = $this->subthread_by_thread_by_process_by_macroprocess($arrayIds, $dataProcess);
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
    public function proceses_associed_macroprocess_by_id(int $id, array $data)
    {
        $dataProcess = $this->model->select_process_associed_macroprocess_by_id($id);
        $html = "";
        $html .= '
        <div class="app-title pt-5">
            <div class="w-100">
                <h1 class="text-primary mb-3"><i class="fa fa-university"></i>' . $data["mp_name"] . '</h1>
                <p class="mb-2">' . $data["mp_description"] . '</p>
                <hr class="w-100">
                    <ul class="app-breadcrumb breadcrumb bg-primary text-white p-2">
                        <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/" class="text-white"><i class="fa fa fa-globe fa-lg"></i></a></li>
                        <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/dashboard/' . $data["idMacroprocess"] . '" class="text-white"><i class="fa fa fa-university"></i> ' . $data["mp_name"] . '</a></li>
                    </ul>
            </div>          
        
        </div>
        
        <!--Listado de los macroprocesos-->
        <div class="row">';

        foreach ($dataProcess as $k => $v):
            $html .= '
                <!-- Card 1 -->
                <div class="col-md-4 mb-4">
                    <a href="' . base_url() . '/dashboard/dashboard/' . $data["idMacroprocess"] . '/' . $v["idProcess"] . '"
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
        if ($position < (count($arrayMacroprocess) - 1)) {
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
    /**
     * Metodo que se encarga de mostrar los subprocesos asociados a los procesos que estan
     * @param int $idprocess
     * @return mixed
     */
    public function thread_associed_process_by_id(int $idprocess, array $data)
    {
        $idMacroprocess = $data['Macroprocess']["idMacroprocess"];
        $dataThread = $this->model->select_thread_associed_process_associed_macroprocess_by_id($idprocess, $idMacroprocess);
        $html = "";
        //elemento cabezera
        $html .= '
        <div class="app-title pt-5">
            <div class="w-100">
                <h1 class="text-primary mb-3"><i class="fa fa-university"></i>' . $data['Process']["p_name"] . '</h1>
                <p class="mb-2">' . $data['Process']["p_description"] . '</p>
                <hr class="w-100">
                    <ul class="app-breadcrumb breadcrumb bg-primary text-white p-2">
                        <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/" class="text-white"><i class="fa fa fa-globe fa-lg"></i></a></li>
                                <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '" class="text-white"><i class="fa fa fa-university"></i> ' . $data['Macroprocess']["mp_name"] . '</a></li>
                        <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $data['Process']["idProcess"] . '" class="text-white"><i class="fa fa fa-bookmark"></i> ' . $data['Process']["p_name"] . '</a></li>
                    </ul>
            </div>          
        
        </div>';
        //elemento contenido
        $html .= ' <!--Listado de los macroprocesos-->
        <div class="row">';
        foreach ($dataThread as $k => $v):
            //validdamos el que tipo de menu es
            if ($v['t_type'] == "open_menu") {
                $icon = "<i class='fa fa-bars'></i>";
            } else if ($v['t_type'] == "open_file") {
                $icon = "<i class='fa fa-file'></i>";

            } else if ($v["t_type"] == "open_form") {
                $icon = "<i class='fa fa-pencil'></i>";
            } else {
                $icon = "<i class='fa fa-exclamation'></i>";
            }
            $html .= '
                <!-- Card 1 -->
                <div class="col-md-4 mb-4">
                    <a href="' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $data['Process']["idProcess"] . '/' . $v["idThreads"] . '"
                        class="card custom-card p-4 text-center h-100" data-toggle="tooltip" data-placement="top"
                        title="Haz clic para ver más sobre ' . $v["t_name"] . '">
                        <div class="icon-wrapper bg-primary mx-auto">
                            ' . $icon . '
                        </div>
                        <h5>' . $v["t_name"] . '</h5>
                        <p class="text-justify" title="' . $v["t_description"] . '">' . limitarCaracteres($v["t_description"], 50, "...") . '</p>
                        <div class="date"><i class="fa fa-calendar"></i> ' . dateFormat($v["t_registrationDate"]) . '</div>
                    </a>
                </div>';
        endforeach;
        $html .= '</div>';
        //metodo que se encarga de configurar los botones de navegacion
        $arrayProcess = $this->model->select_process_associed_macroprocess_by_id($idMacroprocess);
        $position = 0;
        //esto se encarga de devolve la posicion de array
        foreach ($arrayProcess as $key => $value) {
            if ($value['idProcess'] == $idprocess) {
                $position = $key;
                break;
            }
        }
        $btnLeft = "";
        if ($position > 0) {
            $btnLeft = '<!-- Botón Anterior -->
            <button class="btn btn-primary" title="Anterior - ' . $arrayProcess[($position - 1)]['p_name'] . '" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $arrayProcess[($position - 1)]['idProcess'] . '`">
                <i class="fa fa-arrow-left"></i>
            </button>';
        }
        $btnRight = '';
        if ($position < (count($arrayProcess) - 1)) {
            $btnRight = '   <!-- Botón Siguiente -->
            <button class="btn btn-primary" title="Siguiente - ' . $arrayProcess[($position + 1)]['p_name'] . '" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $arrayProcess[($position + 1)]['idProcess'] . '`">
                <i class="fa fa-arrow-right"></i>
            </button>';
        }
        $html .= '
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
    /**
     * Metodo que encarga de obtener los subthreas hijas
     */
    public function subthread_by_thread_by_process_by_macroprocess(array $arrids, array $data)
    {
        $idThread = $arrids[(count($arrids) - 1)];
        $dataThread = $this->model->select_thread_id($idThread);
        $html = '';
        $idMacroprocess = $data['Macroprocess']["idMacroprocess"];
        $idProcess = $data['Process']["idProcess"];
        //elemento cabezera
        $html .= '
        <div class="app-title pt-5">
            <div class="w-100">
                <h1 class="text-primary mb-3"><i class="fa fa-tag"></i> ' . $dataThread['t_name'] . '</h1>
                <p class="mb-2">' . $dataThread['t_description'] . '</p>
                <hr class="w-100">
                    <ul class="app-breadcrumb breadcrumb bg-primary text-white p-2">                    
                     <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/" class="text-white"><i class="fa fa fa-globe fa-lg"></i></a></li>
                                           <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '" class="text-white"><i class="fa fa fa-university"></i> ' . $data['Macroprocess']["mp_name"] . '</a></li>
                        <li class="breadcrumb-item"><a
                                href="' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $data['Process']["idProcess"] . '" class="text-white"><i class="fa fa fa-bookmark"></i> ' . $data['Process']["p_name"] . '</a></li>                        
                    
                                ';
        $url = base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $data['Process']["idProcess"];
        foreach (array_slice($arrids, 2) as $key => $value) {
            $url .= '/' . $value;
            $infoThread = $this->model->select_thread_id($value);
            $html .= '<li class="breadcrumb-item"><a
                                href="' . $url . '" class="text-white"><i class="fa fa fa-tag"></i> ' . $infoThread["t_name"] . '</a></li>';
        }
        $html .= '</ul>
            </div>          
        
        </div>';
        //obtenemos los elementos hijo
        $dataSubthreads = $this->model->select_subthread_associed_thread_associed_process_associed_macroprocess($idThread, $idProcess, $idMacroprocess);
        //elemento contenido
        $html .= ' <!--Listado de los macroprocesos-->
        <div class="row">';
        foreach ($dataSubthreads as $k => $v):
            //validdamos el que tipo de menu es
            if ($v['t_type'] == "open_menu") {
                $icon = "<i class='fa fa-bars'></i>";
            } else if ($v['t_type'] == "open_file") {
                $icon = "<i class='fa fa-file'></i>";

            } else if ($v["t_type"] == "open_form") {
                $icon = "<i class='fa fa-pencil'></i>";
            } else {
                $icon = "<i class='fa fa-exclamation'></i>";
            }
            $html .= '
                <!-- Card 1 -->
                <div class="col-md-4 mb-4">
                    <a href="' . $url . '/' . $v["idThreads"] . '"
                        class="card custom-card p-4 text-center h-100" data-toggle="tooltip" data-placement="top"
                        title="Haz clic para ver más sobre ' . $v["t_name"] . '">
                        <div class="icon-wrapper bg-primary mx-auto">
                            ' . $icon . '
                        </div>
                        <h5>' . $v["t_name"] . '</h5>
                        <p class="text-justify" title="' . $v["t_description"] . '">' . limitarCaracteres($v["t_description"], 50, "...") . '</p>
                        <div class="date"><i class="fa fa-calendar"></i> ' . dateFormat($v["t_registrationDate"]) . '</div>
                    </a>
                </div>';
        endforeach;
        $html .= '</div>';

        /**
         * ============================================================================ 
         *metodo que se encarga de configurar los botones de navegacion
         *=============================================================================
         **/
        $arrayProcess = $this->model->select_process_associed_macroprocess_by_id($idMacroprocess);
        $position = 0;
        //esto se encarga de devolve la posicion de array
        foreach ($arrayProcess as $key => $value) {
            if ($value['idProcess'] == $idprocess) {
                $position = $key;
                break;
            }
        }
        $btnLeft = "";
        if ($position > 0) {
            $btnLeft = '<!-- Botón Anterior -->
            <button class="btn btn-primary" title="Anterior - ' . $arrayProcess[($position - 1)]['p_name'] . '" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $arrayProcess[($position - 1)]['idProcess'] . '`">
                <i class="fa fa-arrow-left"></i>
            </button>';
        }
        $btnRight = '';
        if ($position < (count($arrayProcess) - 1)) {
            $btnRight = '   <!-- Botón Siguiente -->
            <button class="btn btn-primary" title="Siguiente - ' . $arrayProcess[($position + 1)]['p_name'] . '" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '/' . $arrayProcess[($position + 1)]['idProcess'] . '`">
                <i class="fa fa-arrow-right"></i>
            </button>';
        }
        $html .= '
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
