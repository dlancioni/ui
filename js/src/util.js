class Filter {

    // Constructor
    constructor() {
        this.condition = [];
    }

    add(tableName, fieldName, fieldValue) {
        let item = '';
        item = `{"table":"${tableName}","field":"${fieldName}","type":"int","operator":"=","value":${fieldValue},"mask":""}`;
        this.condition.push(item);
    }

    condition(tableName, fieldName, fieldValue, fieldType, fieldOperator, fieldMask) {
        let item = '';
        item = `{"table":"${tableName}","field":"${fieldName}","type":"${fieldType}","operator":"${fieldOperator}","value":${fieldValue},"mask":"${fieldMask}"}`;
        this.condition.push(item);
    }

    create() {
        let output = "[";
        this.condition.forEach(item => output += item + ",");
        output += "]";
        output = output.replace(",]", "]");
        return output;
    }
  
// End of class
}