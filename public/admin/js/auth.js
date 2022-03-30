DASHBOARD_URL = "/classhub-admin/";

LOGIN_URL = "/classhub-admin/login.html";
LOGGED_IN_URL = "/classhub-admin/";


(function authenticate(){

  var authToken = localStorage.getItem('authToken');
  if(authToken == null)
  {
    redirectToLogin();
    return;
  }

  _silentLogin(authToken)
  .then(user => {
    if(window.location.pathname == LOGIN_URL){
      redirectTo("/classhub-admin/");
    }
  })
  .catch(error => {
    localStorage.removeItem('authToken');
    redirectToLogin();
  });

})();

function _silentLogin(authToken){
    data = getData({
        token: authToken,
    });
    return new Promise(function(resolve, reject) {
      $.ajax({
          type: "POST",
          url: BASE_URL+"user/login/refresh",
          contentType: CONTENT_TYPE,
          data: data,
          success: function(tokenData){

            $.ajax({
                type: "GET",
                url: BASE_URL+"user/info",
                headers: {"Authorization": "Bearer "+authToken},
                contentType: CONTENT_TYPE,
                data: data,
                success: function(data)
                {
                  data.token = tokenData.token;
                  resolve(data);
                },
                error: function (xhr, ajaxOptions, error){
                  reject(getError(xhr.responseText));
                }
            });
          },
          error: function (xhr, ajaxOptions, error){
            reject(getError(xhr.responseText));
          }
      });
    })
    .then(data => {
      return validateLogin(data);
    });
}

function redirectToDashboard(){
  redirectTo(DASHBOARD_URL);
}

function redirectToLogin(){
  redirectTo(LOGIN_URL);
}

function redirectTo(path){
  if(window.location.pathname == path){
    return;
  }

  window.location.href = path;
}

function login(email, password){
  data = getData({
      email: email,
      password: password
  });
  return new Promise(function(resolve, reject) {
    $.ajax({
        type: "POST",
        url: BASE_URL+"user/login",
        contentType: CONTENT_TYPE,
        data: data,
        success: function(data)
        {
          resolve(validateLogin(data));
        },
        error: function (xhr, ajaxOptions, error){
          reject(getError(xhr.responseText));
        }
    });
  });
}

function logout(){
  localStorage.removeItem('authToken');
  redirectToLogin();
}

function validateLogin(data){
  return new Promise(function(resolve, reject) {
      if(data.user == null || data.user.role != "admin"){
        reject("This user is not an admin");
        return;
      }

      localStorage.setItem('authToken', data.token);
      sessionStorage.setItem('currentUser', JSON.stringify(data.user));

      resolve(data.user);
  });
}

function getData(map){
  return JSON.stringify(map);
}

function getError(errorString){
  error = JSON.parse(errorString);
  return error.message;
}
