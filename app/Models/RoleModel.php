<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Exception;

class RoleModel {
    protected static $table = 'roles';
    protected static $identificator = 'id';
    protected static $delete = 'deleted';

    // Obtener todos los roles
    public static function getAllRoles() {
        try {
            $sql = "SELECT * FROM " . static::$table;
            return DB::select($sql);
        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener rol por ID
    public static function getRoleById($id) {
        try {
            $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$identificator . " = ?";
            return DB::selectOne($sql, [$id]);
        } catch (Exception $e) {
            return null;
        }
    }

    // Crear nuevo rol
    public static function createRole($data) {
        try {
            $sql = "INSERT INTO " . static::$table . " (name) VALUES (?, ?)";
            return DB::insert($sql, [$data['name']]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Actualizar rol
    public static function updateRole($id, $data) {
        try {
            $sql = "UPDATE " . static::$table . " SET name = ?, modified_at = NOW() WHERE " . static::$identificator . " = ?";
            return DB::update($sql, [$data['name'], $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Eliminar rol
    public static function deleteRole($id) {
        try {
            $sql = "UPDATE " . static::$table . " SET " . static::$delete . " = 1 WHERE " . static::$identificator . " = ?";
            return DB::update($sql, [$id]);
        } catch (Exception $e) {
            return false;
        }
    }
}
