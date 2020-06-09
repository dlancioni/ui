class Button {
  // Constructor
  constructor(json) {
      this.json = json;
  }
  // Public methods  
  do() {
      return "Json to generate button " + this.json;
  }
}
module.exports = {
  Button
};