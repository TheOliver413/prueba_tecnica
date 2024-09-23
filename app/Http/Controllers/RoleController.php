<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use Illuminate\Http\Request;

class RoleController extends Controller {
    // Listar roles
    public function index() {
        $roles = RoleModel::getAllRoles();
        return response()->json($roles);
    }

    // Obtener rol específico
    public function show($id) {
        $role = RoleModel::getRoleById($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        return response()->json($role);
    }

    // Crear nuevo rol
    public function store(Request $request) {
        $request->validate(['name' => 'required|string']);
        $data = $request->all();
        RoleModel::createRole($data);
        return response()->json(['message' => 'Role created successfully'], 201);
    }

    // Actualizar rol
    public function update(Request $request, $id) {
        $request->validate(['name' => 'required|string']);
        $data = $request->all();
        RoleModel::updateRole($id, $data);
        return response()->json(['message' => 'Role updated successfully']);
    }

    // Eliminar rol
    public function destroy($id) {
        RoleModel::deleteRole($id);
        return response()->json(['message' => 'Role deleted successfully']);
    }
}
