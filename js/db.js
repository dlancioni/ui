/*
 * Functions used to manipulated the database
 */
function persist($formData) {
    let httpService = new HTTPService();
    info = httpService.persist($formData);
    return info;
}

function query(sql) {
    let httpService = new HTTPService();
    info = httpService.query(sql);
    return info;
}