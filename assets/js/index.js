// register variables >>>>>>>>>>>>>>>>>>>>>>>>
const login_section = document.querySelector(".login_section");
const sign_in = document.querySelector(".sign_in");
const sign_up = document.querySelector(".sign_up");

// password show and hide buttons
var password = document.getElementById("password");
var s_password = document.getElementById("s_password");
var scp_password = document.getElementById("scp_password");
var show = document.getElementById("show");
var hide = document.getElementById("hide");
var s_show = document.getElementById("s_show");
var s_hide = document.getElementById("s_hide");
var scp_show = document.getElementById("scp_show");
var scp_hide = document.getElementById("scp_hide");

// reset password show and hide buttons
var new_pass = document.getElementById("new_pass");
var c_new_pass = document.getElementById("c_new_pass");
var new_pass_show = document.getElementById("new_pass_show");
var new_pass_hide = document.getElementById("new_pass_hide");
var c_new_pass_show = document.getElementById("c_new_pass_show");
var c_new_pass_hide = document.getElementById("c_new_pass_hide");


sign_up.addEventListener("click", () => {
  login_section.classList.add("active");
});
sign_in.addEventListener("click", () => {
  login_section.classList.remove("active");
});

function toggle() {
  if (password.type === "password") {
    password.type = "text";
    hide.style.display = "inline-block";
    show.style.display = "none";
  } else {
    password.type = "password";
    hide.style.display = "none";
    show.style.display = "inline-block";
  }
}

function s_toggle() {
  if (s_password.type === "password") {
    s_password.type = "text";
    s_hide.style.display = "inline-block";
    s_show.style.display = "none";
  } else {
    s_password.type = "password";
    s_hide.style.display = "none";
    s_show.style.display = "inline-block";
  }
}

function new_pass_toggle() {
  if (new_pass.type === "password") {
    new_pass.type = "text";
    new_pass_hide.style.display = "inline-block";
    new_pass_show.style.display = "none";
  } else {
    new_pass.type = "password";
    new_pass_hide.style.display = "none";
    new_pass_show.style.display = "inline-block";
  }
}

function scp_toggle() {
  if (scp_password.type === "password") {
    scp_password.type = "text";
    scp_hide.style.display = "inline-block";
    scp_show.style.display = "none";
  } else {
    scp_password.type = "password";
    scp_hide.style.display = "none";
    scp_show.style.display = "inline-block";
  }
}

function c_new_pass_toggle() {
  if (c_new_pass.type === "password") {
    c_new_pass.type = "text";
    c_new_pass_hide.style.display = "inline-block";
    c_new_pass_show.style.display = "none";
  } else {
    c_new_pass.type = "password";
    c_new_pass_hide.style.display = "none";
    c_new_pass_show.style.display = "inline-block";
  }
}

