<?php

namespace App\Models;

use CodeIgniter\Model;
use function PHPUnit\Framework\isNull;

class Flight extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'flights_data';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "from_airport_code",
        "from_country",
        "dest_airport_code",
        "dest_country",
        "aircraft_type",
        "airline_number",
        "airline_name",
        "flight_number",
        "departure_time",
        "arrival_time",
        "duration",
        "stops",
        "price",
        "currency",
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
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getFlights($data) {
        $where = '';
        
        if (isset($data["departure"])) {
            $where .= "from_country" . $data["departure"] . "'";
        }

        if (isset($data["destination"])) {
            $where .= " AND dest_country ='" . $data["destination"] . "'";
        }

        if (isset($data["departure-date"])) {
            $where .= " AND DATE(departure_time) ='" . $data["departure-date"] . "'";
        }

        if (isset($data["flight-type"])) {
            if ($data["flight-type"] == "direct-flight") {
                $where .= " AND stops = 0";
            } else {
                $where .= " AND stops != 0";
            }
        }

        if (!isNull($data["min-budget"]) && !isNull($data["max-budget"])) {
            $where .= " AND price BETWEEN " . $data["min-budget"] . " AND " . $data["max-budget"];
        }

        return $this->where($where)->get(10, 0)->getResult();
    }


    public function getReturnFlights($data) {
        $where = '';

        if (isset($data["departure"])) {
            $where .= " from_country ='" . $data["destination"] . "'";
        }

        if (isset($data["destination"])) {
            $where .= " AND dest_country ='" . $data["departure"] . "'";
        }

        if (isset($data["departure-date"])) {
            $where .= " AND DATE(departure_time) ='" . $data["return-date"] . "'";
        }

        if (isset($data["flight-type"])) {
            if ($data["flight-type"] == "direct-flight") {
                $where .= " AND stops = 0";
            } else {
                $where .= " AND stops != 0";
            }
        }

        return $this->where($where)->get(10, 0)->getResult();
    }


    public function getSingleFlight($flightId) {
        return $this->where(["id" => $flightId])->get(1)->getResult();
    }


}
