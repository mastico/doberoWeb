import './bootstrap';

const COOKIE_CONSENT_STORAGE_KEY = 'dobero_cookie_consent';
const COOKIE_CONSENT_VERSION = 1;
const COOKIE_OPEN_EVENT = 'dobero:open-cookie-settings';
const COOKIE_CHANGED_EVENT = 'dobero:consent-changed';
const cookieSettingsOpenHandlers = new Set();
const cookieConsentSubscribers = new Set();

const normalizeConsent = (value, version = COOKIE_CONSENT_VERSION) => ({
    necessary: true,
    analytics: Boolean(value?.analytics),
    marketing: Boolean(value?.marketing),
    version,
});

const isValidConsent = (value, version = COOKIE_CONSENT_VERSION) =>
    Boolean(
        value &&
            typeof value === 'object' &&
            value.necessary === true &&
            typeof value.analytics === 'boolean' &&
            typeof value.marketing === 'boolean' &&
            value.version === version
    );

const readConsent = (
    storageKey = COOKIE_CONSENT_STORAGE_KEY,
    version = COOKIE_CONSENT_VERSION
) => {
    try {
        const raw = window.localStorage.getItem(storageKey);

        if (!raw) {
            return null;
        }

        const parsed = JSON.parse(raw);

        return isValidConsent(parsed, version)
            ? normalizeConsent(parsed, version)
            : null;
    } catch {
        return null;
    }
};

const emitConsentChanged = (consent, changeEvent = COOKIE_CHANGED_EVENT) => {
    const normalized = normalizeConsent(consent, consent.version);

    window.dispatchEvent(new CustomEvent(changeEvent, { detail: normalized }));
    cookieConsentSubscribers.forEach((callback) => callback(normalized));
};

const persistConsent = (
    consent,
    {
        storageKey = COOKIE_CONSENT_STORAGE_KEY,
        version = COOKIE_CONSENT_VERSION,
        changeEvent = COOKIE_CHANGED_EVENT,
    } = {}
) => {
    const normalized = normalizeConsent(consent, version);

    try {
        window.localStorage.setItem(storageKey, JSON.stringify(normalized));
    } catch {
        // Ignore storage write failures and keep the UI usable.
    }

    emitConsentChanged(normalized, changeEvent);

    return normalized;
};

window.addEventListener(COOKIE_OPEN_EVENT, () => {
    cookieSettingsOpenHandlers.forEach((callback) => callback());
});

window.doberoCookieConsent = {
    storageKey: COOKIE_CONSENT_STORAGE_KEY,
    version: COOKIE_CONSENT_VERSION,
    readConsent,
    persistConsent,
    registerSettingsOpener(callback) {
        cookieSettingsOpenHandlers.add(callback);

        return () => cookieSettingsOpenHandlers.delete(callback);
    },
    onConsentChanged(callback, { emitCurrent = false } = {}) {
        cookieConsentSubscribers.add(callback);

        if (emitCurrent) {
            const consent = readConsent();

            if (consent) {
                callback(consent);
            }
        }

        return () => cookieConsentSubscribers.delete(callback);
    },
    create(config = {}) {
        const storageKey = config.storageKey ?? COOKIE_CONSENT_STORAGE_KEY;
        const version = config.version ?? COOKIE_CONSENT_VERSION;
        const changeEvent = config.changeEvent ?? COOKIE_CHANGED_EVENT;

        return {
            bannerVisible: false,
            settingsVisible: false,
            analytics: false,
            marketing: false,
            init() {
                const savedConsent = readConsent(storageKey, version);

                if (savedConsent) {
                    this.analytics = savedConsent.analytics;
                    this.marketing = savedConsent.marketing;
                } else {
                    this.analytics = false;
                    this.marketing = false;
                    this.bannerVisible = true;
                }

                this.unregisterSettingsOpener =
                    window.doberoCookieConsent.registerSettingsOpener(() => {
                        this.openSettings();
                    });
            },
            openSettings() {
                this.bannerVisible = false;
                this.settingsVisible = true;
            },
            closeSettings() {
                this.settingsVisible = false;
                this.bannerVisible = readConsent(storageKey, version) === null;
            },
            save(analytics, marketing) {
                const consent = persistConsent(
                    { analytics, marketing },
                    { storageKey, version, changeEvent }
                );

                this.analytics = consent.analytics;
                this.marketing = consent.marketing;
                this.bannerVisible = false;
                this.settingsVisible = false;
            },
            savePreferences() {
                this.save(this.analytics, this.marketing);
            },
        };
    },
};

window.doberoCookieConsent.onConsentChanged(() => {
    // Reserved for future first-party listeners that gate optional integrations.
});

/* Scroll-reveal observer ------------------------------------------------- */
const observe = () => {
    const els = document.querySelectorAll('.reveal:not(.is-in)');
    if (!('IntersectionObserver' in window)) {
        els.forEach((el) => el.classList.add('is-in'));
        return;
    }
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-in');
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );
    els.forEach((el) => io.observe(el));
};

document.addEventListener('DOMContentLoaded', observe);
document.addEventListener('livewire:navigated', observe);
document.addEventListener('livewire:initialized', observe);
