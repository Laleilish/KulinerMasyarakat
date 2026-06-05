import './bootstrap';

import Alpine from 'alpinejs';
import { registerI18n } from './i18n';

// Register i18n store before Alpine starts
registerI18n(Alpine);

// Register notification permission store
Alpine.store('notif', {
    status: ('Notification' in window) ? Notification.permission : 'denied',
    enabled: localStorage.getItem('kumar_notif_enabled') === 'true',

    get label() {
        const lang = Alpine.store('i18n')?.locale || 'ID';
        if (this.status === 'denied') return lang === 'EN' ? 'Blocked' : 'Ditolak';
        if (this.status === 'granted') {
            if (this.enabled) return lang === 'EN' ? 'Active' : 'Aktif';
            return lang === 'EN' ? 'Inactive' : 'Nonaktif';
        }
        return lang === 'EN' ? 'Allow' : 'Izinkan';
    },

    get color() {
        if (this.status === 'denied') return 'text-red-500';
        if (this.status === 'granted' && !this.enabled) return 'text-muted';
        return 'text-secondary';
    },

    get clickable() {
        return this.status !== 'denied';
    },

    async request() {
        if (!('Notification' in window) || this.status === 'denied') return;

        if (this.status === 'granted') {
            // Toggle
            this.enabled = !this.enabled;
            localStorage.setItem('kumar_notif_enabled', this.enabled);
            return;
        }

        const result = await Notification.requestPermission();
        this.status = result;

        if (result === 'granted') {
            this.enabled = true;
            localStorage.setItem('kumar_notif_enabled', 'true');
            new Notification('KUMAR 🍜', {
                body: 'Notifikasi berhasil diaktifkan!',
                icon: '/assets/img/icon-kumar.png',
            });
        }
    },

    // Check this before triggering notifications via JS
    canSend() {
        return this.status === 'granted' && this.enabled;
    }
});

window.Alpine = Alpine;

Alpine.start();
