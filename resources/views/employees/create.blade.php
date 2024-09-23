@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">Agregar Empleado</h1>
                </div>
                <div class="card-body">
                    <form id="employeeForm" action="{{ route('employees.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="position" class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="salary" class="form-label">Salario</label>
                                <input type="number" class="form-control" id="salary" name="salary" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="hiring_date" class="form-label">Fecha de Contratación</label>
                                <input type="date" class="form-control" id="hiring_date" name="hiring_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="department_id" class="form-label">Departamento</label>
                                <select class="form-select" id="department_id" name="department_id">
                                    <option value="">Seleccione un departamento</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="role_id" class="form-label">Rol</label>
                                <select class="form-select" id="role_id" name="role_id">
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('employees.index.view') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Mensaje -->
    <div id="messageModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resultado de Creación</h5>
                    <button type="button" class="close" onclick="closeMessageModal()">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="messageText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeMessageModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('employeeForm').onsubmit = function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            const messageText = document.getElementById('messageText');
            const modal = document.getElementById('messageModal');
            if (data.error) {
                messageText.textContent = data.error;
            } else {
                messageText.textContent = data.message;
                // Redirigir después de mostrar el mensaje
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            }
            modal.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Ocurrió un error al crear el empleado.');
        });
    }

    function closeMessageModal() {
        const modal = document.getElementById('messageModal');
        modal.style.display = 'none';
    }
</script>

<style>
    .fade-in {
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>
@endsection
