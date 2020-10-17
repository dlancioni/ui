/*
 * Autenticate and login
 */
async function login() {
    
    let code = document.getElementById("_SIGNID_").value;
    let username = document.getElementById("_USERNAME_").value;
    let password = document.getElementById("_PASSWORD_").value;

    let info = await async_login(getFormData());
    info = JSON.parse(info);
    
    if (info.status == 1) {
        alert(info.message);
        submit();
    } else {
        alert(info.message);
    }

}

/*
 * End session and logout
 */
async function logout() {
    
    // General Declaration
    let page = 'eval.php';
    let formData = new FormData();

    // Set commands to end session
    formData.append('1', '$_SESSION["status"] = 0;');
    formData.append('2', 'session_destroy();');

    // Execute it in server side
    await execute(page, formData);

    // Refresh it
    submit();

}