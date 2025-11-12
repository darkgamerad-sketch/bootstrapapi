<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Editar Tarea</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('tareas.index') }}" class="nav-link">Tareas</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Editar Tarea</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i>
                    <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Usuario' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{ Auth::user()->name ?? 'Usuario' }}</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"><i class="fas fa-user mr-2"></i> Perfil</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-cog mr-2"></i> Configuración</a>
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

    <!-- Sidebar -->
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
                        <a href="{{ route('tareas.create') }}" class="nav-link">
                            <i class="nav-icon fas fa-plus"></i>
                            <p>Nueva Tarea</p>
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

    <!-- Content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Editar Tarea</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tareas.index') }}">Tareas</a></li>
                            <li class="breadcrumb-item active">Editar Tarea</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Tarea #{{ $tarea->id }}</h3>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible m-3">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-check"></i> {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible m-3">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-ban"></i>
                                    @foreach($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('tareas.update', $tarea) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nombre">Nombre de la Tarea *</label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                               id="nombre" name="nombre" placeholder="Ingrese el nombre de la tarea"
                                               value="{{ old('nombre', $tarea->nombre) }}" required maxlength="60">
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                                  id="descripcion" name="descripcion" rows="3"
                                                  placeholder="Descripción opcional de la tarea">{{ old('descripcion', $tarea->descripcion) }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="fecha_limite">Fecha Límite *</label>
                                        <input type="datetime-local" class="form-control @error('fecha_limite') is-invalid @enderror"
                                               id="fecha_limite" name="fecha_limite"
                                               value="{{ old('fecha_limite', $tarea->fecha_limite->format('Y-m-d\TH:i')) }}" required>
                                        @error('fecha_limite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="urgencia">Nivel de Urgencia *</label>
                                        <select class="form-control @error('urgencia') is-invalid @enderror"
                                                id="urgencia" name="urgencia" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="0" {{ old('urgencia', $tarea->urgencia) == '0' ? 'selected' : '' }}>No es urgente</option>
                                            <option value="1" {{ old('urgencia', $tarea->urgencia) == '1' ? 'selected' : '' }}>Urgencia normal</option>
                                            <option value="2" {{ old('urgencia', $tarea->urgencia) == '2' ? 'selected' : '' }}>Muy urgente</option>
                                        </select>
                                        @error('urgencia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="finalizada" name="finalizada" value="1"
                                                   {{ old('finalizada', $tarea->finalizada) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="finalizada">
                                                Marcar como completada
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Actualizar Tarea
                                    </button>
                                    <a href="{{ route('tareas.index') }}" class="btn btn-default">
                                        <i class="fas fa-arrow-left mr-1"></i> Volver
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">Versión 1.0</div>
        <strong>Copyright &copy; 2025 <a href="#">Mi Proyecto</a>.</strong>
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>
