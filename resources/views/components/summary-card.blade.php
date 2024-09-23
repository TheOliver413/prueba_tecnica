<div class="card bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 ease-in-out hover:shadow-xl w-full mb-20">
    <div class="card-header bg-gray-100 p-2 flex items-center">
        <h5 class="text-lg font-medium text-gray-900">{{ $title . $value }}</h5>
    </div>
    <div class="p-2">
        <a href="{{ route($route) }}" class="btn btn-primary text-white bg-blue-500 hover:bg-blue-700 rounded-lg px-4 py-2">Ver Todos</a>
    </div>
</div>
