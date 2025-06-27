Instalación del stack de autenticación
Se instaló Laravel Breeze, obteniendo registro, inicio de sesión y recuperación de contraseña listos para usar con Blade + Tailwind.

Migraciones

Tabla tareas: id, user_id, titulo, descripcion, estado, timestamps.

Las migraciones se ejecutaron con php artisan migrate.

Middleware de rol
Se añadieron dos middlewares (is.admin, is.normal) para restringir rutas según el rol guardado en users.role. (Aun en desarrollo)

Modelos y relaciones

Tarea (app/Models/Tarea.php) con $fillable = ['titulo','descripcion','estado'].

Relaciones Eloquent:

User hasMany Tarea

Tarea belongsTo User.

Rutas y controlador

Route::resource('tareas', TareaController::class) gestiona el CRUD.


Frontend con Vue 2 embebido + Axios

Vue 2 y Axios se cargan vía CDN en app.blade.php; se inyecta el token CSRF en los headers Axios.

Fichero public/js/tareas.js contiene cuatro componentes Vue creados “on the fly”:

Componente	Vista	Función
initCreate()	tareas/create.blade.php	Formulario Nueva tarea (POST /tareas).
initEdit()	tareas/edit.blade.php	Formulario Editar tarea sin campo estado.
initIndex()	tareas/index.blade.php	Tabla con chips rojo/verde. Permite Ver descripción, Borrar y alternar estado con un clic usando PUT /tareas/{id}.
initStats()	dashboard.blade.php	Tarjeta con doughnut Chart.js (pendiente/completado) y lista de títulos pendientes. Se alimenta de /tareas/stats.

Cómo ejecutar el proyecto recién clonado

bash
Copiar
Editar
# 1. Clonar
git clone https://github.com/usuario/mi-proyecto.git
cd mi-proyecto

# 2. Dependencias backend
composer install

# 3. Variables de entorno
cp .env.example .env
php artisan key:generate    # y ajustar DB_* en .env

# 4. Migraciones
php artisan migrate

# 5. Dependencias front-end y assets
npm install
npm run dev                 # ó npm run build en producción

# 6. Servidor local
php artisan serve           # http://localhost:8000
La aplicación permitirá registrarse, crear tareas, cambiarlas a Completado directamente en la tabla y visualizar estadísticas y lista de pendientes en el dashboard.
