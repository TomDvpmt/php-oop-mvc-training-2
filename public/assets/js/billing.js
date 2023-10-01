class Billing {
    constructor() {
        this.inputs = document.getElementsByClassName("billing-field");
        console.log(this.inputs);
        this.fillButton = document.getElementById("billing-fill-button");
        console.log(this.fillButton);
        this.demoData = {
            name: "Edmund Hillary",
            email: "edmund_hillary@mock.com",
            phone: 1234567890,
            address: "Mount Everest",
            zipcode: "44600",
            city: "Katmandu",
            country: "Nepal",
        };
    }

    setDemoValues = () => {
        Array.from(this.inputs).forEach((input) => {
            if (Object.keys(this.demoData).includes(input.name)) {
                input.value = this.demoData[input.name];
            }
        });
    };

    setFillButtonListener() {
        this.fillButton.addEventListener("click", this.setDemoValues);
    }
}

const billing = new Billing();
billing.setFillButtonListener();
