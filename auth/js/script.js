let wrapper = document.querySelector(".wrapper");
let signUpLink = document.querySelector(".link .signup-link");
let signInLink = document.querySelector(".link .signin-link");
let btnLogin = document.getElementById("loginss");
let btnSignup = document.getElementById("signup");
let flag = 1;
//swapping
signUpLink.addEventListener("click", () => {
  flag = 0;
  console.log(flag);
  wrapper.classList.add("animated-signin");
  wrapper.classList.remove("animated-signup");
});

signInLink.addEventListener("click", () => {
  wrapper.classList.add("animated-signup");
  wrapper.classList.remove("animated-signin");
  flag = 1;
  console.log(flag);
});

function logup(event, us, em, pass, passMatch) {
  event.preventDefault();

  let username = us;
  let email = em;
  let password = pass;
  let passwordMatch = passMatch;
  let signupErrorMessage = document.querySelectorAll(".up-error")[0];
  //check username+email

  if (username.length < 3 || username.length > 30) {
    signupErrorMessage.textContent =
      "Username must be between 3 and 20 characters long";
    return;
  }

  if (email.length === 0 || !/\S+@\S+\.\S+/.test(email)) {
    signupErrorMessage.textContent = "Please enter a valid email address";
    return;
  }

  //check password
  if (password.length < 8) {
    signupErrorMessage.textContent =
      "Password must be at least 8 characters long";
    return;
  }

  if (password !== passwordMatch) {
    signupErrorMessage.textContent = "Passwords do not match";
    return;
  }

  if (!/[A-Z]/.test(password)) {
    signupErrorMessage.textContent =
      "Password must contain at least one uppercase letter";
    return;
  }

  if (!/[a-z]/.test(password)) {
    signupErrorMessage.textContent =
      "Password must contain at least one lowercase letter";
    return;
  }

  if (!/[0-9]/.test(password)) {
    signupErrorMessage.textContent =
      "Password must contain at least one number";
    return;
  }

  if (!/[!@#$%^&*]/.test(password)) {
    signupErrorMessage.textContent =
      "Password must contain at least one special character";
    return;
  }

  if (password.includes(" ")) {
    signupErrorMessage.textContent = "Password cannot contain spaces";
    return;
  }

  if (password.length > 20) {
    signupErrorMessage.textContent =
      "Password cannot be more than 20 characters long";
    return;
  }

  if (/[^a-zA-Z0-9!@#$%^&*]/.test(password)) {
    signupErrorMessage.textContent = "Password contains invalid characters";
    return;
  }

  let newUser = {
    username: username,
    email: email,
    password: password,
    passwordMatch: passwordMatch,
    signupDate: new Date().toISOString(),
    role: "customer",
    isDeleted: "1",
  };

  //check database
  fetch("php/check.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(newUser),
  })
    .then((response) => response.json())
    .then((data) => {
      eval(data);
      console.log(data); // Handle the response from the PHP page
    })
    .catch((error) => {
      console.error("Error:", error);
      signupErrorMessage.textContent = "Reload the page then try again";
    });
  //
}

function login(event, em, pw) {
  event.preventDefault();

  let email = em;
  let password = pw;
  let loginErrorMessage = document.querySelectorAll(".lg-error")[0];

  // Email validation
  if (email.length === 0 || !/\S+@\S+\.\S+/.test(email)) {
    loginErrorMessage.textContent = "Please enter a valid email address";
    return;
  }

  // Password validation
  if (password.length < 8) {
    loginErrorMessage.textContent =
      "Password must be at least 8 characters long";
    return;
  }

  if (password.includes(" ")) {
    loginErrorMessage.textContent = "Password cannot contain spaces";
    return;
  }

  if (password.length > 20) {
    loginErrorMessage.textContent =
      "Password cannot be more than 20 characters long";
    return;
  }

  if (/[^a-zA-Z0-9!@#$%^&*]/.test(password)) {
    loginErrorMessage.textContent = "Password contains invalid characters";
    return;
  }

  let loginData = {
    email: email,
    password: password,
  };

  fetch("php/check_login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(loginData),
  })
    .then((response) => response.json())
    .then((data) => {
      eval(data);
      console.log(data);
    })
    .catch((error) => {
      console.error("Error:", error);
      loginErrorMessage.textContent =
        "An error occurred. Please try again later.";
    });
}

const form_lg = document.querySelector(".form-lg");

form_lg.addEventListener("submit", function (event) {
  let login_email = document.getElementById("login_em").value;
  let login_password = document.getElementById("login_pw").value;
  login(event, login_email, login_password);
});

const form = document.querySelector(".form-up");

form.addEventListener("submit", function (event) {
  let username = document.getElementById("signup-us").value;
  let email = document.getElementById("signup-em").value;
  let password = document.getElementById("signup-pw").value;
  let passwordMatch = document.getElementById("signup-pwm").value;
  logup(event, username, email, password, passwordMatch);
});

function logout(g) {
  google.accounts.id.revoke(g, () => {
    console.log("Logout success");
  });
}

function auth_info(a) {
  if (flag == 1) {
    auth_info_lg(a);
    return;
  }
  console.log(a, "1");
  console.log(a.credential, "2");
  const decodedToken = jwt_decode(a.credential);
  console.log(decodedToken, "3");
  console.log(decodedToken.name, decodedToken.email, "4");
  let defaultPass = "Google@2024";
  logup(event, decodedToken.name, decodedToken.email, defaultPass, defaultPass);
  logout(decodedToken.email);
}

function auth_info_lg(a) {
  // console.log(a, "1");
  //console.log(a.credential, "2");
  const decodedToken = jwt_decode(a.credential);
  //console.log(decodedToken, "3");
  //console.log(decodedToken.name, decodedToken.email, "4");
  login(event, decodedToken.email, "Google@2024");
  logout(decodedToken.email);
}
