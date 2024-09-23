<?php

namespace App\Http\Controllers;

use App\Models\DepartmentModel;
use App\Models\EmployeeModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;

class EmployeeController extends Controller {
    // Listar empleados con paginación, filtros y relaciones con departamentos y roles
    public function index(Request $request) {
        $employees = EmployeeModel::getEmployees($request);
        return response()->json($employees);
    }

    // Obtener empleado específico
    public function show($id) {
        $employee = EmployeeModel::getEmployeeById($id);
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    // Crear empleado
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees',
            'position' => 'required|string',
            'salary' => 'required|numeric',
            'hiring_date' => 'required|date',
            'department_id' => 'nullable|exists:departments,id',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $employeeId = EmployeeModel::createEmployee($request->only([
            'name', 'email', 'position', 'salary', 'hiring_date', 'department_id', 'role_id'
        ]));

        if (!$employeeId) {
            return response()->json(['error' => 'There was a problem creating the employee.'], 404);
        }

        return response()->json([
            'message' => 'Empleado creado exitosamente.',
            'redirect' => route('employees.index.view'),
        ]);
    }



    // Actualizar empleado
    public function update(Request $request, $id) {
        $request->validate([
            'email' => 'email|unique:employees,email,' . $id,
            'salary' => 'numeric',
        ]);

        $data = $request->only(['name', 'email', 'position', 'salary', 'hiring_date', 'department_id', 'role_id']);
        $updated = EmployeeModel::updateEmployee($id, $data);
        if (!$updated) {
            return response()->json(['error' => 'Employee not found or update failed'], 404);
        }
        return response()->json([
            'message' => 'Empleado actualizado exitosamente.',
            'redirect' => route('employees.index.view'),
        ]);
    }

    // Eliminar empleado
    public function destroy($id) {
        $deleted = EmployeeModel::deleteEmployee($id);
        if (!$deleted) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        return response()->json([
            'message' => 'Empleado eliminado exitosamente.',
            'redirect' => route('employees.index.view'), // Redirigir a la lista de empleados
        ]);
    }

    public function indexView(Request $request) {
        $employees = EmployeeModel::getEmployees($request); // O una paginación adecuada
        $departments = DepartmentModel::getAllDepartments();
        return view('employees.index', data: compact('employees', 'departments'));
    }

    public function createView() {
        $departments = DepartmentModel::getAllDepartments();
        $roles = RoleModel::getAllRoles();

        return view('employees.create', compact('departments', 'roles'));
    }

    public function editView($id) {
        $employee = EmployeeModel::getEmployeeById($id); // O una paginación adecuada
        $departments = DepartmentModel::getAllDepartments();
        $roles = RoleModel::getAllRoles();

        return view('employees.edit', compact('employee', 'departments', 'roles'));
    }

    public function showView($id) {
        $employee = EmployeeModel::getEmployeeById($id);
        if (!$employee) {
            abort(404);
        }
        return view('employees.show', compact('employee'));
    }
}
