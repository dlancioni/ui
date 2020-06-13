class Button {
  // Constructor
  constructor(json) {
      this.json = json;
  }
  // Public methods  
  do() {

      let html = '';      
      let type = 'button';
      let name = '';
      let value = '';
      let event = '';

      name = 'gotab';
      value = 'Table';
      event = `onClick="go('table')"`;
      html += `<input type="${type}" name="${name}" value="${value}" ${event}>`;

      name = 'gofor';
      value = 'Form';
      event = `onClick="go('form')"`;
      html += `<input type="${type}" name="${name}" value="${value}" ${event}>`;      
      return html;
  }
}