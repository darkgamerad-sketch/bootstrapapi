<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Tareas API</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- ========== NAVBAR ========== -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('tareas-api.index') }}" class="nav-link">Tareas API</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
            </li>

            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i>
                    <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Usuario' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">
                        {{ Auth::user()->name ?? 'Usuario' }}
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Perfil
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> Configuración
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item dropdown-footer">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- ========== SIDEBAR ========== -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">MiProyecto</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tareas.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Tareas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tareas-api.index') }}" class="nav-link active">
                            <i class="nav-icon fas fa-code"></i>
                            <p>Tareas API</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Cerrar Sesión</p>
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- ========== CONTENT WRAPPER ========== -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tareas API</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                            <li class="breadcrumb-item active">Tareas API</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Tasks Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestión de Tareas via API</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createTaskModal">
                                <i class="fas fa-plus mr-1"></i> Nueva Tarea
                            </button>
                            <button type="button" class="btn btn-info btn-sm ml-1" onclick="loadTasks()">
                                <i class="fas fa-sync-alt mr-1"></i> Actualizar
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="loadingSpinner" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <p class="mt-2">Cargando tareas...</p>
                        </div>

                        <div id="tasksTableContainer" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="20%">Nombre</th>
                                            <th width="25%">Descripción</th>
                                            <th width="10%">Estado</th>
                                            <th width="15%">Fecha Límite</th>
                                            <th width="10%">Urgencia</th>
                                            <th width="15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tasksTableBody">
                                        <!-- Las tareas se cargarán aquí via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="emptyState" class="text-center py-4" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-tasks fa-2x mb-3"></i>
                                <h5>No hay tareas registradas</h5>
                                <p class="mb-0">Comienza creando tu primera tarea</p>
                                <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#createTaskModal">
                                    <i class="fas fa-plus mr-1"></i> Crear Primera Tarea
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- ========== FOOTER ========== -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Versión 1.0
        </div>
        <strong>Copyright &copy; 2025 <a href="#">Mi Proyecto</a>.</strong>
    </footer>
</div>

<!-- ========== MODALS ========== -->

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nueva Tarea</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="createTaskForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createNombre">Nombre de la Tarea *</label>
                        <input type="text" class="form-control" id="createNombre" name="nombre" required maxlength="60">
                    </div>
                    <div class="form-group">
                        <label for="createDescripcion">Descripción</label>
                        <textarea class="form-control" id="createDescripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="createFechaLimite">Fecha Límite *</label>
                        <input type="datetime-local" class="form-control" id="createFechaLimite" name="fecha_limite" required>
                    </div>
                    <div class="form-group">
                        <label for="createUrgencia">Nivel de Urgencia *</label>
                        <select class="form-control" id="createUrgencia" name="urgencia" required>
                            <option value="">Seleccione una opción</option>
                            <option value="0">🟢 No es urgente</option>
                            <option value="1">🟡 Urgencia normal</option>
                            <option value="2">🔴 Muy urgente</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Tarea</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editTaskForm">
                <input type="hidden" id="editTaskId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editNombre">Nombre de la Tarea *</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required maxlength="60">
                    </div>
                    <div class="form-group">
                        <label for="editDescripcion">Descripción</label>
                        <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editFechaLimite">Fecha Límite *</label>
                        <input type="datetime-local" class="form-control" id="editFechaLimite" name="fecha_limite" required>
                    </div>
                    <div class="form-group">
                        <label for="editUrgencia">Nivel de Urgencia *</label>
                        <select class="form-control" id="editUrgencia" name="urgencia" required>
                            <option value="">Seleccione una opción</option>
                            <option value="0">🟢 No es urgente</option>
                            <option value="1">🟡 Urgencia normal</option>
                            <option value="2">🔴 Muy urgente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="editFinalizada" name="finalizada" value="1">
                            <label class="custom-control-label" for="editFinalizada">
                                Marcar como completada
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== SCRIPTS ========== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<script>
// CSRF Token para las peticiones API
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

// Configuración de headers para las peticiones
const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-CSRF-TOKEN': csrfToken
};

