
// Perform crud in the database
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

// Perform queries in the database
async function query(statement) {

    // General declaration
    let formData = new FormData();

    try {

        // Send sql to backend
        formData.append('_SQL_', statement);

        // Submit it        
        let response = await fetch('./php/async/query.php', {
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
