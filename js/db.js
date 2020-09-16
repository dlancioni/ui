/*
 * Functions used to manipulated the database
 * Do not change here
 */
function persist($formData) {
    let httpService = new HTTPService();
    info = httpService.persist($formData);
    return info;
}

/*
 * Used to execute query against the database
 */
function query(sql) {
    let httpService = new HTTPService();
    info = httpService.query(sql);
    return JSON.parse(info);
}