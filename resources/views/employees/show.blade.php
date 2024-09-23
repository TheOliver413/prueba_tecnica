@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">Detalles del Empleado</h1>
                    <a href="{{ route('employees.index.view') }}" class="btn btn-light btn-sm">Volver a la Lista</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h2 class="h4 mb-3">Información Personal</h2>
                            <p><strong>Nombre:</strong> {{ $employee->name }}</p>
                            <p><strong>Email:</strong> {{ $employee->email }}</p>
                            <p><strong>Cargo:</strong> {{ $employee->position }}</p>
                        </div>
                        <div class="col-md-6">
                            <h2 class="h4 mb-3">Información Laboral</h2>
                            <p><strong>Salario:</strong> ${{$employee->salary}}</p>
                            <p><strong>Fecha de Contratación:</strong> {{ \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') }}</p>
                            <p><strong>Antigüedad:</strong> {{ \Carbon\Carbon::parse($employee->hiring_date)->diffForHumans(null, true) }}</p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h2 class="h4 mb-3">Departamento</h2>
                            <p>{{ $employee->department_name ?? 'No asignado' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h2 class="h4 mb-3">Rol</h2>
                            <p>{{ $employee->role_name ?? 'No asignado' }}</p>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="{{ route('employees.edit.view', $employee->id) }}" class="btn btn-primary">Editar Empleado</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
