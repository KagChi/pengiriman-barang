function revealPassword(id) {
    const element = document.getElementById(id);
    if (element.type === "password") {
        element.type = "text";
        document.getElementById(`${id}-icon`).className = "cursor-pointer text-[#22092C] dark:text-[#FCFCFC] fa fa-eye-slash icon"
    } else {
        element.type = "password";
        document.getElementById(`${id}-icon`).className = "cursor-pointer text-[#22092C] dark:text-[#FCFCFC] fa fa-eye icon"
    }
}


if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}


function changeTheme() {
    const element = document.getElementById("darkModeTogglerIcon");
    if (localStorage.theme === "light") {
        document.documentElement.classList.add('dark');
        localStorage.setItem("theme", 'dark');
        if (element) {
            element.className = "fa-solid fa-sun fa-xl";
        }
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem("theme", 'light');
        if (element) {
            element.className = "fa-solid fa-moon fa-xl";
        }
    }
}

tailwind.config = {
    darkMode: 'class', /* 'class' or 'media', we use 'class' to enable dark mode manually */
}
