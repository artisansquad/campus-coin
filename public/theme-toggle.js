/**
 * Campus Coin - Universal Theme Manager & Light Mode Engine
 * Manages Dark / Light mode across all public and authenticated pages.
 */
(function() {
    const STORAGE_KEY = 'cc_dark_mode';

    // 1. Determine current theme preference
    function isDarkMode() {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored !== null) {
            return stored !== 'false';
        }
        // Default to dark mode
        return true;
    }

    // 2. Apply theme class to document
    function applyTheme(dark) {
        if (dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    // Immediately apply on script load
    applyTheme(isDarkMode());

    // 3. Inject Comprehensive Light Mode Styles
    const styleEl = document.createElement('style');
    styleEl.id = 'cc-light-mode-styles';
    styleEl.textContent = `
        /* Light Mode Body & General Layout */
        html:not(.dark) body {
            background-color: #F8FAFC !important;
            color: #0F172A !important;
            background-image: 
                radial-gradient(circle at 12% 15%, rgba(59, 130, 246, 0.08), transparent 35%),
                radial-gradient(circle at 88% 85%, rgba(99, 102, 241, 0.05), transparent 30%) !important;
        }

        /* Glass Panels and Cards */
        html:not(.dark) .glass-panel,
        html:not(.dark) .glass,
        html:not(.dark) .card-glass,
        html:not(.dark) .feature-card,
        html:not(.dark) .pricing-card,
        html:not(.dark) .stat-card {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05) !important;
            color: #0F172A !important;
        }

        /* Heading & Typography Overrides */
        html:not(.dark) h1,
        html:not(.dark) h2,
        html:not(.dark) h3,
        html:not(.dark) h4,
        html:not(.dark) h5,
        html:not(.dark) h6 {
            color: #0F172A !important;
        }

        /* Invert white text on light backgrounds, EXCEPT on colored buttons and badges */
        html:not(.dark) .text-white:not(.keep-white):not([class*="bg-blue"]):not([class*="bg-emerald"]):not([class*="bg-green"]):not([class*="bg-purple"]):not([class*="bg-red"]):not([class*="bg-indigo"]) {
            color: #0F172A !important;
        }

        html:not(.dark) .text-slate-100 { color: #0F172A !important; }
        html:not(.dark) .text-slate-200 { color: #1E293B !important; }
        html:not(.dark) .text-slate-300 { color: #334155 !important; }
        html:not(.dark) .text-slate-400 { color: #475569 !important; }
        html:not(.dark) .text-slate-500 { color: #64748B !important; }

        /* Dark Borders Replacement */
        html:not(.dark) .border-slate-800,
        html:not(.dark) .border-slate-800\/80,
        html:not(.dark) .border-slate-800\/60,
        html:not(.dark) .border-slate-800\/40,
        html:not(.dark) .border-slate-700,
        html:not(.dark) .border-slate-700\/50,
        html:not(.dark) .border-slate-700\/40,
        html:not(.dark) .border-slate-700\/30,
        html:not(.dark) .border-slate-700\/20,
        html:not(.dark) .divide-slate-800,
        html:not(.dark) .divide-slate-700\/20 {
            border-color: #E2E8F0 !important;
        }

        /* Dark Backgrounds Replacement */
        html:not(.dark) .bg-slate-950,
        html:not(.dark) .bg-slate-950\/25,
        html:not(.dark) .bg-slate-900,
        html:not(.dark) .bg-slate-900\/60,
        html:not(.dark) .bg-slate-900\/50,
        html:not(.dark) .bg-slate-900\/40,
        html:not(.dark) .bg-slate-900\/30,
        html:not(.dark) .bg-slate-800,
        html:not(.dark) .bg-slate-800\/60,
        html:not(.dark) .bg-slate-800\/50,
        html:not(.dark) .bg-slate-800\/40 {
            background-color: #F8FAFC !important;
        }

        /* Form Inputs & Selects */
        html:not(.dark) input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
        html:not(.dark) select,
        html:not(.dark) textarea,
        html:not(.dark) .input-dark,
        html:not(.dark) .input-field {
            background-color: #FFFFFF !important;
            border-color: #CBD5E1 !important;
            color: #0F172A !important;
        }
        html:not(.dark) input::placeholder,
        html:not(.dark) textarea::placeholder,
        html:not(.dark) .input-dark::placeholder {
            color: #94A3B8 !important;
        }
        html:not(.dark) input:focus,
        html:not(.dark) select:focus,
        html:not(.dark) textarea:focus,
        html:not(.dark) .input-dark:focus {
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            background-color: #FFFFFF !important;
        }

        /* Table styles in light mode */
        html:not(.dark) thead,
        html:not(.dark) thead tr {
            background-color: #F1F5F9 !important;
        }
        html:not(.dark) thead th {
            color: #475569 !important;
            border-bottom: 1px solid #E2E8F0 !important;
        }
        html:not(.dark) tbody tr:hover,
        html:not(.dark) tr.table-row:hover {
            background-color: #F8FAFC !important;
        }

        /* Progress bars in light mode */
        html:not(.dark) .w-full.bg-slate-900.rounded-full,
        html:not(.dark) .bg-slate-900.rounded-full {
            background-color: #E2E8F0 !important;
            border-color: #CBD5E1 !important;
        }

        /* Header & Navigation in light mode */
        html:not(.dark) header,
        html:not(.dark) nav.sticky,
        html:not(.dark) .landing-nav {
            background-color: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid #E2E8F0 !important;
        }
        html:not(.dark) .landing-nav a:not([class*="primary-button"]):not([class*="bg-blue"]) {
            color: #334155 !important;
        }
        html:not(.dark) .landing-nav a:hover:not([class*="primary-button"]) {
            color: #2563EB !important;
        }

        /* Floating Theme Toggle Button for Public Pages */
        .cc-theme-toggle-floating {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1B2A41;
            color: #F59E0B;
            border: 1px solid rgba(148, 163, 184, 0.25);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        html:not(.dark) .cc-theme-toggle-floating {
            background: #FFFFFF;
            color: #D97706;
            border: 1px solid #CBD5E1;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .cc-theme-toggle-floating:hover {
            transform: scale(1.08);
        }
    `;
    document.head.appendChild(styleEl);

    // 4. Toggle function
    function toggleTheme() {
        const nextState = !isDarkMode();
        localStorage.setItem(STORAGE_KEY, nextState);
        applyTheme(nextState);
        updateToggleButtonUI(nextState);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { darkMode: nextState } }));
    }

    // 5. Update Floating Toggle Icon
    function updateToggleButtonUI(dark) {
        const btn = document.getElementById('cc-floating-theme-toggle');
        if (!btn) return;
        btn.innerHTML = dark
            ? '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'
            : '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>';
        btn.title = dark ? 'Switch to Light Mode' : 'Switch to Dark Mode';
    }

    // 6. Create floating toggle on public / non-app pages if not in app layout
    document.addEventListener('DOMContentLoaded', function() {
        const inAppLayout = document.querySelector('header [x-data*="themeManager"]') || document.querySelector('[x-data*="themeManager"]');
        if (!inAppLayout && !document.getElementById('cc-floating-theme-toggle')) {
            const btn = document.createElement('button');
            btn.id = 'cc-floating-theme-toggle';
            btn.className = 'cc-theme-toggle-floating';
            btn.type = 'button';
            btn.onclick = toggleTheme;
            document.body.appendChild(btn);
            updateToggleButtonUI(isDarkMode());
        }
    });

    // Expose toggle globally
    window.toggleCampusCoinTheme = toggleTheme;
})();
