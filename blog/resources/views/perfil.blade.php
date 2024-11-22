<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .card-profile,
        .card-category {
            background: #ffffff;
            color: #000000;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card-profile {
            flex: 1;
        }

        .card-category {
            flex: 1;
            margin-left: 20px;
        }

        .profile-info h2 {
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .edit-section {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.5s ease;
        }

        .edit-section.show {
            max-height: 600px;
            opacity: 1;
        }

        .btn-toggle {
            background-color: #4CAF50;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .btn-toggle:hover {
            background-color: #45a049;
        }

        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .btn-primary:hover {
            background-color: #45a049;
            border-color: #45a049;
        }

        .container {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 60px;
        }

        .profile-info p {
            margin: 0.4rem 0;
        }

        .profile-picture img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        ul {
            padding: 0;
            list-style-type: none;
        }

        ul li {
            margin: 0.5rem 0;
        }
    </style>
</head>

<nav class="navbar">
    <div class="navbar-left">
        <h2><i class="bi bi-person-circle"></i> Usuario: {{ Auth::user()->name }}</h2>
        <div class="dropdown">
            <button class="dropdown-btn" type="button" id="dropdownMenuButton" onclick="toggleDropdown()">
                <i class="bi bi-person-circle"></i> Perfil
            </button>
            <ul class="dropdown-menu" id="dropdownMenu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ route('perfil') }}"><i class="bi bi-eye"></i> Ver Perfil</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}"
                        onsubmit="return confirm('¿Estás seguro de que deseas cerrar sesión?');">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Cerrar
                            Sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="navbar-right">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Inicio</a></li>
            <li><a href="{{ route('fiados.index') }}"><i class="bi bi-wallet-fill"></i> Fiar</a></li>
            <li><a href="{{ route('agregar-producto') }}"><i class="bi bi-plus-circle"></i> Agregar Producto</a></li>
            <li><a href="#"><i class="bi bi-clock-history"></i> Ver Historial Ventas</a></li>
            <li><a href="{{ route('inventario') }}"><i class="bi bi-box"></i> Inventario</a></li>
            <li><a href="{{ route('pagina.pago') }}" class="btn-pagar"><i class="bi bi-credit-card"></i> Pagar</a>
            </li>
        </ul>
    </div>
</nav>

<body>
    <div class="container">
        <div class="card-profile">
            <div class="profile-info text-center">
                <h2>Perfil de Usuario</h2>

                <!-- Mostrar la foto de perfil o una predeterminada -->
                <div class="profile-picture">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                        alt="Foto de Perfil">
                </div>

                <p><strong>Nombre:</strong> {{ $user->name }}</p>
                <p><strong>Correo Electrónico:</strong> {{ $user->email }}</p>
                <p><strong>Fecha de Creación:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
                <button class="btn-toggle" onclick="toggleEditSection()">Editar Perfil</button>
                <button class="btn-toggle" onclick="togglePasswordSection()">Cambiar Contraseña</button>
            </div>

            <div class="edit-section mt-4" id="editProfileSection">
                <h4>Editar Información del Perfil</h4>
                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Foto de Perfil:</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control"
                            accept="image/*" required>
                        <small class="form-text text-muted">Selecciona una imagen para tu perfil (formatos admitidos:
                            JPG, PNG).</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>

            <div class="edit-section mt-4" id="changePasswordSection">
                <h4>Cambiar Contraseña</h4>
                <form action="{{ route('perfil.cambiar-contrasena') }}" method="POST"
                    onsubmit="return validatePassword()">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual:</label>
                        <input type="password" name="current_password" id="current_password" class="form-control"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nueva Contraseña:</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña:</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Guardar Contraseña</button>
                </form>
            </div>
        </div>

        <div class="card-category">
            <h3>Cantidad de Productos por Categoría:</h3>
            <ul>
                @foreach ($productosPorCategoria as $categoria)
                    <li><strong>{{ $categoria->nombre }}:</strong> {{ $categoria->cantidad }} productos</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleEditSection() {
            const editSection = document.getElementById('editProfileSection');
            const passwordSection = document.getElementById('changePasswordSection');
            passwordSection.classList.remove('show');
            editSection.classList.toggle('show');
        }

        function togglePasswordSection() {
            const editSection = document.getElementById('editProfileSection');
            const passwordSection = document.getElementById('changePasswordSection');
            editSection.classList.remove('show');
            passwordSection.classList.toggle('show');
        }

        function validatePassword() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('new_password_confirmation').value;

            if (newPassword !== confirmPassword) {
                alert('Las contraseñas no coinciden.');
                return false;
            }
            return true;
        }

        function toggleDropdown() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('show');
        }
    </script>
</body>

</html>
