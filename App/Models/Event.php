<?php

namespace App\Models;

class Event extends Model {
    protected $table = "event";

    public $id;
    public $day;
    public $month;
    public $time;
    public $title;
    public $description;
    public $place;
    public $price;
    public $capacity;
    public $waitingCapacity;
    public $ghost;
    public $fk_competition;

    public static function findById($id) {
        $result = null;
        $query = SELF::conn()->prepare("SELECT * FROM event WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
        
        $data = $query->fetch();
        if (!$data) {
            return null;
        }
        
        return SELF::newByData($data);
    }
  
    public static function findAll() {
        $result = [];
        $query = SELF::conn()->prepare("SELECT * FROM event WHERE 1 ORDER BY day ASC, month ASC, time ASC");
        
        if ($query->execute()) {
            while ($event_data = $query->fetch()) {
                $result[] = SELF::newByData($event_data);
            }
        }
        
        return $result;
    }

    public static function findPriceds() {
        $query = SELF::conn()->prepare("SELECT * FROM event WHERE price > 0 ORDER BY day ASC, month ASC, time ASC");
        
        if ($query->execute()) {
            while ($event_data = $query->fetch()) {
                $result[] = SELF::newByData($event_data);
            }
        }
        
        return $result;
    }
  
    public function findByUserIsAttending($theUserId) {
        $result = array();
        $query = SELF::conn()->prepare("SELECT * FROM event WHERE id IN (SELECT fk_event FROM attending WHERE fk_user = ?)");
        
        if ($query->execute(array($theUserId))) {
            while ($aRow = $query->fetch()) {
                $result[$aRow['id']] = $aRow;
            }
        }
        
        return $result;
    }

    public function update() {
        $sql = "UPDATE `event`
            SET
                day = :day,
                month = :month,
                time = :time,
                title = :title,
                description = :description,
                place = :place,
                price = :price,
                capacity = :capacity,
                waiting_capacity = :waiting_capacity,
                ghost = :ghost,
                fk_competition = :fk_competition
            WHERE id = :id    
        ";

        $query = SELF::conn()->prepare($sql);

        $this->fk_competition = null;

        $query->bindParam('id', $this->id);
        $query->bindParam('day', $this->day);
        $query->bindParam('month', $this->month);
        $query->bindParam('time', $this->time);
        $query->bindParam('title', $this->title);
        $query->bindParam('description', $this->description);
        $query->bindParam('place', $this->place);
        $query->bindParam('price', \App\Helpers\UtilsHelper::format_money($this->price));
        $query->bindParam('capacity', $this->capacity);
        $query->bindParam('waiting_capacity', $this->waitingCapacity);
        $query->bindParam('ghost', $this->ghost);
        $query->bindParam('fk_competition', $this->fk_competition);

        $result = $query->execute();

        return $result;
    }
  
    public function create() {
        $sql = "INSERT INTO event (fk_competition , day , month , time , title , description , place , price , capacity , waiting_capacity , ghost) VALUES
                    (:fk_competition, :day, :month, :time, :title, :description, :place, :price, :capacity, :waiting_capacity, :ghost)";

        $query = SELF::conn()->prepare($sql);

        $query->bindParam('fk_competition', $this->fk_competition);
        $query->bindParam('day', $this->day);
        $query->bindParam('month', $this->month);
        $query->bindParam('time', $this->time);
        $query->bindParam('title', $this->title);
        $query->bindParam('description', $this->description);
        $query->bindParam('place', $this->place);
        $query->bindParam('price', $this->price);
        $query->bindParam('capacity', $this->capacity);
        $query->bindParam('ghost', $this->ghost);
        $query->bindParam('waiting_capacity', $this->waitingCapacity);

        $result = $query->execute();
        if (!$result) return false;
        return SELF::conn()->lastInsertId(); 
    }

    private static function newByData ($data) {
        $data = (object) $data;
        $event = new SELF();
        $event->id = $data->id;
        $event->day = $data->day;
        $event->month = $data->month;
        $event->time = $data->time;
        $event->title = $data->title;
        $event->description = $data->description;
        $event->place = $data->place;
        $event->price = $data->price;
        $event->capacity = $data->capacity;
        $event->waitingCapacity = $data->waiting_capacity;
        $event->ghost = $data->ghost;
        $event->fk_competition = $data->fk_competition;
        return $event;
    }
}