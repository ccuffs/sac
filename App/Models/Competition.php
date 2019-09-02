<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;

class Competition {
  public function getById($theId) {
    $conn = DatabaseHelper::getConn();
    
    $result = null;
    $query = $conn->prepare("SELECT * FROM competition WHERE id = ?");
    
    if ($query->execute(array($theId))) {
      $result = $query->fetch();
    }
    
    return $result;
  }
  
  public function findAll() {
    $conn = DatabaseHelper::getConn();
    
    $result = array();
    $query = $conn->prepare("SELECT * FROM competition WHERE 1");
    
    if ($query->execute()) {
      while ($aRow = $query->fetch()) {
        $result[$aRow['id']] = $aRow;
      }
    }
    
    return $result;
  }
  
  public function findTeams($theCompetitionId) {
    $conn = DatabaseHelper::getConn();
    
    $result = array();
    $query = $conn->prepare("SELECT * FROM teams WHERE fk_competition = ?");
    
    if ($query->execute(array($theCompetitionId))) {
      while ($aRow = $query->fetch()) {
        $result[$aRow['id']] = $aRow;
      }
    }
    
    return $result;
  }
  
  public function findTeamByLeaderId($theCompetitionId, $theLeaderId) {
    $conn = DatabaseHelper::getConn();
    
    $result = null;
    $query = $conn->prepare("SELECT * FROM teams WHERE fk_competition = ? AND fk_leader = ?");
    
    if ($query->execute(array($theCompetitionId, $theLeaderId))) {
      $result = $query->fetch();
    }
    
    return $result;
  }
  
  public function updateOrCreateTeam($theCompetitionId, $theTeamId, $theTeamInfo) {
    $conn = DatabaseHelper::getConn();
    
    $result 	= false;
    $query = $conn->prepare("INSERT INTO teams (id, fk_leader, fk_competition, name, members, url) VALUES (".(is_numeric($theTeamId) ? '?' : 'NULL').", ?, ?, ?, ?, ?)
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
    $conn = DatabaseHelper::getConn();
    
    $result 	= false;
    $query = $conn->prepare("INSERT INTO competition (title, headline, description, prizes, rules, style)
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
}
