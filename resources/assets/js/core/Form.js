import Errors from "./Errors";

class Form {
    constructor() {
        this.data = { };
        this.errors = new Errors()
    }
}

export default Form;