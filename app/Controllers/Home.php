<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index() {
        
        $flight = new \App\Models\Flight();
        $departCountries = $flight->distinct('from_country')->select('from_country')->get()->getResult();
        $arriveCountries = $flight->distinct('dest_country')->select('dest_country')->get()->getResult();

        return view('index', ['departCountries' => $departCountries, 'arriveCountries' => $arriveCountries]);
    }

    public function bookFlight($flightId) {

        $flightsModel = new \App\Models\Flight();
        $flight = $flightsModel->getSingleFlight($flightId);
        $data["flight"] = $flight[0];
        return view("booking", $data);
    }

    
}