// Mostrar alerta
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible`;
    alert.innerHTML = `
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="icon fas fa-${type === 'success' ? 'check' : 'ban'}"></i> ${message}
    `;
    alertContainer.appendChild(alert);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Cargar tareas desde la API
async function loadTasks() {
    const loadingSpinner = document.getElementById('loadingSpinner');
    const tasksTableContainer = document.getElementById('tasksTableContainer');
    const emptyState = document.getElementById('emptyState');
    const tasksTableBody = document.getElementById('tasksTableBody');

    loadingSpinner.style.display = 'block';
    tasksTableContainer.style.display = 'none';
    emptyState.style.display = 'none';

    try {
        const response = await fetch('/api/tareas', {
            headers: headers
        });

        if (!response.ok) throw new Error('Error al cargar tareas');

        const tareas = await response.json();
        tasksTableBody.innerHTML = '';

        if (tareas.length > 0) {
            tareas.forEach(tarea => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${tarea.id}</td>
                    <td>${tarea.nombre}</td>
                    <td>${tarea.descripcion || 'Sin descripción'}</td>
                    <td>
                        <span class="badge badge-${tarea.finalizada ? 'success' : 'warning'}">
                            ${tarea.finalizada ? 'Completada' : 'Pendiente'}
                        </span>
                    </td>
                    <td>${tarea.fecha_limite_formatted}</td>
                    <td>
                        <span class="badge badge-${tarea.urgencia_clase}">
                            ${tarea.urgencia_texto}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm" onclick="editTask(${tarea.id})" title="Editar tarea">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteTask(${tarea.id})" title="Eliminar tarea">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tasksTableBody.appendChild(row);
            });

            tasksTableContainer.style.display = 'block';
        } else {
            emptyState.style.display = 'block';
        }
    } catch (error) {
        showAlert('Error al cargar las tareas: ' + error.message, 'danger');
    } finally {
        loadingSpinner.style.display = 'none';
    }
}

// Crear nueva tarea
document.getElementById('createTaskForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const taskData = {
        nombre: formData.get('nombre'),
        descripcion: formData.get('descripcion'),
        fecha_limite: formData.get('fecha_limite'),
        urgencia: parseInt(formData.get('urgencia'))
    };

    try {
        const response = await fetch('/api/tareas', {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(taskData)
        });

        if (!response.ok) throw new Error('Error al crear tarea');

        showAlert('Tarea creada exitosamente');
        $('#createTaskModal').modal('hide');
        this.reset();
        loadTasks();
    } catch (error) {
        showAlert('Error al crear la tarea: ' + error.message, 'danger');
    }
});

// Editar tarea
async function editTask(id) {
    try {
        const response = await fetch(`/api/tareas/${id}`, { headers });
        if (!response.ok) throw new Error('Error al cargar tarea');

        const tarea = await response.json();

        document.getElementById('editTaskId').value = tarea.id;
        document.getElementById('editNombre').value = tarea.nombre;
        document.getElementById('editDescripcion').value = tarea.descripcion || '';
        document.getElementById('editFechaLimite').value = tarea.fecha_limite.slice(0, 16);
        document.getElementById('editUrgencia').value = tarea.urgencia;
        document.getElementById('editFinalizada').checked = tarea.finalizada;

        $('#editTaskModal').modal('show');
    } catch (error) {
        showAlert('Error al cargar la tarea: ' + error.message, 'danger');
    }
}

// Actualizar tarea
document.getElementById('editTaskForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const id = document.getElementById('editTaskId').value;
    const formData = new FormData(this);
    const taskData = {
        nombre: formData.get('nombre'),
        descripcion: formData.get('descripcion'),
        fecha_limite: formData.get('fecha_limite'),
        urgencia: parseInt(formData.get('urgencia')),
        finalizada: document.getElementById('editFinalizada').checked
    };

    try {
        const response = await fetch(`/api/tareas/${id}`, {
            method: 'PUT',
            headers: headers,
            body: JSON.stringify(taskData)
        });

        if (!response.ok) throw new Error('Error al actualizar tarea');

        showAlert('Tarea actualizada exitosamente');
        $('#editTaskModal').modal('hide');
        loadTasks();
    } catch (error) {
        showAlert('Error al actualizar la tarea: ' + error.message, 'danger');
    }
});

// Eliminar tarea
async function deleteTask(id) {
    if (!confirm('¿Estás seguro de que quieres eliminar esta tarea?')) return;

    try {
        const response = await fetch(`/api/tareas/${id}`, {
            method: 'DELETE',
            headers: headers
        });

        if (!response.ok) throw new Error('Error al eliminar tarea');

        showAlert('Tarea eliminada exitosamente');
        loadTasks();
    } catch (error) {
        showAlert('Error al eliminar la tarea: ' + error.message, 'danger');
    }
}

// Inicializar la página
document.addEventListener('DOMContentLoaded', function() {
    loadTasks();

    // Establecer fecha mínima en los formularios
    const now = new Date().toISOString().slice(0, 16);
    document.getElementById('createFechaLimite').min = now;
    document.getElementById('editFechaLimite').min = now;
});
</script>

</body>
</html>
