@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2 class="form-title">Editar Reparación</h2>

    <form method="POST" action="{{ route('reparaciones.update', $reparacion->id) }}" class="repair-form">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Cliente -->
            <div class="form-group">
                <label class="form-label">Cliente</label>
                <select name="cliente_id" class="form-select">
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $reparacion->cliente_id == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Técnico -->
            <div class="form-group">
                <label class="form-label">Técnico</label>
                <select name="tecnico_id" class="form-select">
                    @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}" {{ $reparacion->tecnico_id == $tecnico->id ? 'selected' : '' }}>
                            {{ $tecnico->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Marca -->
            <div class="form-group">
                <label class="form-label">Marca</label>
                <input type="text" name="marca" value="{{ old('marca', $reparacion->marca) }}" class="form-input">
            </div>

            <!-- Modelo -->
            <div class="form-group">
                <label class="form-label">Modelo</label>
                <input type="text" name="modelo" value="{{ old('modelo', $reparacion->modelo) }}" class="form-input">
            </div>

            <!-- IMEI -->
            <div class="form-group">
                <label class="form-label">IMEI</label>
                <input type="text" name="imei" value="{{ old('imei', $reparacion->imei) }}" class="form-input">
            </div>

            <!-- Fecha de Ingreso -->
            <div class="form-group">
                <label class="form-label">Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', $reparacion->fecha_ingreso) }}" class="form-input">
            </div>

            <!-- Costo Total -->
            <div class="form-group">
                <label class="form-label">Costo Total (L)</label>
                <input type="number" step="0.01" name="costo_total" value="{{ old('costo_total', $reparacion->costo_total) }}" class="form-input">
            </div>

            <!-- Costo Tavocell -->
            <div class="form-group">
                <label class="form-label">Costo Tavocell (L)</label>
                <input type="number" step="0.01" name="costo_tavocell" value="{{ old('costo_tavocell', $reparacion->costo_tavocell) }}" class="form-input">
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    @foreach(['recibido', 'en_proceso', 'listo', 'entregado'] as $estado)
                        <option value="{{ $estado }}" {{ $reparacion->estado === $estado ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $estado)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Falla Reportada -->
        <div class="form-group full-width">
            <label class="form-label">Falla Reportada</label>
            <textarea name="falla_reportada" class="form-textarea">{{ old('falla_reportada', $reparacion->falla_reportada) }}</textarea>
        </div>

        <!-- Accesorios -->
        <div class="form-group full-width">
            <label class="form-label">Accesorios</label>
            <textarea name="accesorios" class="form-textarea">{{ old('accesorios', $reparacion->accesorios) }}</textarea>
        </div>

        <!-- Botón de envío -->
        <div class="form-actions">
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i> Actualizar Reparación
            </button>
        </div>
    </form>
</div>

<style>
    /* Estilos base */
    .form-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .form-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    /* Formulario */
    .repair-form {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    /* Grid de campos */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    /* Grupos de campos */
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    /* Etiquetas */
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #4b5563;
    }
    
    /* Campos de formulario */
    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f9fafb;
    }
    
    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        background-color: white;
    }
    
    /* Botón de envío */
    .form-actions {
        text-align: right;
        margin-top: 1.5rem;
    }
    
    .submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #1e40af;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover {
        background-color: #1e3a8a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
    }
    
    /* Validación */
    .is-invalid {
        border-color: #dc2626;
    }
    
    .invalid-feedback {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>
@endsection