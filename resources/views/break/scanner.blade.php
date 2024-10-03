@extends('layouts.app')

@section('title', 'Escanear QR para Break')

@section('content')
<div class="container mt-5 text-center">
    <h2>Escanea el Código QR para Confirmar Asistencia del Break</h2>

    <!-- Botón para abrir el modal del escáner QR -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrModal">Escanear QR</button>

<!-- Modal del escáner QR -->
<div class="modal fade" id="qrModalBreak" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
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
</div>

<!-- Script para inicializar y detener el escáner -->
<script>


    document.addEventListener('DOMContentLoaded', function() {
        const qrModal = document.getElementById('qrModalBreak');
        let html5QrCode;

        // Inicializar el escáner cuando se abra el modal
        qrModal.addEventListener('shown.bs.modal', function () {
            html5QrCode = new Html5Qrcode("qr-reader");
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
        });

        // Detener el escáner cuando se cierre el modal
        qrModal.addEventListener('hidden.bs.modal', function () {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear(); // Limpiar el canvas del escáner
                }).catch((err) => {
                    console.error("No se pudo detener el escáner", err);
                });
            }
        });

        function onScanSuccess(decodedText, decodedResult) {
            // Aquí 'decodedText' es la URL completa obtenida del QR
            console.log(`Texto decodificado: ${decodedText}`);

            // Crear un objeto URL a partir del texto decodificado
            let url = new URL(decodedText);

            // Extraer el valor del parámetro 'id' de la URL
            let id = url.searchParams.get("id");

            if (id) {
                console.log(`ID extraído del QR: ${id}`);
                // Aquí puedes procesar el ID como lo necesites, por ejemplo, guardar el ID o hacer una petición AJAX.
                // No redirigimos a ningún lado.
            } else {
                console.log('El parámetro ID no está presente en la URL.');
            }

            // Detener el escáner si es necesario
            html5QrCode.stop().then(() => {
                console.log('Escaneo detenido.');
            }).catch((err) => {
                console.error("Error al detener el escaneo", err);
            });
        }

        // Inicializar el escáner y vincular la función onScanSuccess
        html5QrCode.start(
            { facingMode: "environment" }, // Usa la cámara trasera
            {
                fps: 10,    // Escanea 10 veces por segundo
                qrbox: 250  // Área de escaneo de 250x250
            },
            onScanSuccess,
            (errorMessage) => {
                // Manejar errores de escaneo aquí
                console.error(`Error de escaneo: ${errorMessage}`);
            }
        ).catch((err) => {
            console.error("No se pudo iniciar el escáner", err);
        });

        // Función de fallo al escanear
        function onScanFailure(error) {
            console.warn(`Error de escaneo: ${error}`);
        }
    });



</script>
@endsection
