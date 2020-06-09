class Form {

    // Constructor
    constructor(json) {
        this.json = json;
    }

    // Public methods
    do() {
        return "Json to generate form " + this.json;
    }
}
module.exports = {
    Form
  };