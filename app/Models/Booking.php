<?php

namespace App\Models;

use CodeIgniter\Model;

class Booking extends Model {
    protected $DBGroup          = 'default';
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "user_id",
        "flight_id",
        "booking_price",
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Booking flight
    public function bookFlight() {
        $usersModel = new \App\Models\User();
        $user = $usersModel->getUser($_POST["email"]);

        if ($user) {
            $user_id = $user[0]->id;
        } else {
            $user_id = $usersModel->createUser($_POST);
        }

        $flightsModel = new \App\Models\Flight();
        $flight = $flightsModel->getSingleFlight($_POST["flight-id"], ["id", "price"])[0];

        $bookingModel = new \App\Models\Booking();
        $booking_id = $bookingModel->createBooking($user_id, $flight->id, $flight->price);

        echo json_encode(["success" => true, "booking_id" => $booking_id]);
    }

}

