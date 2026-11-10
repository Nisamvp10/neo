/**
 * Day and Dark Mode Theme Manager for Neon Stories
 * Handles persistent theme switching (localStorage) with system preference fallback,
 * instant DOM updates, and multiple synced switcher buttons across the UI.
 */
(function () {
    'use strict';

    var STORAGE_KEY = 'neo_theme';
    var THEME_DARK = 'dark';
    var THEME_LIGHT = 'light';

    /**
     * Determine preferred theme
     */
    function getPreferredTheme() {
        try {
            var saved = localStorage.getItem(STORAGE_KEY);
            if (saved === THEME_DARK || saved === THEME_LIGHT) {
                return saved;
            }
        } catch (e) { }

        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return THEME_LIGHT;
        }
        return THEME_DARK;
    }

    /**
     * Apply theme attribute to html and body, and update all switcher buttons
     */
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        if (document.body) {
            document.body.setAttribute('data-theme', theme);
        }
        updateToggleButtons(theme);
    }

    /**
     * Persist theme preference and apply
     */
    function setTheme(theme) {
        try {
            localStorage.setItem(STORAGE_KEY, theme);
        } catch (e) { }
        applyTheme(theme);

        // Dispatch a custom event in case components need to react
        try {
            window.dispatchEvent(new CustomEvent('neoThemeChanged', { detail: { theme: theme } }));
        } catch (e) { }
    }

    /**
     * Toggle between Day and Dark modes
     */
    function toggleTheme() {
        var current = document.documentElement.getAttribute('data-theme') || THEME_DARK;
        var next = current === THEME_LIGHT ? THEME_DARK : THEME_LIGHT;
        setTheme(next);
    }

    /**
     * Update all toggle buttons in the DOM to reflect current mode
     */
    function updateToggleButtons(theme) {
        var isLight = theme === THEME_LIGHT;
        var buttons = document.querySelectorAll('.js-theme-toggle');

        for (var i = 0; i < buttons.length; i++) {
            var btn = buttons[i];
            btn.setAttribute('aria-checked', isLight ? 'true' : 'false');
            btn.setAttribute('title', isLight ? 'Switch to Dark Mode' : 'Switch to Day Mode');

            var textEl = btn.querySelector('.theme-mode-text');
            if (textEl) {
                textEl.textContent = isLight ? 'Day' : 'Dark';
            }

            var tooltipEl = btn.querySelector('.floating-theme-tooltip');
            if (tooltipEl) {
                tooltipEl.textContent = isLight ? 'Dark Mode' : 'Day Mode';
            }
        }
    }

    /**
     * Initial setup
     */
    function init() {
        var current = getPreferredTheme();
        applyTheme(current);

        // Event delegation for all theme toggles
        document.addEventListener('click', function (e) {
            var toggleBtn = e.target.closest ? e.target.closest('.js-theme-toggle') : null;
            if (toggleBtn) {
                e.preventDefault();
                toggleTheme();
            }
        });

        // Listen for OS preference change if user hasn't explicitly set a preference
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function (e) {
                try {
                    if (!localStorage.getItem(STORAGE_KEY)) {
                        applyTheme(e.matches ? THEME_LIGHT : THEME_DARK);
                    }
                } catch (err) { }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose globally
    window.NeoTheme = {
        get: function () {
            return document.documentElement.getAttribute('data-theme') || THEME_DARK;
        },
        set: setTheme,
        toggle: toggleTheme
    };
})();

