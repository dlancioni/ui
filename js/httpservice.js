
// Out of class
async function persist(formData) {

    try {
        // Submit it        
        let response = await fetch('./php/async/persist.php', {
            method: 'POST',
            body: formData
        });
        // Return processing results
        return await response.text();
    } catch (ex) {
        // Error handling
        return ex;
    }   
}

// Login and keep info in session
async function execute(page, formData) {

    try {

        // Define page to call
        page = './php/' + page;

        // Submit it        
        let response = await fetch(page, {
            method: 'POST',
            body: formData
        });

        // Return processing results
        return await response.text();

    } catch (ex) {
        // Error handling
        return ex;
    }
}
