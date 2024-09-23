<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Exception;

class DepartmentModel {
    protected static $table = 'departments';
    protected static $identificator = 'id';
    protected static $delete = 'deleted';

    // Obtener todos los departamentos
    public static function getAllDepartments() {
        try {
            $sql = "SELECT * FROM " . static::$table;
            return DB::select($sql);
        } catch (Exception $e) {
            // Manejar excepción
            return [];
        }
    }

    // Obtener departamento por ID
    public static function getDepartmentById($id) {
        try {
            $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$identificator . " = ?";
            return DB::selectOne($sql, [$id]);
        } catch (Exception $e) {
            // Manejar excepción
            return null;
        }
    }

    // Crear nuevo departamento
    public static function createDepartment($data) {
        try {
            $sql = "INSERT INTO " . static::$table . " (name) VALUES (?, ?)";
            return DB::insert($sql, [$data['name']]);
        } catch (Exception $e) {
            // Manejar excepción
            return false;
        }
    }

    // Actualizar departamento
    public static function updateDepartment($id, $data) {
        try {
            $sql = "UPDATE " . static::$table . " SET name = ?, modified_at = NOW() WHERE " . static::$identificator . " = ?";
            return DB::update($sql, [$data['name'], $id]);
        } catch (Exception $e) {
            // Manejar excepción
            return false;
        }
    }

    // Eliminar departamento
    public static function deleteDepartment($id) {
        try {
            $sql = "UPDATE " . static::$table . " SET " . static::$delete . " = 1 WHERE " . static::$identificator . " = ?";
            return DB::update($sql, [$id]);
        } catch (Exception $e) {
            // Manejar excepción
            return false;
        }
    }
}
