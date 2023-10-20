<?php

namespace PhpTraining2\controllers;

use Exception;
use PhpTraining2\core\Controller;
use PhpTraining2\core\ControllerInterface;
use PhpTraining2\models\BillingAddress;
use PhpTraining2\models\Cart;
use PhpTraining2\models\Order;
use PhpTraining2\models\users\User;

class OrderController implements ControllerInterface {
    use Controller;

    private Cart $cart;
    
    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function index(): void {
        $this->view("pages/cart");
    }


    /**
     * Display the billing info page
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function billing(): void {
        // TODO : ADD TO ALL PUBLIC FUNCTIONS ?
        // if(!$this->isUserLoggedIn()) {
        //     $this->sendToSigninPage("order?action=billing");
        // }

        try {
            $user = new User();
            $addresses = $user->getBillingAddresses();
        } catch (Exception $e) {
            $this->view("pages/billing", [
                "error" => PRODUCTION ? "Unable to display your billing addresses." : $e->getMessage(),
                "errorLocation" => "addresses"
            ]);
        }
        
        $addressSlug = $_POST["addressOption"] ?? null;
        if ($addressSlug) {
            $chosenAddress = array_values(array_filter($addresses, fn($address) => $address["address_slug"] === $addressSlug))[0];
            $this->view("pages/billing", $addresses ? ["addresses" => $addresses, "chosenAddress" => $chosenAddress] : []);
        }

        // TODO : form validation

        $this->view("pages/billing", $addresses ? ["addresses" => $addresses] : []);
    }

    /**
     * Save billing address for this user
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function saveAddress(): void {
        // TODO : form validation
        try {
            $data = $this->filterDataForUser($_POST, ["payment_type", "save_address"]);
            $address = new BillingAddress($data);
            $address->saveBillingAddress($data);
            $this->recap($data);
        } catch (Exception $e) {
            // TODO : deal with duplicate entry error (Integrity constraint violation: 1062)
            show($e->getMessage());
        }
    }


    /**
     * Display the recap page (billing info + cart)
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function recap($data = null): void {
        $items = $this->cart->getAllItems();
        $totalPrice = $this->cart->getTotalPrice();
        $billingInfo = $data ? $data : $this->filterDataForUser($_POST, ["address_slug", "save_address"]);
        $this->view("pages/recap", ["items" => $items, "billingInfo" => $billingInfo, "totalPrice" => $totalPrice]);
    }


    /**
     * Display the order confirmation page
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function confirm(): void {
        $this->cart->removeAllItems();
        $order = new Order();
        
        // TODO : register billing address

        // TODO : Register order in DB
        
        $orderId = $order->getId();

        $this->view("pages/confirmation", ["orderId" => $orderId]);
    }

    /**
     * Get only the data that should be displayed to the user
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param array $data The array to filter
     * @param array $wrongProperties The data that should not be displayed
     * @return array
     */

    private function filterDataForUser(array $data, array $wrongProperties): array {
        return array_filter($data, fn($key) => !in_array($key, $wrongProperties), ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get a billing address by its slug
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param string $addressSlug
     * @return array|null
     */

    private function getOneBillingAddress(string $addressSlug): array|null { // TODO : remove if unused
        $address = new BillingAddress();
        $address = $address->getOne($addressSlug);
        return $address;
    }

}