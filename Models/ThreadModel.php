<?php
class ThreadModel extends Mysql
{
    private string $name;
    private string $description;
    private string $status;
    private int $id;
    private int $macroprocess_id;
    private int $process_id;
    private int $threads_father;
    private string $type;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Funcion que se encarga de la seleccion de todos los macroprocesos con sus procesos asociados
     * @return array
     */
    public function select_thread_inner_process_inner_macroprocess(): array
    {
        $query = "SELECT
                        tbmp.mp_name,
                        tbp.macroprocess_id,
                        tbp.p_name,
                        tbt.*
                    FROM
                        tb_threads AS tbt
                        INNER JOIN tb_process AS tbp ON tbp.idProcess = tbt.process_id
                        INNER JOIN tb_macroprocess AS tbmp ON tbmp.idMacroprocess = tbp.macroprocess_id
                    ORDER BY
                        tbt.idThreads DESC;";
        $request = $this->select_all($query, []);
        return $request;
    }
    /**
     * Metodo que se encarga de traer todos los subprocesos asociados al proceso
     */
    public function select_threads_by_process_id(int $process_id): array
    {
        $this->process_id = $process_id;
        $query = "SELECT * FROM tb_threads WHERE process_id = ? AND t_type='open_menu'";
        $request = $this->select_all($query, [$this->process_id]);
        return $request;
    }
    /**
     * Metodo que se encarga de registrar un nuevo subproceso
     * @param string $name
     * @param string $description
     * @param int $process_id
     * @param int $threads_father
     * @param string $type
     * @return bool|int|string
     */
    public function insert_thread(string $name, string $description, int $process_id, int $threads_father, string $type)
    {
        $this->name = $name;
        $this->description = $description;
        $this->process_id = $process_id;
        $this->threads_father = $threads_father;
        $this->type = $type;
        $sql = "INSERT INTO 
                        `tb_threads` (`t_name`, `t_description`, `process_id`, `threads_father`, `t_type`) 
                VALUES 
                        (?, ?, ?, ?, ?);";
        $request = $this->insert($sql, [
            $this->name,
            $this->description,
            $this->process_id,
            $this->threads_father == 0 ? null : $this->threads_father,
            $this->type
        ]);
        return $request;
    }
    /**
     * Metodo que permite obtener un subproceso por su id
     * @param int $id
     * @return array
     */
    public function select_thread_by_id(int $id): array
    {
        $query = "SELECT * FROM tb_threads WHERE idThreads = ?";
        $request = $this->select($query, [$id]);
        return $request;
    }    /**
         * Metodo que permite eliminar un subproceso
         * @param int $id
         * @return bool
         */
    public function delete_thread(int $id): bool
    {
        $query = "DELETE FROM tb_threads WHERE idThreads = ?";
        $request = $this->delete($query, [$id]);
        return $request;
    }
    /**
     * Metodo que permite verificar si un subproceso tiene subprocesos hijos
     * @param int $id
     * @return bool
     */
    public function has_children_threads(int $id): bool
    {
        $this->threads_father = $id;
        $query = "SELECT COUNT(*) as count FROM tb_threads WHERE threads_father = ?";
        $request = $this->select($query, [$this->threads_father]);
        return $request['count'] > 0;
    }
    /**
     * Obtiene todos los macroprocesos, procesos y sus threads asociados
     * (incluyendo subthreads de forma recursiva hasta N niveles).
     *
     * @return array Estructura jerárquica de macroprocesos → procesos → threads → subthreads
     */
    public function select_all_macroprocesses_and_processes_with_children()
    {
        // 1. Consultamos todos los macroprocesos activos
        $queryMacro = "SELECT tbm.idMacroprocess, tbm.mp_name 
                   FROM tb_macroprocess AS tbm 
                   WHERE tbm.mp_status = 'Activo';";

        $requestMacro = $this->select_all($queryMacro, []);

        // 2. Recorremos cada macroproceso
        foreach ($requestMacro as $key => $value) {

            // 2.1. Consultamos los procesos activos asociados a este macroproceso
            $queryProcess = "SELECT tbp.idProcess, tbp.p_name, tbp.macroprocess_id 
                         FROM tb_process AS tbp 
                         WHERE tbp.p_status = 'Activo' 
                         AND tbp.macroprocess_id = ?";

            $requestMacro[$key]['Procesos'] = $this->select_all($queryProcess, [$value['idMacroprocess']]);

            // 2.2. Para cada proceso, obtenemos sus threads de manera recursiva
            foreach ($requestMacro[$key]['Procesos'] as $keyProcess => $valueProcess) {
                $requestMacro[$key]['Procesos'][$keyProcess]['Threads'] =
                    $this->getThreadsRecursively($valueProcess['idProcess'], null);
            }
        }

        // 3. Retornamos la estructura completa
        $data = array(
            "N1" => "SSOMA",   // ejemplo de dato raíz adicional
            "Macroprocesos" => $requestMacro
        );

        return $data;
    }

    /**
     * Función recursiva que obtiene los threads asociados a un proceso o subthread.
     *
     * @param int $processId   ID del proceso al que pertenecen los threads
     * @param int|null $parentId ID del thread padre (null si son threads raíz)
     * 
     * @return array Lista de threads con sus respectivos subthreads
     */
    private function getThreadsRecursively($processId, $parentId = null)
    {
        // 1. Armamos la consulta dependiendo si buscamos threads raíz o hijos
        if ($parentId === null) {
            // Threads raíz (sin padre)
            $query = "SELECT t.idThreads, t.t_name, t.t_description, 
                         t.process_id, t.threads_father, t.t_type
                  FROM tb_threads AS t
                  WHERE t.process_id = ? 
                  AND t.t_status = 'Activo'
                  AND t.threads_father IS NULL";

            $params = [$processId];
        } else {
            // Threads hijos de un padre específico
            $query = "SELECT t.idThreads, t.t_name, t.t_description, 
                         t.process_id, t.threads_father, t.t_type
                  FROM tb_threads AS t
                  WHERE t.threads_father = ? 
                  AND t.t_status = 'Activo'";

            $params = [$parentId];
        }

        // 2. Ejecutamos la consulta
        $threads = $this->select_all($query, $params);

        // 3. Para cada thread encontrado, buscamos sus hijos recursivamente
        foreach ($threads as $key => $thread) {
            $threads[$key]['SubThreads'] = $this->getThreadsRecursively($processId, $thread['idThreads']);
        }

        // 4. Retornamos la lista de threads con su jerarquía completa
        return $threads;
    }

}
