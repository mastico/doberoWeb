import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans:    ['"Work Sans"', ...defaultTheme.fontFamily.sans],
                nav:     ['"Roboto Condensed"', 'sans-serif'],
                body:    ['"Roboto"', 'sans-serif'],
                display: ['"Work Sans"', 'sans-serif'],
                mono:    ['"Roboto Condensed"', 'sans-serif'],
            },
            colors: {
                primary: '#35AAE1',
                navy:    { DEFAULT: '#1a3151', dark: '#111d30', light: '#223d63' },
                body:    '#212529',
                muted:   '#666666',
                border:  { DEFAULT: '#dce0e0', alt: '#cccccc' },
                light:   '#f8f8f8',
                // Legacy aliases — admin panel + other pages use these token names
                dobero:  { blue: '#35AAE1', accent: '#2a6496' },
                ink:     '#212529',
                tide:    '#1a3151',
                brass:   { DEFAULT: '#35AAE1', dark: '#2a8bbf', light: '#5dc0e8' },
                bone:    '#f8f8f8',
                paper:   '#ffffff',
                mist:    '#dce0e0',
            },
            letterSpacing: {
                widest: '0.15em',
                wider:  '0.10em',
                nav:    '0.08em',
            },
            boxShadow: {
                editorial: '0 4px 30px rgba(0,0,0,0.12)',
                card:      '0 2px 15px rgba(0,0,0,0.08)',
                inset:     'inset 0 0 0 1px rgba(0,0,0,0.06)',
            },
            keyframes: {
                rise: {
                    '0%':   { transform: 'translateY(28px)', opacity: 0 },
                    '100%': { transform: 'translateY(0)',    opacity: 1 },
                },
                fadeIn: {
                    '0%':   { opacity: 0 },
                    '100%': { opacity: 1 },
                },
                drift: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%':      { transform: 'translateY(-6px)' },
                },
                marquee: {
                    '0%':   { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
            animation: {
                rise:    'rise 0.9s cubic-bezier(0.2, 0.7, 0.2, 1) both',
                fadeIn:  'fadeIn 1.2s ease both',
                drift:   'drift 6s ease-in-out infinite',
                marquee: 'marquee 40s linear infinite',
            },
        },
    },
    plugins: [forms, typography],
};
