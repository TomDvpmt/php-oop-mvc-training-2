<?php

class Home extends Controller {
    
    public function index() {
        // echo "This is home controller";
        $this->view("home");
    }
}