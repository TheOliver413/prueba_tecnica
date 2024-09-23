<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Exception;

class EmployeeModel {
    protected static $table = 'employees';
    protected static $identificator = 'id';
    protected static $delete = 'deleted';

    // Obtener empleados con paginación y filtros
    public static function getEmployees($request) {
        try {
            // Contar el total de empleados
            $sqlCount = "SELECT COUNT(*) as total FROM " . static::$table . " WHERE deleted = false";
            $total = DB::selectOne($sqlCount)->total;

            // Consulta principal
            $sql = "SELECT e.*,
                        d.name AS department_name,
                        r.name AS role_name,
                        CASE
                            WHEN e.salary > dept_avg.avg_salary THEN 'above'
                            WHEN e.salary < dept_avg.avg_salary THEN 'below'
                            ELSE 'average'
                        END AS salary_comparison
                    FROM " . static::$table . " e
                    LEFT JOIN departments d ON e.department_id = d.id
                    LEFT JOIN roles r ON e.role_id = r.id
                    LEFT JOIN (
                        SELECT department_id, AVG(salary) as avg_salary
                        FROM " . static::$table . "
                        WHERE department_id IS NOT NULL AND deleted = false
                        GROUP BY department_id
                    ) as dept_avg ON e.department_id = dept_avg.department_id
                    WHERE e.deleted = false";

            $conditions = [];
            $params = [];

            // Filtros
            if ($request->input('name')) {
                $conditions[] = "e.name LIKE ?";
                $params[] = '%' . $request->input('name') . '%';
            }
            if ($request->input('department_id')) {
                $conditions[] = "e.department_id = ?";
                $params[] = $request->input('department_id');
            }

            // Añadir condiciones si existen
            if ($conditions) {
                $sql .= " AND " . implode(" AND ", $conditions);
            }

            // Paginación
            $sql .= " LIMIT 10 OFFSET ?";
            $params[] = ($request->input('page', 1) - 1) * 10; // Desplazamiento

            $employees = DB::select($sql, $params);

            return [
                'data' => $employees,
                'total' => $total,
                'current_page' => $request->input('page', 1),
                'last_page' => ceil($total / 10),
            ];
        } catch (Exception $e) {
            if (env("APP_ENV") == "local") {
                print_r($e->getMessage());
            }
            return [];
        }
    }


    // Obtener empleado por ID
    public static function getEmployeeById($id) {
        try {
            $sql = "SELECT e.*,
                        d.name AS department_name,
                        r.name AS role_name
                    FROM " . static::$table . " e
                    LEFT JOIN departments d
                        ON e.department_id = d.id
                    LEFT JOIN roles r
                        ON e.role_id = r.id
                    WHERE e.id = ?";

            return DB::selectOne($sql, [$id]);
        } catch (Exception $e) {
            if (env("APP_ENV") == "local") {
                print_r($e->getMessage());
            }
            return null;
        }
    }

    // Crear empleado
    public static function createEmployee($data) {
        try {
            $sql = "INSERT INTO " . static::$table . " (name, email, position, salary, hiring_date, department_id, role_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $params = [
                $data['name'],
                $data['email'],
                $data['position'],
                $data['salary'],
                $data['hiring_date'],
                $data['department_id'],
                $data['role_id']
            ];

            return DB::insert($sql, $params);
        } catch (Exception $e) {
            if (env("APP_ENV") == "local") {
                print_r($e->getMessage());
            }
            return false;
        }
    }

    // Actualizar empleado
    public static function updateEmployee($id, $data) {
        try {
            $sql = "UPDATE " . static::$table . " SET
                        name = ?,
                        email = ?,
                        position = ?,
                        salary = ?,
                        hiring_date = ?,
                        department_id = ?,
                        role_id = ?,
                        modified_at = NOW()
                    WHERE id = ?";

            $params = [
                $data['name'],
                $data['email'],
                $data['position'],
                $data['salary'],
                $data['hiring_date'],
                $data['department_id'],
                $data['role_id'],
                $id
            ];

            return DB::update($sql, $params);
        } catch (Exception $e) {
            if (env("APP_ENV") == "local") {
                print_r($e->getMessage());
            }
            return false;
        }
    }

    // Eliminar empleado
    public static function deleteEmployee($id) {
        try {
            $sql = "UPDATE " . static::$table . " SET " . static::$delete . " = true, modified_at = NOW() WHERE id = ?";
            return DB::update($sql, [$id]);
        } catch (Exception $e) {
            if (env("APP_ENV") == "local") {
                print_r($e->getMessage());
            }
            return false;
        }
    }
}
