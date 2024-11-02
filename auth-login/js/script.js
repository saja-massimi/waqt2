let wrapper = document.querySelector(".wrapper");

let flag = 1;

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
