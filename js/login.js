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
    
    let info = await execute('async/login.php', formData);
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
    let page = 'async/eval.php';
    let formData = new FormData();

    // Set commands to end session
    formData.append('1', '$_SESSION["status"] = 0;');
    formData.append('2', 'session_destroy();');

    // Execute it in server side
    await execute(page, formData);

    // Do not show screen
    setModule(0);

    // Refresh it
    submit();

}

/*
 * forgetPassword
 */
async function retrieveCredential(email) {
    
    let formData = new FormData();

    // Email to retrieve account
    formData.append('_EMAIL_', email);
    
    // Just retrieve it
    let info = await execute('async/retrieve.mail.php', formData);
    info = JSON.parse(info);
    
    // Report the user
    alert(info.message);
}

/*
 * Register new user
 */
async function register(name, email, system) {
    
    let formData = new FormData();

    // Set data to be registered
    formData.append('_NAME_', name);
    formData.append('_EMAIL_', email);
    formData.append('_SYSTEM_', system);
    
    // Register it
    let info = await execute('async/register.php', formData);
    info = JSON.parse(info);
    
    // Alert user
    alert(info.message);
}

/*
 * Autenticate and login
 */
async function changePassword() {

    // General declaration
    let currentPassword = field("current").value;
    let newPassword = field("new").value;
    let confirmPassword = field("confirm").value;
    let formData = new FormData();

    // Set commands to end session
    formData.append('_CURRENT_', currentPassword);
    formData.append('_NEW_', newPassword);
    formData.append('_CONFIRM_', confirmPassword);
    
    // Execute backend
    let info = await execute('async/changepassword.php', formData);
    info = JSON.parse(info);
    
    // Inform user
    alert(info.message);

    // Set focus
    if (info.field != "") {
        field(info.field).focus();
    }

}