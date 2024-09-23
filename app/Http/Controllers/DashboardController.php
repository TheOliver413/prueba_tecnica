<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        // Contar empleados usando SQL manual
        $totalEmployees = DB::table('employees')->where('deleted', operator: false)->count();
        $totalRoles = DB::table('roles')->count();
        $totalDepartments = DB::table('departments')->count();

        // Obtener empleados recientes
        $recentEmployees = DB::select('
            SELECT e.*,
                d.name as department_name,
                r.name as role_name
            FROM employees e
            LEFT JOIN departments d
                ON e.department_id = d.id
            LEFT JOIN roles r
                ON e.role_id = r.id
            WHERE e.deleted = false
            ORDER BY e.hiring_date DESC
            LIMIT 5
        ');

        // Obtener distribución de empleados por departamento
        $departmentData = DB::select('
            SELECT d.name,
                COUNT(e.id) as employee_count
            FROM departments d
            LEFT JOIN employees e
                ON e.department_id = d.id
            WHERE e.deleted = false
            GROUP BY d.name
        ');

        // Preparar los datos para el gráfico
        $departmentLabels = array_column($departmentData, 'name');
        $departmentCounts = array_column($departmentData, 'employee_count');

        // Pasar los datos a la vista
        return view('dashboard', [
            'totalEmployees' => $totalEmployees,
            'totalRoles' => $totalRoles,
            'totalDepartments' => $totalDepartments,
            'recentEmployees' => $recentEmployees,
            'departmentLabels' => $departmentLabels,
            'departmentCounts' => $departmentCounts
        ]);
    }
}
