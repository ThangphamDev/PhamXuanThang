<?php
require_once('app/controllers/Controller.php');

class DefaultController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        echo "HELLO HUTECH ";
    }
}