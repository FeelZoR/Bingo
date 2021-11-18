const html_tag = document.getElementsByTagName('html')[0];

(function () {
    const localStorage = window.localStorage;
    let darkMode = false;

    function toggleDarkMode() {
        darkMode = !darkMode;
        html_tag.dataset.theme = darkMode ? 'dark' : 'light';

        localStorage.setItem("dark_mode", darkMode);
    }

    document.getElementById('dark_mode').addEventListener('click', toggleDarkMode);
    if (localStorage.getItem("dark_mode") === "true") {
        toggleDarkMode();
    }
})()
