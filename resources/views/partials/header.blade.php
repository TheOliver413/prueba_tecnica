<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-lg font-bold">
            Gestión de Empleados
        </div>
        <div>
            <ul class="flex space-x-4">
                <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">Home</a></li>
                <li><a href="{{ route('employees.index.view') }}" class="text-gray-300 hover:text-white">Empleados</a></li>
                {{-- <li><a href="{{ route('departments.index') }}" class="text-gray-300 hover:text-white">Departamentos</a></li>
                <li><a href="{{ route('roles.index') }}" class="text-gray-300 hover:text-white">Roles</a></li> --}}
            </ul>
        </div>
    </div>
</nav>
