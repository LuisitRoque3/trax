self.addEventListener('install', (event) => {
    console.log('Service Worker: Installed');
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    console.log('Service Worker: Activated');
});

self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const data = event.data?.json() ?? {};
    const title = data.title || 'Trax Notification';
    const body = data.body || '';
    const icon = data.icon || '/icon.png';
    const url = data.action_url || '/';
    
    event.waitUntil(
        self.registration.showNotification(title, {
            body: body,
            icon: icon,
            data: { url: url }
        })
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    
    const url = event.notification.data.url;
    
    event.waitUntil(
        clients.matchAll({ type: 'window' }).then(windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
