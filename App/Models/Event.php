<?php

namespace App\Models;

class Event extends Model {
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

    public static function getById($id) {
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
  
    public function delete($theId) {
        $query = SELF::conn()->prepare("DELETE FROM event WHERE id = ?");
        return $query->execute(array($theId));
    }
  
    public function findAll() {
        $result = [];
        $query = SELF::conn()->prepare("SELECT * FROM event WHERE 1 ORDER BY day ASC, month ASC, time ASC");
        
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
  
    public function create($data) {
        $result 	= false;

        $ghost = (int) ($data['ghost'] == 1);

        /* I'm interpolating ghost in the sql because for some reason when I bindParam it I got and error  */

        $sql = "INSERT INTO event (fk_competition , day , month , time , title , description , place , price , capacity , waiting_capacity , ghost) VALUES
                    (:fk_competition, :day, :month, :time, :title, :description, :place, :price, :capacity, :waiting_capacity, $ghost)";

        $query = SELF::conn()->prepare($sql);

        $fk_competition = $data['fk_competition'] ? $data['fk_competition'] : null;

        $query->bindParam('fk_competition', $fk_competition);
        $query->bindParam('day', $data['day']);
        $query->bindParam('month', $data['month']);
        $query->bindParam('time', $data['time']);
        $query->bindParam('title', $data['title']);
        $query->bindParam('description', $data['description']);
        $query->bindParam('place', $data['place']);
        $query->bindParam('price', $data['price']);
        $query->bindParam('capacity', $data['capacity']);
        $query->bindParam('waiting_capacity', $data['waiting_capacity']);

        $result = $query->execute();
        return $result;
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