// Function to load JSON translation files.
function loadJSON(url, callback) {
    fetch(url)
        .then(response => response.json())
        .then(data => callback(data))
        .catch(error => console.error("Error loading translation file:", error));
}

// Function to apply translations to the page.
function translatePage(lang) {
    let translationFile = `locales/${lang}.json`;

    loadJSON(translationFile, function (translations) {
        document.querySelectorAll("[data-i18n]").forEach(element => {
            let key = element.getAttribute("data-i18n");
            let keys = key.split(".");
            let text = translations;

            keys.forEach(k => {
                if (text && text[k] !== undefined) {
                    text = text[k];
                } else {
                    console.warn(`Missing translation for key: ${key}`);
                    text = null;
                }
            });

            if (text) {
                if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
                    element.setAttribute("placeholder", text);
                } else {
                    element.innerHTML = text;
                }
            }
        });
    });
}

// Function to detect user language.
function getUserLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    const urlLang = urlParams.get("lang");
    const browserLang = navigator.language || navigator.userLanguage;
    return urlLang || (browserLang.startsWith("es") ? "es" : "en");
}

// Function to protect email from spam bots.
function protectEmail() {
    let user = "derafu";
    let domain = "derafu.org";
    let email = user + "@" + domain;
    let encodedEmail = "&#100;&#101;&#114;&#97;&#102;&#117;&#64;&#100;&#101;&#114;&#97;&#102;&#117;&#46;&#111;&#114;&#103;";

    document.getElementById("email-link").setAttribute("href", "mailto:" + email);
    document.getElementById("email-span").innerHTML = encodedEmail;
}

// Run when DOM is fully loaded.
document.addEventListener("DOMContentLoaded", function () {
    protectEmail();
    translatePage(getUserLanguage());
});
