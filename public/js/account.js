function handler(formType) {
    let list = document.getElementsByClassName("register-toggle");
    if(formType == 1) {
        list[0].classList.add("hidden");
        list[1].classList.remove("hidden");
    } else {
        list[0].classList.remove("hidden");
        list[1].classList.add("hidden");
    }
}
