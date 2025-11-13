<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Gestión de Tareas</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- ========== NAVBAR ========== -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('tareas.index') }}" class="nav-link">Tareas</a>
            </li>
        </ul>

        <!-- Right navbar links -->
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
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">MiProyecto</span>
        </a>

        <!-- Sidebar -->
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
                        <a href="{{ route('tareas.index') }}" class="nav-link active">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Tareas</p>
                        </a>
                    </li>
                    <!-- NUEVO: Tareas API -->
                    <li class="nav-item">
                        <a href="{{ route('tareas-api.index') }}" class="nav-link">
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
                        <h1>Gestión de Tareas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                            <li class="breadcrumb-item active">Tareas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Tasks Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Tareas</h3>
                        <div class="card-tools">
                            <a href="{{ route('tareas.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Nueva Tarea
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($tareas->count() > 0)
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
                                    <tbody>
                                        @foreach($tareas as $tarea)
                                        <tr>
                                            <td>{{ $tarea->id }}</td>
                                            <td>{{ $tarea->nombre }}</td>
                                            <td>{{ $tarea->descripcion ?? 'Sin descripción' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $tarea->finalizada ? 'success' : 'warning' }}">
                                                    {{ $tarea->finalizada ? 'Completada' : 'Pendiente' }}
                                                </span>
                                            </td>
                                            <td>{{ $tarea->fecha_limite->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $tarea->urgencia_clase }}">
                                                    {{ $tarea->urgencia_texto }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('tareas.edit', $tarea) }}"
                                                       class="btn btn-info btn-sm"
                                                       title="Editar tarea">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('tareas.destroy', $tarea) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                title="Eliminar tarea"
                                                                onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- ========== PAGINACIÓN AGREGADA ========== -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Información de paginación -->
                                <div class="text-muted">
                                    Mostrando {{ $tareas->firstItem() }} a {{ $tareas->lastItem() }} de {{ $tareas->total() }} tareas
                                </div>

                                <!-- Links de paginación -->
                                <nav>
                                    <ul class="pagination mb-0">
                                        <!-- Botón Anterior -->
                                        @if ($tareas->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">&laquo; Anterior</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $tareas->previousPageUrl() }}">&laquo; Anterior</a>
                                            </li>
                                        @endif

                                        <!-- Números de página -->
                                        @php
                                            // Mostrar máximo 5 páginas alrededor de la actual
                                            $start = max(1, $tareas->currentPage() - 2);
                                            $end = min($tareas->lastPage(), $start + 4);
                                            $start = max(1, $end - 4);
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $tareas->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $i }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $tareas->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        <!-- Botón Siguiente -->
                                        @if ($tareas->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $tareas->nextPageUrl() }}">Siguiente &raquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Siguiente &raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                            <!-- ========== FIN PAGINACIÓN ========== -->

                        @else
                            <!-- Empty State -->
                            <div class="text-center py-4">
                                <div class="alert alert-info">
                                    <i class="fas fa-tasks fa-2x mb-3"></i>
                                    <h5>No hay tareas registradas</h5>
                                    <p class="mb-0">Comienza creando tu primera tarea</p>
                                    <a href="{{ route('tareas.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus mr-1"></i> Crear Primera Tarea
                                    </a>
                                </div>
                            </div>
                        @endif
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

<!-- ========== SCRIPTS ========== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

</body>
</html>
