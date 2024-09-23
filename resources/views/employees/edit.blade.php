@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h3 mb-0">Editar Empleado</h1>
                    </div>
                    <div class="card-body">
                        <form id="editEmployeeForm" action="{{ route('employees.update', $employee->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        value="{{ $employee->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="position" class="form-label">Cargo</label>
                                    <input type="text" class="form-control" id="position" name="position" required
                                        value="{{ $employee->position }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        value="{{ $employee->email }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="salary" class="form-label">Salario</label>
                                    <input type="number" class="form-control" id="salary" name="salary" required
                                        value="{{ $employee->salary }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="hiring_date" class="form-label">Fecha de Contratación</label>
                                    <input type="date" class="form-control" id="hiring_date" name="hiring_date" required
                                        value="{{ $employee->hiring_date }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="department_id" class="form-label">Departamento</label>
                                    <select class="form-select" id="department_id" name="department_id">
                                        <option value="">Seleccione un departamento</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
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
                                            <option value="{{ $role->id }}"
                                                {{ $employee->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Mensaje -->
    <div id="messageModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resultado de Actualización</h5>
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

    <script>
        document.getElementById('editEmployeeForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const form = event.target;

            fetch(form.action, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: form.name.value,
                    email: form.email.value,
                    position: form.position.value,
                    salary: form.salary.value,
                    hiring_date: form.hiring_date.value,
                    department_id: form.department_id.value,
                    role_id: form.role_id.value,
                }),
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message);
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect; // Redirigir después de 2 segundos
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Ocurrió un error al actualizar el empleado.');
            });
        });

        function closeMessageModal() {
            const modal = document.getElementById('messageModal');
            modal.style.display = 'none';
        }

        function showMessage(message) {
            const messageText = document.getElementById('messageText');
            messageText.textContent = message;
            const modal = document.getElementById('messageModal');
            modal.style.display = 'block';
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
