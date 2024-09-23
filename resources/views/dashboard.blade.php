    @php
        use Carbon\Carbon;
    @endphp

    @extends('layouts.app')

    @section('content')
        <main class="container mx-auto px-4 py-8 bg-gray-25">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Panel de Control de Gestión de Empleados</h1>
            </div>

            <section class="row bg" aria-label="Resumen estadístico">
                <div class="col-md-4">
                    @include('components.summary-card', [
                        'title' => 'Total de Empleados: ',
                        'value' => $totalEmployees,
                        'route' => 'employees.index.view',
                    ])
                </div>
                <div class="col-md-4">
                    @include('components.summary-card', [
                        'title' => 'Total de Roles: ',
                        'value' => $totalRoles,
                        'route' => 'roles.index',
                    ])
                </div>
                <div class="col-md-4">
                    @include('components.summary-card', [
                        'title' => 'Total de Departamentos: ',
                        'value' => $totalDepartments,
                        'route' => 'departments.index',
                    ])
                </div>
            </section>

            <section class="bg-white shadow rounded-lg p-6 mb-8" aria-labelledby="recent-employees-title">
                <div>
                    <h1 id="recent-employees-title" class="text-xl font-semibold mb-4 text-gray-800">Empleados Recientes
                    </h1>
                </div>
                <div class="dashboard">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Departamento</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de Contratación</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($recentEmployees as $employee)
                                <tr>
                                    <td class="py-2 px-4 whitespace-nowrap">{{ $employee->name }}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">{{ $employee->role_name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">{{ $employee->department_name?? 'N/A' }}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">
                                        {{ $employee->hiring_date ? Carbon::parse($employee->hiring_date)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4 whitespace-nowrap">
                                        <a href="{{ route('employees.edit.view', $employee->id) }}" class="action-link edit">Editar</a>
                                        <a href="{{ route('employees.show.view', $employee->id) }}" class="action-link view">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="{{ route('employees.index.view') }}" class="text-blue-600 hover:text-blue-900">Ver todos los
                        empleados</a>
                </div>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white shadow rounded-lg p-6 justify-content-center align-content-center" aria-labelledby="department-distribution-title">
                    <h1 id="department-distribution-title" class="text-xl text-center font-semibold mb-4 text-gray-800">Distribución de
                        Empleados por Departamento</h1>
                    <div class="containerChart">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </section>
        </main>
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('departmentChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($departmentLabels) !!},
                    datasets: [{
                        data: {!! json_encode($departmentCounts) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        </script>
    @endpush
