/*
 * Autenticate and login
 */
async function login() {
    
    let code = document.getElementById("_SYSTEM_").value;
    let username = document.getElementById("_USERNAME_").value;
    let password = document.getElementById("_PASSWORD_").value;
    let formData = new FormData();

    // Set commands to end session
    formData.append('_SYSTEM_', code);
    formData.append('_USERNAME_', username);
    formData.append('_PASSWORD_', password);
    
    let info = await execute('async.login.php', formData);
    info = JSON.parse(info);
    
    if (info.status > 1) {
        alert(info.message);
    }
    
    submit();
}

/*
 * End session and logout
 */
async function logout() {
    
    // General Declaration
    let page = 'async.eval.php';
    let formData = new FormData();

    // Set commands to end session
    formData.append('1', '$_SESSION["status"] = 0;');
    formData.append('2', 'session_destroy();');

    // Execute it in server side
    await execute(page, formData);

    // Do not show screen
    setTable(0);

    // Refresh it
    submit();

}

/*
 * forgetPassword
 */
async function forgetPassword(code, email) {
    
    let formData = new FormData();

    // Set commands to end session
    formData.append('_SYSTEM_', code);
    formData.append('_EMAIL_', email);
    
    let info = await execute('async.login.php', formData);
    info = JSON.parse(info);
    
    if (info.status > 1) {
        alert(info.message);
    }
}

/*
 * Register new user
 */
async function register(name, email) {
    
    let formData = new FormData();

    // Set commands to end session
    formData.append('_NAME_', name);
    formData.append('_EMAIL_', email);
    
    let info = await execute('async.register.php', formData);
    info = JSON.parse(info);
    
    if (info.status > 1) {
        alert(info.message);
    }
}