<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'TavoCell 504')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Logo/favicon.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #6366f1;
            --secondary: #ec4899;
            --secondary-dark: #db2777;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --light: #f9fafb;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .shadow-soft {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .shadow-hard {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, var(--secondary) 0%, #f472b6 100%);
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>

<body class="text-gray-800">
    @if (Auth::check())
        @include('layouts.navigation')
    @endif

    <main class="min-h-[calc(100vh-4rem)] mt-16 animate-fade-in">
        <!-- Contenido principal con ancho completo -->
        <div class="w-full px-4 py-6">
            <!-- Breadcrumb (opcional, puedes activarlo en vistas específicas) -->
            @hasSection('breadcrumb')
                <div class="mb-6">
                    @yield('breadcrumb')
                </div>
            @endif

            <!-- Mensajes de sesión -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm animate-slide-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl shadow-sm animate-slide-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contenido de la vista -->
            @yield('content')
        </div>
    </main>

    @stack('scripts')

    <!-- Modal de Alerta Global -->
    <div id="alertModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-slide-in">
            <div class="p-6 text-center">
                <div
                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-red-100 to-pink-100 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                </div>
                <h2 id="alertTitle" class="text-2xl font-bold mb-2 text-gray-900">¡Atención!</h2>
                <p id="alertMessage" class="text-gray-600 mb-6 text-lg">Mensaje aquí...</p>
                <button onclick="closeAlertModal()"
                    class="w-full py-3 gradient-primary text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                    Aceptar
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-3"></div>

    <script>
        // Funciones para el modal de alerta
        function showAlert(title = '¡Atención!', message = 'Algo ocurrió.') {
            document.getElementById('alertTitle').innerText = title;
            document.getElementById('alertMessage').innerText = message;

            const modal = document.getElementById('alertModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAlertModal() {
            const modal = document.getElementById('alertModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Función para mostrar toast notifications
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');

            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-times-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };

            const colors = {
                success: 'bg-green-500 border-green-400',
                error: 'bg-red-500 border-red-400',
                warning: 'bg-yellow-500 border-yellow-400',
                info: 'bg-blue-500 border-blue-400'
            };

            toast.className =
            `${colors[type]} text-white px-4 py-3 rounded-xl shadow-lg flex items-center animate-slide-in`;
            toast.innerHTML = `
                <i class="${icons[type]} text-xl mr-3"></i>
                <span>${message}</span>
            `;

            container.appendChild(toast);

            // Auto-remove después de 5 segundos
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition-all', 'duration-300');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Función para copiar al portapapeles
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Copiado al portapapeles', 'success');
            }).catch(() => {
                showToast('Error al copiar', 'error');
            });
        }

        // Función para formatear moneda
        function formatCurrency(amount) {
            return new Intl.NumberFormat('es-HN', {
                style: 'currency',
                currency: 'HNL'
            }).format(amount);
        }

        // Función para formatear fecha
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-HN', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Cerrar modales al presionar Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAlertModal();
            }
        });

        // Cerrar modales al hacer clic fuera
        document.addEventListener('click', (e) => {
            const modal = document.getElementById('alertModal');
            if (modal && !modal.classList.contains('hidden') && e.target === modal) {
                closeAlertModal();
            }
        });

        // Exportar funciones globalmente
        window.showAlert = showAlert;
        window.showToast = showToast;
        window.copyToClipboard = copyToClipboard;
        window.formatCurrency = formatCurrency;
        window.formatDate = formatDate;
    </script>
</body>

</html>
