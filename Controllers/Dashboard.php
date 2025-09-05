<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        isSession();
        parent::__construct();
    }
    /**
     * Controlador del Panel de Control (Dashboard).
     * Gestiona la navegación según el nivel (Macroproceso, Proceso, Hilo, Subhilo).
     */
    public function dashboard($values)
    {
        // Convertimos el string de IDs en array
        $arrayIds = explode(",", $values);

        // Si no hay parámetros, mostrar vista principal del dashboard
        if (empty($values)) {
            return $this->renderDashboard($this->index());
        }

        // Validar que todos los IDs sean numéricos
        if (!isNumericArray($arrayIds)) {
            $this->redirectNotFound();
        }

        // -------------------------------
        // 1. Obtener Macroproceso
        // -------------------------------
        $idMacroprocess = $arrayIds[0];
        $dataMacroprocess = $this->model->select_macroprocess_by_id($idMacroprocess);

        // -------------------------------
        // 2. Determinar nivel de navegación
        // -------------------------------
        $function = null;
        $idProcess = $arrayIds[1] ?? null;

        switch (count($arrayIds)) {
            case 1: // Solo Macroproceso
                $function = $this->proceses_associed_macroprocess_by_id($idMacroprocess, $dataMacroprocess);
                break;

            case 2: // Macroproceso -> Proceso
                $dataProcess = [
                    "Macroprocess" => $dataMacroprocess,
                    "Process" => $this->model->select_process_by_id($idProcess)
                ];
                $function = $this->thread_associed_process_by_id($idProcess, $dataProcess);
                break;

            default: // Macroproceso -> Proceso -> Hilo/Subhilo
                $dataProcess = [
                    "Macroprocess" => $dataMacroprocess,
                    "Process" => $this->model->select_process_by_id($idProcess)
                ];
                $function = $this->subthread_by_thread_by_process_by_macroprocess($arrayIds, $dataProcess);
                break;
        }

        // Renderizar dashboard con el contenido dinámico
        return $this->renderDashboard($function);
    }

    /**
     * Redirige a página de error Not Found usando JS.
     */
    private function redirectNotFound()
    {
        echo "<script>window.location.href='" . base_url() . "/errors/notfound';</script>";
        die();
    }

    /**
     * Renderiza la vista del Dashboard con parámetros comunes.
     *
     * @param mixed $component Contenido dinámico del dashboard según navegación.
     */
    private function renderDashboard($component)
    {
        $data = [
            'page_id' => 2,
            'page_title' => "Panel de control",
            'page_description' => "Panel de control",
            'page_container' => "Dashboard",
            'page_view' => 'dashboard',
            'page_js_css' => "dashboard",
            'page_vars' => ["login", "login_info"],
            'page_widget' => $this->getWidgets(),
            'page_widget_component' => $component,
        ];

        // Registrar log de navegación
        registerLog(
            "Información de navegación",
            "El usuario entró a: " . $data['page_title'],
            3,
            $_SESSION['login_info']['idUser']
        );

        // Renderizar vista
        $this->views->getView($this, "dashboard", $data);
    }

    /**
     * Devuelve los widgets fijos que aparecen en el dashboard.
     *
     * @return array
     */
    private function getWidgets()
    {
        return [
            [
                "title" => "Usuarios",
                "icon" => "fa fa-users",
                "value" => $this->model->select_count_users()['CantidadUsuariosActivos'],
                "link" => base_url() . "/users",
                "text" => "Cantidad de usuarios activos en el sistema",
                "color" => "primary",
            ],
            [
                "title" => "Roles",
                "icon" => "fa fa-tags",
                "value" => $this->model->select_count_roles()['CantidadRoles'],
                "link" => base_url() . "/roles",
                "text" => "Cantidad de roles existentes y activos en el sistema",
                "color" => "info",
            ],
            [
                "title" => "Espacio Disponible",
                "icon" => "fa fa-hdd-o",
                "value" => "Dispo.: 1GB de 2GB",
                "link" => base_url() . "/roles",
                "text" => "Espacio disponible en el sistema para la cuenta",
                "color" => "warning",
            ],
        ];
    }

    /**
     * Metodo que se encarga de mostrar el componente principal del los componentes del SSOMA
     * @return  string
     */
    public function index()
    {
        $arrayMacroprocess = $this->model->select_macroprocess_active();
        $url = base_url();
        $html = "";
        $html .= <<<HTML
                    <!--Listado de los macroprocesos-->
                    <div class="row"> 
                HTML;

        foreach ($arrayMacroprocess as $k => $v):
            $desc = limitarCaracteres($v["mp_description"], 50, "...");
            $dateFormat = dateFormat($v["mp_registrationDate"]);
            $urlCard = $url . '/dashboard/dashboard/' . $v["idMacroprocess"];
            $html .= $this->renderCard([
                'url' => $urlCard,
                'icon' => 'fa fa-university',
                'name' => $v["mp_name"],
                'description_full' => $v["mp_description"],
                'description_short' => $desc,
                'date' => $dateFormat
            ]);
        endforeach;
        $html .= '</div>';
        /**
         * =================================================================================================
         * Seccion de botones  flotantes
         * =================================================================================================
         */
        $timesMProcess = [
            "id" => "",
            "name" => ""
        ];
        $html .= $this->renderButtonsNavigation(
            $timesMProcess,
            0,                         // ID actual
            "",        // baseUrl
            "",          // backUrl
            "id",                       // clave ID
            "name",                          // clave nombre
            [                                   // opciones
                'showBack' => false,
                'showReload' => true,
                'showPrev' => false,
                'showNext' => false,
            ]
        );
        $html .= <<<HTML
                    <script>
                        $(function () {
                            $(`[data-toggle="tooltip"]`).tooltip({
                                        trigger: `hover`
                                    })
                                })
                  </script>
                  HTML;
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
        $url = base_url();
        $html = "";
        //renderisamos la cabezera y breadcrumbs
        $html .= $this->renderHeadAndBreadcrumbs([
            "name" => $data["mp_name"],
            "icon" => "fa fa-university",
            "description" => $data["mp_description"],
            "url" => $url . "/dashboard/dashboard",
            "macroprocess" => [
                "name" => $data["mp_name"],
                "id" => $data["idMacroprocess"],
                'icon' => 'fa fa-university'
            ],
        ]);
        $html .= <<<HTML
                        <!--Listado de los macroprocesos-->
                        <div class="row">
                    HTML;
        foreach ($dataProcess as $k => $v):
            $desc = limitarCaracteres($v["p_description"], 50, "...");
            $dateFormat = dateFormat($v["p_registrationDate"]);
            $urlCard = $url . '/dashboard/dashboard/' . $data["idMacroprocess"] . '/' . $v["idProcess"];
            $html .= $this->renderCard([
                'url' => $urlCard,
                'icon' => 'fa fa-bookmark',
                'name' => $v["p_name"],
                'description_full' => $v["p_description"],
                'description_short' => $desc,
                'date' => $dateFormat
            ]);

        endforeach;
        $html .= ' </div>';
        //metodo que se encarga de configurar los botones de navegacion
        $arrayMacroprocess = $this->model->select_macroprocess_active();
        $position = 0;
        $timesMProcess = [];
        foreach ($arrayMacroprocess as $key => $value) {
            if ($value['idMacroprocess'] == $id) {
                $currentId = $value['idMacroprocess'];
            }
            $timesMProcess[$key] = [
                "id" => $value['idMacroprocess'],
                "name" => $value['mp_name']
            ];
        }
        $urlLevelUp = $url . '/dashboard/dashboard';
        $baseUrl = $url . '/dashboard/dashboard';
        $html .= $this->renderButtonsNavigation(
            $timesMProcess,
            $currentId,                         // ID actual
            $baseUrl,        // baseUrl
            $urlLevelUp,          // backUrl
            "id",                       // clave ID
            "name",                          // clave nombre
            [                                   // opciones
                'showBack' => true,
                'showReload' => true,
                'showPrev' => true,
                'showNext' => true,
            ]
        );
        $html .= <<<HTML
                    <script>
                        $(function () {
                            $(`[data-toggle="tooltip"]`).tooltip({
                                        trigger: `hover`
                                    })
                                })
                    </script>
                  HTML;
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
        $url = base_url();
        $html = "";
        //renderisamos la cabezera y breadcrumbs
        $html .= $this->renderHeadAndBreadcrumbs([
            "name" => $data['Process']["p_name"],
            "icon" => "fa fa-bookmark",
            "description" => $data['Process']["p_description"],
            "url" => $url . "/dashboard/dashboard",
            "macroprocess" => [
                "name" => $data['Macroprocess']["mp_name"],
                "id" => $idMacroprocess,
                'icon' => 'fa fa-university'
            ],
            "process" => [
                "name" => $data['Process']["p_name"],
                "id" => $data['Process']["idProcess"],
                'icon' => 'fa fa-bookmark'
            ]
        ]);
        //elemento contenido
        $html .= <<<HTML
                    <!--Listado de los macroprocesos-->
                    <div class="row">
                HTML;
        foreach ($dataThread as $k => $v):
            // Icono dinámico según tipo de thread
            $icon = match ($v['t_type']) {
                "open_menu" => "fa fa-bars",
                "open_file" => "fa fa-file",
                "open_form" => "fa fa-pencil",
                default => "fa fa-exclamation",
            };
            $desc = limitarCaracteres($v["t_description"], 50, "...");
            $dateFormat = dateFormat($v["t_registrationDate"]);
            $urlCard = $url . '/dashboard/dashboard/' . $idMacroprocess . '/' . $data['Process']["idProcess"] . '/' . $v["idThreads"];
            $html .= $this->renderCard([
                'url' => $urlCard,
                'icon' => $icon,
                'name' => $v["t_name"],
                'description_full' => $v["t_description"],
                'description_short' => $desc,
                'date' => $dateFormat
            ]);
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
            <button class="btn btn-warning" title="Subir un nivel" onclick="window.location.href=`' . base_url() . '/dashboard/dashboard/' . $idMacroprocess . '`">
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
     * Método que obtiene los subthreads hijos de un thread específico
     * y renderiza toda la vista (breadcrumbs, subthreads, navegación).
     *
     * @param array $arrids  Arreglo de IDs que representan la ruta de navegación.
     *                       Ejemplo: [1, 2, 3, 4] (Macroprocess, Process, Thread padre, Thread hijo actual).
     * @param array $data    Información adicional de Macroprocess y Process obtenida del modelo.
     *
     * @return string        HTML completo para renderizar en la vista.
     */
    public function subthread_by_thread_by_process_by_macroprocess(array $arrids, array $data)
    {
        // Identificadores base
        $idThread = end($arrids); // último ID = thread actual
        $idMacro = $data['Macroprocess']["idMacroprocess"];
        $idProcess = $data['Process']["idProcess"];
        $dataThread = $this->model->select_thread_id($idThread);
        $baseUrl = base_url() . '/dashboard/dashboard';

        // 1. Renderizamos la cabezera y breadcrumbs
        $html = $this->renderHeadAndBreadcrumbs([
            "name" => $dataThread['t_name'],
            "icon" => "fa fa-tag",
            "description" => $dataThread['t_description'],
            "url" => $baseUrl,
            "macroprocess" => [
                "name" => $data['Macroprocess']["mp_name"],
                "id" => $idMacro,
                'icon' => 'fa fa-university'
            ],
            "process" => [
                "name" => $data['Process']["p_name"],
                "id" => $idProcess,
                'icon' => 'fa fa-bookmark'
            ],
            "dataIds" => $arrids
        ]);
        // 2. Renderizamos las tarjetas de subthreads
        $dataSubthreads = $this->model->select_subthread_associed_thread_associed_process_associed_macroprocess(
            $idProcess,
            $idMacro,
            $idThread
        );
        $html .= '<div class="row">';
        foreach ($dataSubthreads as $sub => $v) {
            // Armamos URL dinámica
            $url = "$baseUrl/$idMacro/$idProcess/" . implode("/", array_slice($arrids, 2));
            //adicionamos el id del subthread
            $url .= '/' . $v["idThreads"];
            // $html .= $this->renderCard($sub, $baseUrl, $idMacro, $idProcess, $arrids);
            $desc = limitarCaracteres($v["t_description"], 50, "...");
            $dateFormat = dateFormat($v["t_registrationDate"]);
            // Icono dinámico según tipo de thread
            $icon = match ($v['t_type']) {
                "open_menu" => "fa fa-bars",
                "open_file" => "fa fa-file",
                "open_form" => "fa fa-pencil",
                default => "fa fa-exclamation",
            };
            $html .= $this->renderCard([
                'url' => $url,
                'icon' => $icon,
                'name' => $v["t_name"],
                'description_full' => $v["t_description"],
                'description_short' => $desc,
                'date' => $dateFormat
            ]);
        }
        $html .= '</div>';

        // 3. Renderizamos botones de navegación flotantes
        // Obtenemos los threads hermanos para saber posición
        $arrayProcess = $this->model->select_subthread_associed_thread_associed_process_associed_macroprocess(
            $idProcess,
            $idMacro,
            $dataThread["threads_father"]
        );
        // URL base para subir nivel
        $urlFinal = "$baseUrl/$idMacro/$idProcess/" . implode("/", array_slice($arrids, 2, -1));

        $html .= $this->renderButtonsNavigation(
            $arrayProcess,
            $idThread,                         // ID actual
            $urlFinal,        // baseUrl
            $urlFinal,          // backUrl
            "idThreads",                       // clave ID
            "t_name",                          // clave nombre
            [                                   // opciones
                'showBack' => true,
                'showReload' => true,
                'showPrev' => true,
                'showNext' => true,
            ]
        );
        // 4. Activamos tooltips con jQuery
        $html .= <<<HTML
                    <script>
                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip({ trigger: 'hover' });
                        });
                    </script>
                    HTML;

        return $html;
    }
    /**
     * Renderización dinámica de encabezado y breadcrumbs de navegación.
     *
     * Este método construye de forma programática el bloque superior de una vista,
     * compuesto por un encabezado principal (título, ícono y descripción) y una
     * lista de breadcrumbs que representan la ruta jerárquica de navegación
     * dentro del sistema.
     *
     * La estructura está basada en componentes de **Bootstrap 4**, utilizando clases
     * utilitarias para colores, tipografía y espaciado. Además, incorpora íconos
     * de **FontAwesome**.
     *
     * --- Estructura esperada del array `$data` ---
     * El parámetro `$data` debe contener la siguiente información:
     *
     * - **url** (string): Ruta base del módulo o componente.
     * - **icon** (string): Clase CSS de FontAwesome para el ícono principal.
     * - **name** (string): Nombre o título principal de la vista.
     * - **description** (string): Texto descriptivo que se muestra debajo del título.
     * - **macroprocess** (array): Información del macroproceso actual:
     *    - **id** (int|string): Identificador único del macroproceso.
     *    - **icon** (string): Clase de ícono FontAwesome asociada.
     *    - **name** (string): Nombre del macroproceso.
     * - **process** *(opcional, array)*: Información del proceso asociado:
     *    - **id** (int|string): Identificador del proceso.
     *    - **icon** (string): Clase de ícono FontAwesome asociada.
     *    - **name** (string): Nombre del proceso.
     * - **dataIds** *(opcional, array)*: Identificadores jerárquicos adicionales (threads)
     *   que representan subniveles dentro del breadcrumb.  
     *   Cada `id` se utiliza para recuperar datos mediante el método 
     *   `select_thread_id($id)` del modelo.
     *
     * --- Ejemplo de uso ---
     * ```php
     * $data = [
     *     'url' => 'https://ejemplo.com/dashboard',
     *     'icon' => 'fa fa-cogs',
     *     'name' => 'Gestión de Procesos',
     *     'description' => 'Panel de control de macroprocesos y procesos',
     *     'macroprocess' => [
     *         'id' => 1,
     *         'icon' => 'fa fa-sitemap',
     *         'name' => 'Macroproceso Principal'
     *     ],
     *     'process' => [
     *         'id' => 2,
     *         'icon' => 'fa fa-cog',
     *         'name' => 'Proceso Secundario'
     *     ],
     *     'dataIds' => [1, 2, 15, 27] // Threads jerárquicos adicionales
     * ];
     *
     * echo $this->renderHeadAndBreadcrumbs($data);
     * ```
     *
     * --- Salida generada ---
     * Se construye un bloque HTML similar a:
     * ```html
     * <div class="app-title pt-5">
     *   <div class="w-100">
     *     <h1 class="text-primary mb-3">
     *       <i class="fa fa-cogs"></i> Gestión de Procesos
     *     </h1>
     *     <p class="mb-2">Panel de control de macroprocesos y procesos</p>
     *     <hr class="w-100">
     *     <ul class="app-breadcrumb breadcrumb bg-primary text-white p-2">
     *       <li class="breadcrumb-item">
     *         <a href="https://ejemplo.com/dashboard" class="text-white">
     *           <i class="fa fa-globe fa-lg"></i>
     *         </a>
     *       </li>
     *       <li class="breadcrumb-item">
     *         <a href="https://ejemplo.com/dashboard/1" class="text-white">
     *           <i class="fa fa-sitemap"></i> Macroproceso Principal
     *         </a>
     *       </li>
     *       <li class="breadcrumb-item">
     *         <a href="https://ejemplo.com/dashboard/1/2" class="text-white">
     *           <i class="fa fa-cog"></i> Proceso Secundario
     *         </a>
     *       </li>
     *       <li class="breadcrumb-item">
     *         <a href="https://ejemplo.com/dashboard/1/2/15" class="text-white">
     *           <i class="fa fa-cogs"></i> Subnivel Thread
     *         </a>
     *       </li>
     *     </ul>
     *   </div>
     * </div>
     * ```
     *
     * --- Notas importantes ---
     * - Si no existe `process`, el breadcrumb se cierra después de `macroprocess`.
     * - Si existe `dataIds`, se itera a partir del tercer elemento (`array_slice($data['dataIds'], 2)`),
     *   concatenando la URL y obteniendo la información de cada thread desde el modelo.
     * - Si no existe `dataIds`, el breadcrumb se cierra sin añadir más niveles.
     *
     * @param  array $data Datos necesarios para construir el encabezado y breadcrumbs.
     * @return string HTML generado con la estructura completa del encabezado y breadcrumbs.
     */
    private function renderHeadAndBreadcrumbs(array $data): string
    {
        $html = "";
        // Encabezado principal
        $html .= <<<HTML
            <div class="app-title pt-5">
                <div class="w-100">
                    <h1 class="text-primary mb-3"><i class="{$data['icon']}"></i>{$data['name']}</h1>
                    <p class="mb-2">{$data['description']}</p>
                    <hr class="w-100">
                        <ul class="app-breadcrumb breadcrumb bg-primary text-white p-2">
                            <li class="breadcrumb-item"><a
                                    href="{$data['url']}" class="text-white"><i class="fa fa fa-globe fa-lg"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{$data['url']}/{$data['macroprocess']['id']}" class="text-white"><i class="{$data['macroprocess']['icon']}"></i> {$data['macroprocess']['name']}</a></li>
        HTML;

        // Validación: si existe un proceso
        if (isset($data['process'])) {
            $html .= <<<HTML
                            <li class="breadcrumb-item"><a
                                    href="{$data['url']}/{$data['macroprocess']['id']}/{$data['process']['id']}" class="text-white"><i class="{$data['process']['icon']}"></i> {$data['process']['name']}</a></li>
            HTML;
        } else {
            $html .= <<<HTML
                        </ul>
                 </div>                       
            </div>
            HTML;
        }

        // Validación: si existen threads adicionales (dataIds)
        if (isset($data['dataIds'])) {
            $url = $data['url'] . '/' . $data['macroprocess']['id'] . "/" . $data['process']['id'];

            // Iteramos threads intermedios
            foreach (array_slice($data['dataIds'], 2) as $threadId) {
                $url .= "/$threadId";
                $infoThread = $this->model->select_thread_id($threadId);
                $html .= <<<HTML
                                <li class="breadcrumb-item">
                                    <a href="$url" class="text-white"><i class="{$data['icon']}"></i> {$infoThread["t_name"]}</a>
                                </li>
                HTML;
            }

            $html .= <<<HTML
                        </ul>
                </div>                       
            </div>
            HTML;
        } else {
            $html .= <<<HTML
                        </ul>
                </div>                       
            </div>
            HTML;
        }

        return $html;
    }
    /**
     * Renderiza un conjunto de botones flotantes de navegación dinámicos.
     *
     * Este método genera los botones de navegación "Anterior", "Siguiente",
     * "Subir un nivel" y "Recargar", en base a una lista de elementos ordenados
     * y el elemento actualmente activo. Se adapta a los datos recibidos mediante
     * un array asociativo y permite configurar qué botones mostrar u ocultar.
     *
     * Los botones están diseñados con Bootstrap 4 (`btn`, `btn-primary`, etc.)
     * y utilizan íconos de FontAwesome. Se devuelven dentro de un contenedor
     * `<div class="floating-buttons">`, lo que permite su ubicación flotante 
     * mediante CSS personalizado.
     *
     * --- Parámetros ---
     * @param array  $items     Lista ordenada de elementos para navegación.
     *                          Cada elemento debe ser un array asociativo que incluya:
     *                          - `$idKey`   (por defecto: `id`)   → identificador único.
     *                          - `$nameKey` (por defecto: `name`) → etiqueta/nombre descriptivo.
     * 
     * @param mixed  $currentId Identificador del elemento actual. Debe coincidir con `$idKey` de `$items`.
     *
     * @param string $baseUrl   URL base para construir enlaces de navegación
     *                          (se concatena con el ID del elemento destino).
     *
     * @param string $backUrl   URL usada en el botón "Subir un nivel" (default: "#").
     *
     * @param string $idKey     Nombre de la clave que identifica el ID en `$items` (default: "id").
     *
     * @param string $nameKey   Nombre de la clave que identifica el nombre/etiqueta en `$items` (default: "name").
     *
     * @param array  $options   Opciones adicionales para personalizar la visibilidad de los botones:
     *                          - `showBack`   (bool, default: true) → Mostrar botón "Subir un nivel".
     *                          - `showReload` (bool, default: true) → Mostrar botón "Recargar".
     *                          - `showPrev`   (bool, default: true) → Mostrar botón "Anterior".
     *                          - `showNext`   (bool, default: true) → Mostrar botón "Siguiente".
     *
     * --- Ejemplo de uso ---
     * ```php
     * $items = [
     *     ['id' => 1, 'name' => 'Introducción'],
     *     ['id' => 2, 'name' => 'Capítulo 1'],
     *     ['id' => 3, 'name' => 'Capítulo 2'],
     * ];
     * 
     * echo $this->renderButtonsNavigation(
     *     $items,
     *     2,                        // ID actual
     *     '/dashboard/view',        // baseUrl
     *     '/dashboard',             // backUrl
     *     'id', 'name',             // claves
     *     ['showReload' => false]   // desactiva el botón "Recargar"
     * );
     * ```
     *
     * --- Salida generada ---
     * Ejemplo de bloque HTML devuelto:
     * ```html
     * <div class="floating-buttons">
     *   <button class="btn btn-primary" title="Anterior - Introducción" 
     *       onclick="window.location.href='/dashboard/view/1'">
     *       <i class="fa fa-arrow-left"></i>
     *   </button>
     *   <button class="btn btn-warning" title="Subir un nivel" 
     *       onclick="window.location.href='/dashboard'">
     *       <i class="fa fa-arrow-up"></i>
     *   </button>
     *   <button class="btn btn-primary" title="Siguiente - Capítulo 2" 
     *       onclick="window.location.href='/dashboard/view/3'">
     *       <i class="fa fa-arrow-right"></i>
     *   </button>
     * </div>
     * ```
     *
     * --- Consideraciones ---
     * - Si `$currentId` no se encuentra en `$items`, no se mostrarán botones "Anterior" ni "Siguiente".
     * - Es recomendable sanitizar las variables `$baseUrl` y `$backUrl` en escenarios con entrada externa.
     * - Los estilos flotantes (`.floating-buttons`) deben definirse en CSS para posicionar el contenedor.
     *
     * @return string HTML generado con los botones de navegación.
     */
    private function renderButtonsNavigation(
        array $items,
        $currentId,
        string $baseUrl,
        string $backUrl = "#",
        string $idKey = "id",
        string $nameKey = "name",
        array $options = []
    ): string {
        $defaults = [
            'showBack' => true,
            'showReload' => true,
            'showPrev' => true,
            'showNext' => true,
        ];
        $options = array_merge($defaults, $options);

        // Buscar posición del elemento actual
        $position = array_search($currentId, array_column($items, $idKey));
        $btnLeft = $btnRight = $btnUp = $btnReload = "";

        // Botón "Anterior"
        if ($options['showPrev'] && $position > 0) {
            $prev = $items[$position - 1];
            $btnLeft = <<<HTML
            <button class="btn btn-primary" title="Anterior - {$prev[$nameKey]}" 
                onclick="window.location.href='$baseUrl/{$prev[$idKey]}'">
                <i class="fa fa-arrow-left"></i>
            </button>
        HTML;
        }

        // Botón "Siguiente"
        if ($options['showNext'] && $position !== false && $position < count($items) - 1) {
            $next = $items[$position + 1];
            $btnRight = <<<HTML
            <button class="btn btn-primary" title="Siguiente - {$next[$nameKey]}" 
                onclick="window.location.href='$baseUrl/{$next[$idKey]}'">
                <i class="fa fa-arrow-right"></i>
            </button>
        HTML;
        }

        // Botón "Subir nivel"
        if ($options['showBack']) {
            $btnUp = <<<HTML
            <button class="btn btn-warning" title="Subir un nivel" onclick="window.location.href='$backUrl'">
                <i class="fa fa-arrow-up"></i>
            </button>
        HTML;
        }

        // Botón "Recargar"
        if ($options['showReload']) {
            $btnReload = <<<HTML
            <button class="btn btn-success" title="Recargar" onclick="location.reload()">
                <i class="fa fa-refresh"></i>
            </button>
        HTML;
        }

        return <<<HTML
            <div class="floating-buttons">
                $btnLeft
                $btnUp
                $btnReload
                $btnRight
            </div>
        HTML;
    }

    /**
     * Renderización de una tarjeta (card) HTML adaptable con Bootstrap y FontAwesome.
     *
     * Esta función se encarga de construir dinámicamente un bloque de tarjeta 
     * a partir de los datos recibidos en un array asociativo. El componente 
     * renderizado utiliza la estructura de Bootstrap 4 (`col-md-4`, `card`, etc.) 
     * y está optimizado para incluir un ícono, nombre, descripciones y fecha.
     * 
     * Además, se incorpora un tooltip (Bootstrap) que muestra información adicional 
     * al posicionar el cursor sobre el componente.
     *
     * --- Estructura esperada del array de entrada ---
     * El parámetro `$data` debe contener las siguientes claves obligatorias:
     * 
     * - **url** (string): URL a la cual dirigirá el enlace de la tarjeta.
     * - **icon** (string): Clase(s) CSS de FontAwesome para mostrar un ícono representativo.
     * - **name** (string): Nombre o título de la tarjeta.
     * - **description_full** (string): Descripción completa (se muestra como tooltip).
     * - **description_short** (string): Descripción resumida (se muestra en el cuerpo de la tarjeta).
     * - **date** (string): Fecha relacionada con el contenido (ejemplo: "2025-09-05").
     *
     * --- Ejemplo de uso ---
     * ```php
     * $cardData = [
     *     'url' => 'https://ejemplo.com/detalle',
     *     'icon' => 'fa fa-book',
     *     'name' => 'Documentación',
     *     'description_full' => 'Documentación técnica completa del sistema.',
     *     'description_short' => 'Resumen de la documentación.',
     *     'date' => '2025-09-05'
     * ];
     * 
     * echo $this->renderCard($cardData);
     * ```
     *
     * --- Salida generada ---
     * Devuelve un bloque HTML equivalente a:
     * ```html
     * <div class="col-md-4 mb-4">
     *   <a href="https://ejemplo.com/detalle"
     *      class="card custom-card p-4 text-center h-100"
     *      data-toggle="tooltip" data-placement="top"
     *      title="Haz clic para ver más sobre Documentación">
     *      <div class="icon-wrapper bg-primary mx-auto">
     *          <i class="fa fa-book"></i>
     *      </div>
     *      <h5>Documentación</h5>
     *      <p class="text-justify" title="Documentación técnica completa del sistema.">
     *          Resumen de la documentación.
     *      </p>
     *      <div class="date"><i class="fa fa-calendar"></i> 2025-09-05</div>
     *   </a>
     * </div>
     * ```
     *
     * @param  array $data Array asociativo con los datos de la tarjeta 
     *                     (claves: url, icon, name, description_full, description_short, date).
     * @return string HTML generado para la tarjeta lista para renderizar en la vista.
     */
    private function renderCard(array $data)
    {
        $html = "";
        $html .= <<<HTML
            <!-- Card Component -->
            <div class="col-md-4 mb-4">
                <a href="{$data['url']}"
                   class="card custom-card p-4 text-center h-100"
                   data-toggle="tooltip" data-placement="top"
                   title="Haz clic para ver más sobre {$data['name']}">
                   <div class="icon-wrapper bg-primary mx-auto">
                       <i class="{$data['icon']}"></i>
                   </div>
                   <h5>{$data['name']}</h5>
                   <p class="text-justify" title="{$data['description_full']}">
                       {$data['description_short']}
                   </p>
                   <div class="date">
                       <i class="fa fa-calendar"></i> {$data['date']}
                   </div>
                </a>
            </div>
        HTML;
        return $html;
    }
}
