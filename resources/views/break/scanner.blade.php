@extends('layouts.app')
@section('title', 'Escanear QR para Break')
@section('content')
<div class="container mt-5 text-center">
    <h2>Escanea el Código QR para Confirmar Asistencia del Break</h2>

    <!-- Botón para abrir el modal del escáner QR -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#breakQrModal">Escanear QR</button>

    <!-- Modal del escáner QR -->
    <div class="modal fade" id="breakQrModal" tabindex="-1" aria-labelledby="breakQrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Escanea el Código QR - Break Asistencias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="break-qr-reader" style="width: 100%;"></div> <!-- Aquí se mostrará el lector de QR -->
                    <div id="break-qr-reader-results" class="mt-3"></div> <!-- Aquí se mostrarán los resultados -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluye el script del lector de QR -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<!-- Incluye SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script para inicializar y manejar el escáner -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const breakQrModal = document.getElementById('breakQrModal');
    let breakHtml5QrCode;
    let breakScannerRunning = false;
    const csrfToken = '{{ csrf_token() }}'; // Obtener el token CSRF
    let lastScannedCode = null;
    let scanCooldown = false;

    // Crear un objeto Audio para el sonido
    const beepSound = new Audio('{{ asset('sounds/beep.mp3') }}');

    // Pre-cargar el sonido
    beepSound.preload = 'auto';

    // Inicializar el escáner cuando se abra el modal
    breakQrModal.addEventListener('shown.bs.modal', function () {
        if (!breakScannerRunning) {
            breakHtml5QrCode = new Html5Qrcode("break-qr-reader");
            breakHtml5QrCode.start(
                { facingMode: "environment" }, // Usa la cámara trasera
                {
                    fps: 10,    // Escanea 10 veces por segundo
                    qrbox: 250  // Área de escaneo de 250x250
                },
                breakOnScanSuccess,
                breakOnScanFailure
            ).catch((err) => {
                console.error("No se pudo iniciar la cámara", err);
            });
            breakScannerRunning = true;
        }
    });

    // Detener el escáner cuando se cierre el modal
    breakQrModal.addEventListener('hidden.bs.modal', function () {
        if (breakHtml5QrCode && breakScannerRunning) {
            breakHtml5QrCode.stop().then(() => {
                breakHtml5QrCode.clear(); // Limpiar el canvas del escáner
                breakScannerRunning = false;
                lastScannedCode = null;
            }).catch((err) => {
                console.error("No se pudo detener el escáner", err);
            });
        }
    });

    function breakOnScanSuccess(decodedText, decodedResult) {
        // Evitar procesar el mismo código múltiples veces en rápida sucesión
        if (scanCooldown || decodedText === lastScannedCode) {
            return;
        }
        lastScannedCode = decodedText;
        scanCooldown = true;

        // Reproducir el sonido
        beepSound.play();

        // Aquí 'decodedText' es la URL completa obtenida del QR
        console.log(`Texto decodificado: ${decodedText}`);

        // Crear un objeto URL a partir del texto decodificado
        let url;
        try {
            url = new URL(decodedText);
        } catch (e) {
            console.error('El texto decodificado no es una URL válida.');
            Swal.fire('Error', 'El código QR escaneado no es válido.', 'error');
            scanCooldown = false;
            return;
        }

        // Extraer el valor del parámetro 'id' de la URL
        let id = url.searchParams.get("id");

        if (id) {
            console.log(`ID extraído del QR: ${id}`);
            // Enviar el ID al servidor mediante una petición AJAX
            fetch('/validar-asistencia-break', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Asistencia confirmada',
                        text: `${data.message}\nNombre: ${data.nombre}`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: `${data.message}\nNombre: ${data.nombre || ''}`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
                // Permitir escanear nuevamente después de un breve período
                setTimeout(() => {
                    scanCooldown = false;
                    lastScannedCode = null;
                }, 2000);
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
                scanCooldown = false;
                lastScannedCode = null;
            });
        } else {
            console.log('El parámetro ID no está presente en la URL.');
            Swal.fire('Error', 'El código QR escaneado no contiene un ID válido.', 'error');
            scanCooldown = false;
            lastScannedCode = null;
        }
    }

    function breakOnScanFailure(error) {
        console.warn(`Error de escaneo: ${error}`);
    }
});
</script>
@endsection
