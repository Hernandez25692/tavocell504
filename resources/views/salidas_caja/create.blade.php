@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-xl font-semibold mb-6">Registrar Salida de Caja</h2>

    <form method="POST" action="{{ route('salidas-caja.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Monto</label>
            <input type="number" name="monto" step="0.01" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Motivo</label>
            <input type="text" name="motivo" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Comprobante (opcional)</label>
            <input type="file" name="comprobante" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Registrar</button>
        </div>
    </form>
</div>
@endsection
