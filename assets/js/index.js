// register variables
const login_section = document.querySelector(".login_section");
const sign_in = document.querySelector(".sign_in");
const sign_up = document.querySelector(".sign_up");

sign_up.addEventListener("click", () => {
  login_section.classList.add("active");
});
sign_in.addEventListener("click", () => {
  login_section.classList.remove("active");
});
