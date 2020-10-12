/*
 * Format value
 */
async function login() {
    
    let code = document.getElementById("_SIGNID_").value;
    let username = document.getElementById("_USERNAME_").value;
    let password = document.getElementById("_PASSWORD_").value;

    let info = await async_login(getFormData());
    if (info.trim() == "1") {
        alert('logado');
        document.form1.method = 'post';
        document.form1.action = 'index.php';
        document.form1.submit();
    }

}
