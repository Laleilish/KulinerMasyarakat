import './bootstrap';

import Alpine from 'alpinejs';
import { registerI18n } from './i18n';

// Register i18n store before Alpine starts
registerI18n(Alpine);

// Register notification dot toggle store
Alpine.store('notifDot', {
    enabled: localStorage.getItem('kumar_show_notif_dot') !== 'false',

    toggle() {
        this.enabled = !this.enabled;
        localStorage.setItem('kumar_show_notif_dot', this.enabled);
    }
});

window.Alpine = Alpine;

Alpine.start();
