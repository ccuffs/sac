<?php

namespace App\Controllers;

use \core\View;

class CompetitionController {
    public function index ($request, $response, $args) {
        authAllowAuthenticated();
        
        $aData			= array();
        $aUser 			= userGetById($_SESSION['user']['id']);
        $aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
        $aCompetition 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        $aData['user'] = $aUser;
        
        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
        }
        
        $aData['competition'] = competitionGetById($aCompetition);
        
        View::render('competition-manager', $aData);
        return $response;
    }

    public function create ($request, $response, $args) {
        authAllowAuthenticated();
        $aData			= array();
        $aUser 			= userGetById($_SESSION['user']['id']);
        $aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
        $aCompetition 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $aData['user'] = $aUser;
        $aData['createdOrUpdated'] 	= competitionUpdateOrCreate($aCompetition, $_POST);

        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
        }

        $aData['competition'] = competitionGetById($aCompetition);

        View::render('competition-manager', $aData);
        return $response;
    }

    /* TODO: test this function */
    public function execute ($request, $response, $args)
    {
        $aId 					= isset($_REQUEST['competition']) ? $_REQUEST['competition'] : 0;
        $aComptetition 			= competitionGetById($aId);
        $aAuthenticated 		= authIsAuthenticated();	
        $aTeam					= null;
        $aUser					= null;
        $aIsAdmin				= false;
        $aCompetitors			= userFindAll();
        
        if($aAuthenticated) {
            $aUser				= authGetAuthenticatedUserInfo();
            $aTeam				= competitionFindTeamByLeaderId($aId, $aUser['id']);
            
            $aIsAdmin 			= userIsLevel($aUser, USER_LEVEL_ADMIN);
        }

        if (isset($_REQUEST['register']) && $aComptetition != null && $aAuthenticated && $aUser != null) {
            $aTeamId = @$_REQUEST['id'];
            
            $aTeam['fk_leader'] = $aUser['id'];
            $aTeam['name']		= isset($_POST['name']) ? $_POST['name'] : '';
            $aTeam['url'] 		= isset($_POST['url']) ? $_POST['url'] : '';
            $aTeam['members'] 	= serialize(array(@$_POST['member0'], @$_POST['member1'], @$_POST['member2'], @$_POST['member3'], @$_POST['member4']));
            
            $aOk = competitionUpdateOrCreateTeam($aComptetition['id'], $aTeamId, $aTeam);
            $aTeam = competitionFindTeamByLeaderId($aComptetition['id'], $aUser['id']);
        }

        if($aTeam != null) {
            $aArray = @unserialize($aTeam['members']);
            $aTeam['members'] = $aArray === false ? array() : $aArray;
        }
        
        View::render('competition', array(
            'competition' 		=> $aComptetition,
            'teams' 			=> competitionFindTeams($aId),
            'team' 				=> $aTeam,
            'competitors' 		=> $aCompetitors,
            'authenticated'		=> $aAuthenticated,
            'isAdmin'			=> $aIsAdmin,
        ));
        return $response;
    }
}