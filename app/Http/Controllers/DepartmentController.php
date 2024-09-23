<?php

namespace App\Http\Controllers;

use App\Models\DepartmentModel;
use Illuminate\Http\Request;

class DepartmentController extends Controller {
    // Listar departamentos
    public function index() {
        $departments = DepartmentModel::getAllDepartments();
        return response()->json($departments);
    }

    // Obtener departamento específico
    public function show($id) {
        $department = DepartmentModel::getDepartmentById($id);

        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        return response()->json($department);
    }

    // Crear nuevo departamento
    public function store(Request $request) {
        $request->validate(['name' => 'required|string']);
        $data = $request->all();
        DepartmentModel::createDepartment($data);
        return response()->json(['message' => 'Department created successfully'], 201);
    }

    // Actualizar departamento
    public function update(Request $request, $id) {
        $request->validate(['name' => 'required|string']);
        $data = $request->all();
        DepartmentModel::updateDepartment($id, $data);
        return response()->json(['message' => 'Department updated successfully']);
    }

    // Eliminar departamento
    public function destroy($id) {
        DepartmentModel::deleteDepartment($id);
        return response()->json(['message' => 'Department deleted successfully']);
    }
}
