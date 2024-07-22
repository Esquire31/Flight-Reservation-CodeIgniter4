<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Flight as FlightsModel;


class Flight extends BaseController
{
    public function getFlights() {

        $model = new FlightsModel();
        $flights = $model->getFlights($_GET);

        echo json_encode(["departureFlights" => $flights]);

    }

    public function getFlights(){

        $model = new FlightsModel();

        $flights = $model->getFlights($_GET);

        if (!isset($_GET["return-date"])) {
            echo json_encode(["departureFlights" => $flights]);
        } else {
            $returnFlights = $model->getReturnFlights($_GET);

            echo json_encode(["departureFlights" => $flights, "returnFlights" => $returnFlights]);
        }
    }

}

