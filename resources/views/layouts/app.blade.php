<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'AWS - ASISTENCIAS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"> <!-- Archivo de estilo personalizado -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body, html {
            margin: 0;
            padding: 0;
        }

        /* Ajustes para la sección héroe */
        .hero-section {
            background-image: url('/images/fondo.jpg');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0; /* Asegúrate de que no haya margen superior */
            padding: 0;
        }


        #qr-reader {
            max-width: 100%; /* Para móviles, el ancho del lector de QR se ajusta al tamaño de la pantalla */
            height: auto; /* Ajuste automático de la altura */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">AWS ECUADOR - ASISTENCIAS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Inicio</a>

                        @auth
                        <!-- Mostrar solo si está autenticado -->




                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('break-scanner') }}">Validar Break</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos.index') }}">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos.crear') }}">Crear Curso</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    @else
                        <!-- Mostrar solo si no está autenticado -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @endauth




                    </li>
                    {{--  <li class="nav-item">
                        <a class="nav-link" href="#">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Precios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>  --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sección del héroe -->
    <div class="container-fluid hero-section text-white text-center d-flex align-items-center justify-content-center">
        <div>
            <h1 class="display-4">Bienvenido a Nuestro Servicio</h1>
            <p class="lead">Escanea el código QR para confirmar asistencia.</p>
            <!-- Botón para abrir el modal del lector QR -->
            <a href="#" class="btn btn-primary btn-lg" id="start-qr-scan" data-bs-toggle="modal" data-bs-target="#qrModal">Comenzar Ahora</a>
        </div>
    </div>

    <!-- Modal para el lector de QR -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">Escanea el Código QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-reader" style="width: 100%;"></div> <!-- Aquí se mostrará el lector de QR -->
                    <div id="qr-reader-results" class="mt-3"></div> <!-- Aquí se mostrarán los resultados -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Contenido -->
    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- Pie de página adherente -->
    @include('partials.footer')

    <!-- Cargar librería html5-qrcode desde una CDN válida -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <!-- Cargar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Código JavaScript para manejar el escaneo del código QR -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Cuando se abre el modal, iniciar el lector de QR
            const qrModal = document.getElementById('qrModal');
            qrModal.addEventListener('shown.bs.modal', function () {
                startQrCodeScanner();
            });

            // Función para iniciar el escáner de código QR
            function startQrCodeScanner() {
                const html5QrCode = new Html5Qrcode("qr-reader");

                function onScanSuccess(decodedText, decodedResult) {
                    html5QrCode.stop().then(() => {
                        document.getElementById("qr-reader-results").innerHTML = `Código QR Escaneado: ${decodedText}`;
                        window.location.href = decodedText; // Redirigir a la URL obtenida del código QR
                    }).catch((err) => {
                        console.error("No se pudo detener el escaneo", err);
                    });
                }

                function onScanFailure(error) {
                    console.warn(`Error de escaneo: ${error}`);
                }

                html5QrCode.start(
                    { facingMode: "environment" }, // Usa la cámara trasera
                    {
                        fps: 10,    // Escanea 10 veces por segundo
                        qrbox: 250  // Área de escaneo de 250x250
                    },
                    onScanSuccess,
                    onScanFailure
                ).catch((err) => {
                    console.error("No se pudo iniciar la cámara", err);
                });
            }
        });
    </script>
</body>
</html>
