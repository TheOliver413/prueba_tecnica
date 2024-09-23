@extends('layouts.app')

@section('content')
    <main class="container mx-auto px-4 py-8 bg-gray-25">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Lista de Empleados</h1>

        <a href="{{ route('employees.create.view') }}" class="btn btn-primary mb-4">Agregar Empleado</a>

        <!-- Filtros -->
        <form method="GET" action="{{ route('employees.index.view') }}" class="mb-4 flex items-center">
            <input type="text" name="name" placeholder="Buscar por nombre" class="border rounded p-2 mr-2"
                value="{{ request('name') }}">
            <select name="department_id" class="border rounded p-2 mr-2">
                <option value="">Seleccionar Departamento</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ request('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary mr-2">Buscar</button>
            <button type="button" class="btn btn-danger" onclick="resetFilters()">Eliminar Filtros</button>
        </form>

        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Nombre</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Rol</th>
                    <th class="py-2 px-4 text-left">Departamento</th>
                    <th class="py-2 px-4 text-left">Comparación del salario</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees['data'] as $employee)
                    <tr>
                        <td class="py-2 px-4">{{ $employee->name }}</td>
                        <td class="py-2 px-4">{{ $employee->email }}</td>
                        <td class="py-2 px-4">{{ $employee->role_name ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ $employee->department_name ?? 'N/A' }}</td>
                        <td class="py-2 px-4">
                            @if ($employee->salary_comparison === 'above')
                                Por encima
                            @elseif ($employee->salary_comparison === 'below')
                                Por debajo
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-3">
                            <a href="{{ route('employees.edit.view', $employee->id) }}" class="action-link edit">Editar</a>
                            <a href="{{ route('employees.show.view', $employee->id) }}" class="action-link view">Ver</a>
                            <button type="button" class="action-link delete"
                                onclick="confirmDelete('{{ $employee->id }}')">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <!-- Botones de paginación -->
            @if ($employees['current_page'] > 1)
                <a href="{{ route('employees.index.view', ['page' => $employees['current_page'] - 1]) }}"
                    class="btn btn-secondary">Anterior</a>
            @endif

            @if ($employees['current_page'] < $employees['last_page'])
                <a href="{{ route('employees.index.view', ['page' => $employees['current_page'] + 1]) }}"
                    class="btn btn-secondary">Siguiente</a>
            @endif

            <span class="ml-2">Página {{ $employees['current_page'] }} de {{ $employees['last_page'] }}</span>
        </div>

        <!-- Modal de Confirmación -->
        <div id="deleteModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminación</h5>
                        <button type="button" class="close" onclick="closeModal()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este empleado?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                        <form id="deleteForm" action="" method="POST" onsubmit="return handleDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
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
                        <h5 class="modal-title">Resultado de Eliminación</h5>
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

    </main>

    <script>
        function confirmDelete(employeeId) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ route('employees.destroy', '') }}/' + employeeId;
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'block';
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'none';
        }

        function closeMessageModal() {
            const modal = document.getElementById('messageModal');
            modal.style.display = 'none';
        }

        function handleDelete(event) {
            event.preventDefault();
            const form = event.target;

            fetch(form.action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    showMessage(data.message, 'success');
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect; // Redirigir después de 2 segundos
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Ocurrió un error al eliminar el empleado.', 'error');
                });

            closeModal();
        }

        function resetFilters() {
            window.location.href = '{{ route('employees.index.view') }}';
        }

        function showMessage(message, type) {
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
