<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title>{{ $title ?? 'Trax - Traffic Control' }}</title>
        
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#3b82f6">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if ('serviceWorker' in navigator && 'PushManager' in window) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            }
        </script>
    </head>
    <body class="bg-slate-950 text-white font-sans antialiased selection:bg-blue-500 selection:text-white">
        {{ $slot }}

        @auth
        <div id="push-notification-prompt" style="display: none;" class="fixed bottom-4 right-4 bg-blue-600 text-white p-4 rounded-lg shadow-lg flex items-center justify-between z-50">
            <span class="mr-4">Habilitar notificaciones de pedidos</span>
            <button onclick="subscribeUser()" class="bg-white text-blue-600 px-3 py-1 rounded font-semibold text-sm hover:bg-blue-50 transition">Activar</button>
        </div>

        <script>
            const vapidPublicKey = '{{ config('webpush.vapid.public_key') }}';

            function urlB64ToUint8Array(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4);
                const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
                const rawData = window.atob(base64);
                const outputArray = new Uint8Array(rawData.length);
                for (let i = 0; i < rawData.length; ++i) {
                    outputArray[i] = rawData.charCodeAt(i);
                }
                return outputArray;
            }

            function subscribeUser() {
                if ('serviceWorker' in navigator && 'PushManager' in window) {
                    navigator.serviceWorker.ready.then(function(registration) {
                        const applicationServerKey = urlB64ToUint8Array(vapidPublicKey);
                        registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: applicationServerKey
                        })
                        .then(function(subscription) {
                            console.log('User is subscribed.');
                            // Hide the prompt
                            document.getElementById('push-notification-prompt').style.display = 'none';

                            // Send subscription to backend
                            fetch('/push-subscribe', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(subscription)
                            });
                        })
                        .catch(function(err) {
                            console.log('Failed to subscribe the user: ', err);
                        });
                    });
                }
            }

            // Check if we should show the prompt
            if ('Notification' in window && 'serviceWorker' in navigator) {
                if (Notification.permission === 'default' || Notification.permission === 'prompt') {
                    document.getElementById('push-notification-prompt').style.display = 'flex';
                } else if (Notification.permission === 'granted') {
                    // Check if already subscribed in SW
                    navigator.serviceWorker.ready.then(function(registration) {
                        registration.pushManager.getSubscription().then(function(subscription) {
                            if (subscription === null) {
                                // User granted permission but lost subscription (e.g. cleared data)
                                subscribeUser(); 
                            }
                        });
                    });
                }
            }
        </script>
        @endauth
    </body>
</html>
