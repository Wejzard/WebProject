let UserService = {
  login: function () {
    let data = {
      email: $("#email").val(),
      password: $("#password").val()
    };

    RestClient.post("/auth/login", data, function (response) {
      localStorage.setItem("user_token", response.data.token);

      let user = Utils.parseJwt(response.data.token).user;
      if (user.role === "admin") {
        window.location.href = "admin-dashboard.html";
      } else {
        window.location.href = "../../index.html";
      }

    }, function (xhr) {
      alert("Login failed: " + xhr.responseText);
    });
  }
};