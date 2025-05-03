@extends('layouts.app')

@section('content')
    <div class="reparacion-container">
        <div class="container animate-fade-in">
            <!-- Notificaciones -->
            @if (session('success'))
                <div class="notification success">
                    <svg class="icon" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="notification-text">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @if (session('error'))
                <div class="notification error">
                    <svg class="icon" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="notification-text">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            <div class="main-content">

                <!-- Encabezado -->
                <div class="card glass-card">
                    <div class="card-header">
                        <div>
                            <h1 class="title">
                                <span class="icon-circle">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                                <span class="gradient-text">
                                    Seguimiento
                                    {{ $reparacion->factura?->codigo ?? 'REP-' . str_pad($reparacion->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </h1>
                        </div>
                        <div class="status-container">
                            <span class="status-badge {{ $reparacion->estado }}">
                                <i
                                    class="fas 
                                @if ($reparacion->estado == 'pendiente') fa-clock 
                                @elseif($reparacion->estado == 'en_proceso') fa-cogs 
                                @elseif($reparacion->estado == 'listo') fa-check-circle 
                                @elseif($reparacion->estado == 'entregado') fa-box-open 
                                @else fa-question-circle @endif"></i>
                                {{ ucfirst(str_replace('_', ' ', $reparacion->estado)) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid-container">
                        <div class="info-section">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h3 class="info-title">Cliente</h3>
                                    <p class="info-text">{{ $reparacion->cliente->nombre }}</p>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-mobile"></i>
                                </div>
                                <div>
                                    <h3 class="info-title">Dispositivo</h3>
                                    <p class="info-text">{{ $reparacion->marca }} {{ $reparacion->modelo }}</p>
                                    <p class="info-description"><span class="bold">Falla:</span>
                                        {{ $reparacion->falla_reportada ?? 'No registrado' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="info-section">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div>
                                    <h3 class="info-title">Financiero</h3>
                                    <p class="info-text"><span class="bold">Costo:</span> L.
                                        {{ number_format($reparacion->costo_total, 2) }}</p>
                                    <p class="info-text"><span class="bold">Abonado:</span> L.
                                        {{ number_format($reparacion->abono, 2) }}</p>
                                    @php $pendiente = $reparacion->costo_total - $reparacion->abono; @endphp
                                    @if ($pendiente > 0)
                                        <p class="info-text warning"><span class="bold">Pendiente:</span> L.
                                            {{ number_format($pendiente, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de avance técnico -->
                <div class="card glass-card">
                    <h2 class="section-title">
                        <span class="icon-circle blue">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        <span class="gradient-text blue">
                            Nuevo Avance Técnico
                        </span>
                    </h2>

                    <form action="{{ route('seguimientos.store', $reparacion) }}" method="POST"
                        enctype="multipart/form-data" class="form-container">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Descripción del avance *</label>
                            <textarea name="descripcion" required rows="4" class="form-textarea"
                                placeholder="Describa en detalle el avance realizado..."></textarea>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Estado actual *</label>
                                <select name="estado" required class="form-select">
                                    <option value="recibido">Recibido</option>
                                    <option value="en_proceso">En proceso</option>
                                    <option value="listo">Listo para entrega</option>
                                    <option value="entregado">Entregado</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Evidencia fotográfica</label>
                                <div class="file-upload-area">
                                    <div class="file-upload-content">
                                        <svg class="file-upload-icon" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="file-upload-text">
                                            <label for="imagenesInput" class="file-upload-label">
                                                <span>Subir imágenes</span>
                                                <input id="imagenesInput" name="imagenes[]" type="file" multiple
                                                    accept="image/*" class="file-input">
                                            </label>
                                            <p class="file-upload-hint">o arrastrar aquí</p>
                                        </div>
                                        <p class="file-upload-info">PNG, JPG, GIF hasta 5MB</p>
                                    </div>
                                </div>

                                <!-- Vista previa de imágenes -->
                                <div id="previewContainer" class="preview-container">
                                    <!-- Las imágenes se agregarán dinámicamente aquí -->
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn primary">
                                <i class="fas fa-save"></i>
                                Guardar Avance
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Sección de pagos pendientes -->
                @if ($pendiente > 0 && !$reparacion->factura_id)
                    <div class="alert-card warning">
                        <div class="alert-content">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h3 class="alert-title">Saldo pendiente de pago</h3>
                                <p class="alert-text">
                                    El cliente aún debe <span class="highlight">L.
                                        {{ number_format($pendiente, 2) }}</span>.
                                    Debe pagar la totalidad antes de marcar como "Entregado" y generar factura.
                                </p>

                                <form action="{{ route('reparaciones.abonar', $reparacion) }}" method="POST"
                                    class="payment-form">
                                    @csrf
                                    <div class="payment-input">
                                        <span class="currency-symbol">L.</span>
                                        <input type="number" name="monto" step="0.01" min="1"
                                            max="{{ $pendiente }}" class="payment-amount"
                                            placeholder="Monto a abonar">
                                    </div>
                                    <button type="submit" class="btn warning">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Registrar Abono
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif($reparacion->estado === 'entregado' && !$reparacion->factura_id)
                    <div class="alert-card success">
                        <div class="alert-content">
                            <div class="alert-icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <h3 class="alert-title">Facturación</h3>
                                <p class="alert-text">
                                    La reparación está lista para ser entregada. Puede generar la factura correspondiente.
                                </p>
                                <form method="POST" action="{{ route('facturar.reparacion', $reparacion->id) }}">
                                    @csrf
                                    <button type="submit" class="btn success">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        Generar Factura
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif($reparacion->factura_id)
                    <div class="alert-card info">
                        <div class="alert-content">
                            <div class="alert-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div>
                                <h3 class="alert-title">Factura Generada</h3>
                                <p class="alert-text">
                                    Esta reparación ya tiene una factura asociada. Puede descargarla en formato PDF.
                                </p>
                                <a href="{{ route('facturas_reparaciones.pdf', $reparacion->factura_id) }}"
                                    target="_blank" class="btn info">
                                    <i class="fas fa-download"></i>
                                    Descargar Factura PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Historial de seguimiento (Timeline) -->
                <div class="card glass-card">
                    <h2 class="section-title">
                        <span class="icon-circle">
                            <i class="fas fa-history"></i>
                        </span>
                        <span class="gradient-text">
                            Historial de Seguimiento
                        </span>
                    </h2>

                    @if ($reparacion->seguimientos->count() > 0)
                        <div class="timeline-container">
                            <!-- Línea vertical -->
                            <div class="timeline-line"></div>

                            <div class="timeline-items">
                                @foreach ($reparacion->seguimientos as $seg)
                                    <div class="timeline-item">
                                        <!-- Punto en la línea de tiempo -->
                                        <div class="timeline-dot {{ $seg->estado }}">
                                            <i
                                                class="fas 
                                    @if ($seg->estado == 'recibido') fa-inbox 
                                    @elseif($seg->estado == 'en_proceso') fa-cogs 
                                    @elseif($seg->estado == 'listo') fa-check-circle 
                                    @elseif($seg->estado == 'entregado') fa-box-open 
                                    @else fa-question-circle @endif"></i>
                                        </div>

                                        <!-- Tarjeta de seguimiento -->
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <div class="timeline-date">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>{{ $seg->created_at->isoFormat('D MMM YYYY, h:mm a') }}</span>
                                                </div>
                                                <div class="timeline-status {{ $seg->estado }}">
                                                    {{ ucfirst(str_replace('_', ' ', $seg->estado)) }}
                                                </div>
                                            </div>

                                            <div class="timeline-body">
                                                <div class="technician-info">
                                                    <i class="fas fa-user-shield"></i>
                                                    <span>Técnico: {{ $seg->tecnico->name }}</span>
                                                </div>
                                                <div class="description-box">
                                                    <p>{{ $seg->descripcion }}</p>
                                                </div>
                                            </div>

                                            @if ($seg->imagenes && $seg->imagenes->count() > 0)
                                                <div class="timeline-images">
                                                    <h4 class="images-title">
                                                        <i class="fas fa-images"></i>
                                                        <span>Evidencia fotográfica</span>
                                                    </h4>
                                                    <div class="images-grid">
                                                        @foreach ($seg->imagenes as $img)
                                                            <a href="{{ asset('storage/' . $img->ruta_imagen) }}"
                                                                class="image-link"
                                                                data-fancybox="gallery-{{ $seg->id }}"
                                                                data-caption="Seguimiento #{{ $seg->id }} - {{ $seg->created_at->format('d/m/Y') }}">
                                                                <div class="image-container">
                                                                    <img src="{{ asset('storage/' . $img->ruta_imagen) }}"
                                                                        alt="Imagen seguimiento">
                                                                </div>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-content">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h3 class="empty-title">No hay avances registrados</h3>
                                <p class="empty-text">Comience registrando el primer avance técnico</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Historial de abonos -->
                <div class="card glass-card">
                    <h2 class="section-title">
                        <span class="icon-circle green">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                        <span class="gradient-text green">
                            Historial de Abonos
                        </span>
                    </h2>

                    <div class="payment-summary">
                        <div class="summary-row">
                            <div class="summary-item">
                                <span class="summary-label">Costo Total:</span> L.
                                {{ number_format($reparacion->costo_total, 2) }}
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total Abonado:</span> L.
                                {{ number_format($reparacion->abono, 2) }}
                            </div>
                        </div>

                        @php
                            $porcentaje =
                                $reparacion->costo_total > 0
                                    ? ($reparacion->abono / $reparacion->costo_total) * 100
                                    : 0;
                        @endphp

                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ $porcentaje }}%"></div>
                        </div>
                        <div class="progress-labels">
                            <span>0%</span>
                            <span class="progress-percent">{{ number_format($porcentaje, 0) }}%</span>
                            <span>100%</span>
                        </div>
                    </div>

                    @if ($reparacion->abonos->isEmpty())
                        <div class="empty-state">
                            <div class="empty-content">
                                <div class="empty-icon">
                                    <i class="fas fa-money-bill-alt"></i>
                                </div>
                                <h3 class="empty-title">No hay abonos registrados</h3>
                                <p class="empty-text">Registre el primer abono para comenzar</p>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="payments-table">
                                <thead>
                                    <tr>
                                        <th>Fecha/Hora</th>
                                        <th>Monto</th>
                                        <th>Método</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reparacion->abonos as $abono)
                                        <tr>
                                            <td>
                                                <div class="payment-date">{{ $abono->created_at->format('d/m/Y') }}</div>
                                                <div class="payment-time">{{ $abono->created_at->format('h:i A') }}</div>
                                            </td>
                                            <td class="payment-amount-cell">
                                                L. {{ number_format($abono->monto, 2) }}
                                            </td>
                                            <td class="payment-method">
                                                {{ $abono->metodo_pago ?? 'Agregado manual' }}
                                            </td>
                                            <td class="payment-notes">
                                                <div>
                                                    <span>{{ $abono->observaciones ?? 'Desde la vista Seguimiento' }}</span>
                                                    @if ($abono->usuario)
                                                        <span class="payment-user">
                                                            <i class="fas fa-user-circle"></i>
                                                            {{ $abono->usuario->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Botón de volver -->
                <div class="back-button-container">
                    <a href="{{ route('reparaciones.index') }}" class="btn back">
                        <i class="fas fa-arrow-left"></i>
                        Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const input = document.getElementById('imagenesInput');
            const previewContainer = document.getElementById('previewContainer');

            input.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                const files = Array.from(this.files);
                if (files.length > 0) {
                    previewContainer.style.display = 'grid';
                } else {
                    previewContainer.style.display = 'none';
                }

                files.forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'preview-item';
                            div.innerHTML = `
                            <img src="${e.target.result}" class="preview-image" />
                            <div class="preview-overlay">
                                <span>Vista previa</span>
                            </div>
                        `;
                            previewContainer.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script>
            Fancybox.bind("[data-fancybox]", {
                // Opciones de fancybox
            });
        </script>
    @endpush

    <style>
        /* Estilos base */
        .reparacion-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 20px 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Notificaciones */
        .notification {
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .notification.success {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
        }

        .notification.error {
            background-color: #fff1f2;
            border-left: 4px solid #f43f5e;
        }

        .notification .icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .notification.success .icon {
            color: #10b981;
            fill: currentColor;
        }

        .notification.error .icon {
            color: #f43f5e;
            fill: currentColor;
        }

        .notification-text {
            font-size: 14px;
            font-weight: 500;
            margin: 0;
        }

        .notification.success .notification-text {
            color: #065f46;
        }

        .notification.error .notification-text {
            color: #9f1239;
        }

        /* Tarjetas principales */
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
        }

        .card-header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }

        @media (min-width: 768px) {
            .card-header {
                flex-direction: row;
                align-items: center;
            }
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-circle {
            background-color: #e0e7ff;
            padding: 12px;
            border-radius: 12px;
            color: #4f46e5;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .icon-circle.blue {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .icon-circle.green {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .gradient-text {
            background-image: linear-gradient(to right, #4f46e5, #2563eb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .gradient-text.blue {
            background-image: linear-gradient(to right, #2563eb, #1d4ed8);
        }

        .gradient-text.green {
            background-image: linear-gradient(to right, #16a34a, #059669);
        }

        .status-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .status-badge.pendiente {
            background-color: #fee2e2;
            color: #991b1b;
            animation: pulse 2s infinite;
        }

        .status-badge.en_proceso {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-badge.listo {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-badge.entregado {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-badge.recibido {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        /* Grid de información */
        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-top: 24px;
        }

        @media (min-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr 1fr;
            }
        }

        .info-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-card {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background-color: rgba(249, 250, 251, 0.5);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(229, 231, 235, 0.5);
        }

        .info-icon {
            background-color: #e0e7ff;
            padding: 8px;
            border-radius: 8px;
            color: #4f46e5;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .info-title {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin: 0 0 4px 0;
        }

        .info-text {
            font-size: 14px;
            color: #1f2937;
            font-weight: 500;
            margin: 0;
        }

        .info-text.warning {
            color: #dc2626;
            font-weight: 600;
        }

        .info-description {
            font-size: 13px;
            color: #6b7280;
            margin: 4px 0 0 0;
        }

        .bold {
            font-weight: 600;
        }

        /* Formulario */
        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            color: #1f2937;
            resize: vertical;
            min-height: 120px;
            transition: all 0.2s;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 2px rgba(199, 210, 254, 0.5);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .form-select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            color: #1f2937;
            background-color: white;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            transition: all 0.2s;
        }

        .form-select:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 2px rgba(199, 210, 254, 0.5);
        }

        /* File upload */
        .file-upload-area {
            margin-top: 8px;
            display: flex;
            justify-content: center;
            padding: 24px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            transition: border-color 0.2s;
        }

        .file-upload-area:hover {
            border-color: #818cf8;
        }

        .file-upload-content {
            text-align: center;
        }

        .file-upload-icon {
            margin: 0 auto;
            height: 48px;
            width: 48px;
            color: #9ca3af;
        }

        .file-upload-text {
            display: flex;
            justify-content: center;
            font-size: 14px;
            color: #6b7280;
            margin-top: 8px;
        }

        .file-upload-label {
            position: relative;
            cursor: pointer;
            font-weight: 500;
            color: #4f46e5;
        }

        .file-upload-label:hover {
            color: #4338ca;
        }

        .file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        .file-upload-hint {
            margin-left: 4px;
        }

        .file-upload-info {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }

        /* Image preview */
        .preview-container {
            display: none;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-top: 16px;
        }

        @media (min-width: 768px) {
            .preview-container {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .preview-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .preview-item:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .preview-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            object-position: center;
        }

        .preview-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s;
        }

        .preview-item:hover .preview-overlay {
            opacity: 1;
        }

        .preview-overlay span {
            color: white;
            font-size: 14px;
            font-weight: 500;
        }

        /* Botones */
        .form-actions {
            display: flex;
            justify-content: flex-end;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn.primary {
            background: linear-gradient(to right, #4f46e5, #6366f1);
            color: white;
        }

        .btn.primary:hover {
            background: linear-gradient(to right, #4338ca, #4f46e5);
        }

        .btn.warning {
            background: linear-gradient(to right, #f59e0b, #eab308);
            color: #1f2937;
        }

        .btn.warning:hover {
            background: linear-gradient(to right, #d97706, #f59e0b);
        }

        .btn.success {
            background: linear-gradient(to right, #10b981, #059669);
            color: white;
        }

        .btn.success:hover {
            background: linear-gradient(to right, #0d9463, #10b981);
        }

        .btn.info {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
        }

        .btn.info:hover {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
        }

        .btn.back {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .btn.back:hover {
            background-color: #d1d5db;
        }

        /* Alert cards */
        .alert-card {
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-left: 4px solid;
        }

        .alert-card.warning {
            background-color: rgba(255, 251, 235, 0.9);
            border-color: #f59e0b;
        }

        .alert-card.success {
            background-color: rgba(236, 253, 245, 0.9);
            border-color: #10b981;
        }

        .alert-card.info {
            background-color: rgba(239, 246, 255, 0.9);
            border-color: #3b82f6;
        }

        .alert-content {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .alert-icon {
            background-color: rgba(252, 211, 77, 0.2);
            padding: 12px;
            border-radius: 12px;
            color: #d97706;
            font-size: 20px;
        }

        .alert-card.success .alert-icon {
            background-color: rgba(16, 185, 129, 0.2);
            color: #059669;
        }

        .alert-card.info .alert-icon {
            background-color: rgba(59, 130, 246, 0.2);
            color: #2563eb;
        }

        .alert-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 8px 0;
        }

        .alert-text {
            font-size: 14px;
            color: #4b5563;
            margin: 0 0 16px 0;
        }

        .highlight {
            font-weight: 700;
            color: #dc2626;
        }

        /* Payment form */
        .payment-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        @media (min-width: 640px) {
            .payment-form {
                flex-direction: row;
            }
        }

        .payment-input {
            position: relative;
            flex: 1;
        }

        .currency-symbol {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .payment-amount {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px 16px 12px 28px;
            font-size: 14px;
            color: #1f2937;
            transition: all 0.2s;
        }

        .payment-amount:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(253, 230, 138, 0.5);
        }

        /* Timeline */
        .timeline-container {
            position: relative;
        }

        .timeline-line {
            position: absolute;
            left: 24px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #a5b4fc, #6366f1);
            border-radius: 1px;
        }

        .timeline-items {
            padding-left: 40px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 32px;
        }

        .timeline-dot {
            position: absolute;
            left: -40px;
            top: 4px;
            width: 24px;
            height: 24px;
            background-color: #4f46e5;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
        }

        .timeline-dot.recibido {
            background-color: #3b82f6;
        }

        .timeline-dot.en_proceso {
            background-color: #f59e0b;
        }

        .timeline-dot.listo {
            background-color: #10b981;
        }

        .timeline-dot.entregado {
            background-color: #8b5cf6;
        }

        .timeline-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .timeline-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .timeline-header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 16px;
        }

        @media (min-width: 640px) {
            .timeline-header {
                flex-direction: row;
            }
        }

        .timeline-date {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
        }

        .timeline-date i {
            color: #9ca3af;
        }

        .timeline-status {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .timeline-status.recibido {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .timeline-status.en_proceso {
            background-color: #fef3c7;
            color: #92400e;
        }

        .timeline-status.listo {
            background-color: #d1fae5;
            color: #065f46;
        }

        .timeline-status.entregado {
            background-color: #ede9fe;
            color: #5b21b6;
        }

        .timeline-body {
            margin-bottom: 16px;
        }

        .technician-info {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .technician-info i {
            color: #9ca3af;
        }

        .description-box {
            background-color: white;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .description-box p {
            margin: 0;
            color: #4b5563;
            white-space: pre-line;
        }

        .timeline-images {
            margin-top: 16px;
        }

        .images-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 8px 0;
        }

        .images-title i {
            color: #9ca3af;
        }

        .images-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        @media (min-width: 768px) {
            .images-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .images-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .image-link {
            display: block;
        }

        .image-container {
            position: relative;
            padding-bottom: 100%;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .image-container img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .image-link:hover .image-container img {
            transform: scale(1.05);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 0;
        }

        .empty-content {
            background-color: #f3f4f6;
            padding: 24px;
            border-radius: 12px;
            display: inline-block;
            max-width: 400px;
        }

        .empty-icon {
            background-color: white;
            padding: 16px;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 12px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .empty-icon i {
            font-size: 32px;
            color: #9ca3af;
        }

        .empty-title {
            font-size: 18px;
            font-weight: 500;
            color: #1f2937;
            margin: 0 0 4px 0;
        }

        .empty-text {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        /* Payment history */
        .payment-summary {
            margin-bottom: 24px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .summary-item {
            font-size: 14px;
            color: #6b7280;
        }

        .summary-label {
            font-weight: 600;
        }

        .progress-container {
            width: 100%;
            height: 12px;
            background-color: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 4px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #10b981, #059669);
            transition: width 0.5s ease;
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #6b7280;
        }

        .progress-percent {
            font-weight: 600;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .payments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payments-table thead th {
            padding: 12px 24px;
            text-align: left;
            font-size: 12px;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .payments-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.15s;
        }

        .payments-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .payments-table tbody td {
            padding: 16px 24px;
            font-size: 14px;
            color: #4b5563;
        }

        .payment-date {
            font-weight: 500;
            color: #1f2937;
        }

        .payment-time {
            font-size: 12px;
            color: #9ca3af;
        }

        .payment-amount-cell {
            font-weight: 700;
            color: #16a34a;
        }

        .payment-method {
            font-weight: 500;
        }

        .payment-notes {
            font-size: 13px;
        }

        .payment-user {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }

        .payment-user i {
            color: #9ca3af;
        }

        /* Back button */
        .back-button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .title {
                font-size: 24px;
            }

            .section-title {
                font-size: 20px;
            }

            .card {
                padding: 16px;
            }

            .payments-table thead th,
            .payments-table tbody td {
                padding: 12px 16px;
            }
        }
    </style>
@endsection
