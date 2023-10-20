class Billing {
    constructor() {
        this.form = document.getElementById("billing-form");
        this.inputs = document.getElementsByClassName("billing-field");
        this.paymentDemoOption = document.getElementById("demo-payment-type");
        this.paymentTypeQuestion = document.getElementById(
            "payment-type-question"
        );
        this.fillButton = document.getElementById("billing-fill-button");
        this.clearButton = document.getElementById("billing-clear-button");
        this.saveAddressCheckbox = document.getElementById("save-address");
        this.addressSlugField = document.getElementById("address-slug-field");
        this.addressSlugInput = document.getElementById("address-slug-input");

        this.demoData = {
            name: "Tintin",
            email: "the_unicorn@mock.com",
            phone: 1234567890,
            address: "Marlinspike Hall",
            zipcode: "10000",
            city: "Marlinspike",
            country: "Belgium",
            addressSlug: "Tintin's",
        };
    }

    // TODO : JSDoc

    setDemoValues = () => {
        Array.from(this.inputs).forEach((input) => {
            if (Object.keys(this.demoData).includes(input.name)) {
                input.value = this.demoData[input.name];
            }
        });
        this.paymentDemoOption.setAttribute("selected", true);
        this.addressSlugInput.value = this.demoData.addressSlug;
    };

    clearForm = () => {
        Array.from(this.inputs).forEach((input) => {
            input.value = null;
        });
        this.paymentDemoOption.removeAttribute("selected");
        this.addressSlugInput.value = null;
    };

    toggleAddressSlugField = () => {
        this.addressSlugField.classList.toggle("visible");
        let destination = this.addressSlugField.classList.contains("visible")
            ? document.location.origin + "/public/order?action=saveAddress" // TODO : dynamic root path without "public"
            : document.location.origin + "/public/order?action=recap"; // TODO : dynamic root path without "public"
        this.form.setAttribute("action", destination);
    };

    setFormActionAttribute = (value) => {
        this.form.setAttribute("action", value);
    };

    setFillButtonListener() {
        this.fillButton.addEventListener("click", this.setDemoValues);
    }

    setClearButtonListener() {
        this.clearButton.addEventListener("click", this.clearForm);
    }

    setSaveAddressCheckboxListener() {
        this.saveAddressCheckbox.addEventListener(
            "change",
            this.toggleAddressSlugField
        );
    }
}

const billing = new Billing();
billing.setFillButtonListener();
billing.setClearButtonListener();
billing.setSaveAddressCheckboxListener();
