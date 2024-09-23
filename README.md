## Documentación del Proyecto

Este proyecto sigue el patrón de diseño MVC (Modelo-Vista-Controlador) de Laravel, donde:

- **Modelo**: `EmployeeModel` gestiona la lógica de negocio relacionada con los empleados.
- **Vista**: Las vistas se generan utilizando Blade, lo que permite crear interfaces de usuario dinámicas.
- **Controlador**: Los controladores manejan las solicitudes HTTP, validan los datos y llaman a los modelos para interactuar con la base de datos.

### Estructura de Archivos

- **app/**: Contiene los modelos, controladores y lógica de negocio.
- **resources/views/**: Aquí se encuentran las vistas Blade del proyecto.
- **routes/**: Define las rutas de la aplicación, que conectan las URLs con los controladores.
- **database/migrations/**: Contiene las migraciones que definen la estructura de la base de datos.

### Rutas

- **GET /employees**: Lista todos los empleados.
- **POST /employees**: Procesa el formulario para crear un nuevo empleado.
- **PUT /employees/{id}**: Procesa el formulario para actualizar un empleado.
- **DELETE /employees/{id}**: Elimina logicamente un empleado.

### API

La aplicación también ofrece una API RESTful para gestionar empleados. Las solicitudes responden en formato JSON.


## Instalación

1. **Clonar el repositorio**:

   ```bash
   git clone https://github.com/TheOliver413/TalentManager.git
   cd tu-repo

1. **Instalar las dependencias**:
    ```bash
    - composer install

2. **Creacion de la BD**:
    ```bash
    - Crea una base de datos en postgrest llamada: talentmanager_db

3. **Configuración del .env**:
Abre el archivo .env y configura las siguientes variables:
    ```bash
    - DB_DATABASE=talentmanager_db
    - DB_USERNAME=tu_usuario
    - DB_PASSWORD=tu_contraseña

4. **Migrar la base de datos**:
Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
    ```bash
    - php artisan migrate
    
 5. **Sembrar la base de datos (opcional)**:
Si deseas agregar datos de ejemplo, puedes ejecutar el seeder:
    ```bash
    - php artisan db:seed

6. **Iniciar el servidor**:
Finalmente, puedes iniciar el servidor de desarrollo de Laravel:
    ```bash
    - php artisan serve
# prueba_tecnica
