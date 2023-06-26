<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class SearchController extends Controller {

    public function index() {
        echo \GuzzleHttp\json_encode($this->post('products', ['data' => ['get_all_products_name' => '1']]));
       

    }

}
