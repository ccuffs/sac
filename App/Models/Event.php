<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;

class Event {
    public static function getById($theId) {
        $conn = DatabaseHelper::getConn();
        
        $result = null;
        $aQuery = $conn->prepare("SELECT * FROM event WHERE id = ?");
        
        if ($aQuery->execute(array($theId))) {
            $result = $aQuery->fetch();
        }
        
        return $result;
    }
  
    public function delete($theId) {
        $conn = DatabaseHelper::getConn();
        
        $aQuery = $conn->prepare("DELETE FROM event WHERE id = ?");
        return $aQuery->execute(array($theId));
    }
  
    public function findAll() {
        $conn = DatabaseHelper::getConn();
        
        $result = array();
        $aQuery = $conn->prepare("SELECT * FROM event WHERE 1 ORDER BY day ASC, month ASC, time ASC");
        
        if ($aQuery->execute()) {
            while ($aRow = $aQuery->fetch()) {
                $result[$aRow['id']] = $aRow;
            }
        }
        
        return $result;
    }
  
    public function findByUserIsAttending($theUserId) {
        $conn = DatabaseHelper::getConn();
        
        $result = array();
        $aQuery = $conn->prepare("SELECT * FROM event WHERE id IN (SELECT fk_event FROM attending WHERE fk_user = ?)");
        
        if ($aQuery->execute(array($theUserId))) {
            while ($aRow = $aQuery->fetch()) {
                $result[$aRow['id']] = $aRow;
            }
        }
        
        return $result;
    }
  
    public function create($data) {
        $conn = DatabaseHelper::getConn();

        $result 	= false;

        $ghost = $data['ghost'] == 1;

        /* I'm interpolating ghost in the sql because for some reason when I bindParam it I got and error  */

        $sql = "INSERT INTO event (fk_competition , day , month , time , title , description , place , price , capacity , waiting_capacity , ghost) VALUES
                    (:fk_competition, :day, :month, :time, :title, :description, :place, :price, :capacity, :waiting_capacity, $ghost)";
        $aQuery = $conn->prepare($sql);

        $fk_competition = $data['fk_competition'] ? $data['fk_competition'] : null;

        $aQuery->bindParam('fk_competition', $fk_competition);
        $aQuery->bindParam('day', $data['day']);
        $aQuery->bindParam('month', $data['month']);
        $aQuery->bindParam('time', $data['time']);
        $aQuery->bindParam('title', $data['title']);
        $aQuery->bindParam('description', $data['description']);
        $aQuery->bindParam('place', $data['place']);
        $aQuery->bindParam('price', $data['price']);
        $aQuery->bindParam('capacity', $data['capacity']);
        $aQuery->bindParam('waiting_capacity', $data['waiting_capacity']);

        $result = $aQuery->execute();
        return $result;
    }
}