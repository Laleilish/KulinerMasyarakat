import './bootstrap';

import Alpine from 'alpinejs';
import { registerI18n } from './i18n';

// Register i18n store before Alpine starts
registerI18n(Alpine);

window.Alpine = Alpine;

Alpine.start();
