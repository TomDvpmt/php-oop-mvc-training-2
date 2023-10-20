class Billing {
    constructor() {
        this.inputs = document.getElementsByClassName("billing-field");
        this.paymentOption = document.getElementById("demo-payment-type");
        this.fillButton = document.getElementById("billing-fill-button");
        this.demoData = {
            name: "Tintin",
            email: "the_unicorn@mock.com",
            phone: 1234567890,
            address: "Marlinspike Hall",
            zipcode: "10000",
            city: "Marlinspike",
            country: "Belgium",
        };
    }

    setDemoValues = () => {
        Array.from(this.inputs).forEach((input) => {
            if (Object.keys(this.demoData).includes(input.name)) {
                input.value = this.demoData[input.name];
            }
        });
        this.paymentOption.setAttribute("selected", true);
    };

    setFillButtonListener() {
        this.fillButton.addEventListener("click", this.setDemoValues);
    }
}

const billing = new Billing();
billing.setFillButtonListener();
