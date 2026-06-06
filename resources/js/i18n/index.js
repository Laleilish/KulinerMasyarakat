import translations from './translations';

/**
 * i18n Alpine Store
 *
 * Usage in blade:
 *   - Add  data-i18n="Teks Indonesia"  on any element
 *   - The system auto-swaps textContent on language change
 *   - Persisted in localStorage so it survives page reload
 */
export function registerI18n(Alpine) {
    // Build reverse map (EN → ID) for switching back
    const reverseMap = {};
    for (const [id, en] of Object.entries(translations)) {
        reverseMap[en] = id;
    }

    Alpine.store('i18n', {
        locale: localStorage.getItem('kumar_lang') || 'ID',

        /** Get translated text */
        t(key) {
            if (this.locale === 'EN') {
                return translations[key] || key;
            }
            return key;
        },

        /** Set locale and translate the entire page */
        setLocale(lang) {
            this.locale = lang;
            localStorage.setItem('kumar_lang', lang);
            this.translatePage();
        },

        /** Walk the DOM and swap all [data-i18n] elements */
        translatePage() {
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (this.locale === 'EN') {
                    el.textContent = translations[key] || key;
                } else {
                    el.textContent = key;
                }
            });
        },

        /** Run once on page load */
        init() {
            // Small delay to ensure DOM is ready
            requestAnimationFrame(() => this.translatePage());
        }
    });
}
