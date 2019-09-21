<?php

namespace App\Models;

class Competition extends Model {
    public static function findById($id) {
        $result = null;
        $query = SELF::conn()->prepare("SELECT * FROM competition WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
        
        $data = $query->fetch();
        if (!$data) {
            return null;
        }
        
        return SELF::newByData($data);
    }
  
    public function findAll() {
        $result = [];
        $query = SELF::conn()->prepare("SELECT * FROM competition");
        
        if ($query->execute()) {
            while ($data = $query->fetch()) {
                $result[] = SELF::newByData($data);
            }
        }
            
        return $result;
    }
  
  public function findTeams($theCompetitionId) {
    $result = array();
    $query = SELF::conn()->prepare("SELECT * FROM teams WHERE fk_competition = ?");
    
    if ($query->execute(array($theCompetitionId))) {
      while ($aRow = $query->fetch()) {
        $result[$aRow['id']] = $aRow;
      }
    }
    
    return $result;
  }
  
  public function findTeamByLeaderId($theCompetitionId, $theLeaderId) {
    $result = null;
    $query = SELF::conn()->prepare("SELECT * FROM teams WHERE fk_competition = ? AND fk_leader = ?");
    
    if ($query->execute(array($theCompetitionId, $theLeaderId))) {
      $result = $query->fetch();
    }
    
    return $result;
  }
  
  public function updateOrCreateTeam($theCompetitionId, $theTeamId, $theTeamInfo) {    
    $result 	= false;
    $query = SELF::conn()->prepare("INSERT INTO teams (id, fk_leader, fk_competition, name, members, url) VALUES (".(is_numeric($theTeamId) ? '?' : 'NULL').", ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE fk_leader = ?, fk_competition = ?, name = ?, members = ?, url = ?");
    
    $query_params = array();
    
    if (is_numeric($theTeamId)) {
      $query_params[] = $theTeamId;
    }
    
    $query_params[] = $theTeamInfo['fk_leader'];
    $query_params[] = $theCompetitionId;
    $query_params[] = $theTeamInfo['name'];
    $query_params[] = $theTeamInfo['members'];
    $query_params[] = $theTeamInfo['url'];
    
    $query_params[] = $theTeamInfo['fk_leader'];
    $query_params[] = $theCompetitionId;
    $query_params[] = $theTeamInfo['name'];
    $query_params[] = $theTeamInfo['members'];
    $query_params[] = $theTeamInfo['url'];
    
    $result = $query->execute($query_params);
    return $result;
  }
  
  public static function create($theCompetitionInfo) {
    $result 	= false;
    $query = SELF::conn()->prepare("INSERT INTO competition (title, headline, description, prizes, rules, style)
                                          VALUES (:title, :headline, :description, :prizes, :rules, :style)");
    
    $query_params = [
      "title" => $theCompetitionInfo['title'],
      "headline" => $theCompetitionInfo['headline'],
      "description" => $theCompetitionInfo['description'],
      "prizes" => $theCompetitionInfo['prizes'],
      "rules" => $theCompetitionInfo['rules'],
      "style" => $theCompetitionInfo['style']
    ];
    
    $result = $query->execute($query_params);
    return $result;
  }

    private static function newByData ($data) {
        $data = (object) $data;
        $event = new SELF();
        $event->id = $data->id;
        $event->title = $data->title;
        $event->headline = $data->headline;
        $event->description = $data->description;
        $event->prizes = $data->prizes;
        $event->rules = $data->rules;
        $event->style = $data->style;
        return $event;
    }
}
