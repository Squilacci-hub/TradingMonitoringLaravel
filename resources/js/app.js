import './bootstrap';

// Theme Toggle Functionality
class ThemeManager {
    constructor() {
        this.init();
    }

    init() {
        // Load saved theme or default to dark
        const savedTheme = localStorage.getItem('theme') || 'dark';
        this.setTheme(savedTheme);

        // Add event listener for theme toggle button
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('theme-toggle');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => this.toggleTheme());
            }
        });
    }

    setTheme(theme) {
        const root = document.documentElement;
        if (theme === 'light') {
            root.setAttribute('data-theme', 'light');
        } else {
            root.removeAttribute('data-theme');
        }
        localStorage.setItem('theme', theme);
        this.updateToggleButton(theme);
    }

    toggleTheme() {
        const currentTheme = localStorage.getItem('theme') || 'dark';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
    }

    updateToggleButton(theme) {
        const toggleBtn = document.getElementById('theme-toggle');
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                icon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
            }
        }
    }
}

// Initialize theme manager
new ThemeManager();
