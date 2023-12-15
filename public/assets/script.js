function revealPassword(id) {
    const element = document.getElementById(id);
    if (element.type === "password") {
        element.type = "text";
        document.getElementById(`${id}-icon`).className = "cursor-pointer text-[#22092C] fa fa-eye-slash icon"
    } else {
        element.type = "password";
        document.getElementById(`${id}-icon`).className = "cursor-pointer text-[#22092C] fa fa-eye icon"
    }
}
