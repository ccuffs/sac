<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Models\User;
use App\Models\Competition;
use App\Helpers\AuthHelper;

class CompetitionController {
    public function index ($request, $response, $args) {
        AuthHelper::allowAuthenticated();
        
        $data			= array();
        $user 			= User::getById($_SESSION['user']);
        $isAdmin 		= $user->isLevel(User::USER_LEVEL_ADMIN);
        $competition 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        $data['user'] = $user;
        
        if (!$isAdmin) {
            View::render('restricted');
            return $response;
        }
        
        $data['competition'] = Competition::getById($competition);
        
        View::render('competition-manager', $data);
        return $response;
    }

    public function create ($request, $response, $args) {
        AuthHelper::allowAuthenticated();
        $data			= array();
        $user 			= User::getById($_SESSION['user']);
        $isAdmin 		= $user->isLevel(User::USER_LEVEL_ADMIN);
        $competition 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $data['user'] = $user;
        $data['createdOrUpdated'] 	= Competition::create($_POST);

        if (!$isAdmin) {
            View::render('restricted');
            return $response;
        }

        $data['competition'] = Competition::getById($competition);

        View::render('competition-manager', $data);
        return $response;
    }

    /* TODO: test this function */
    public function show ($request, $response, $args)
    {
        $aId 					= isset($_REQUEST['competition']) ? $_REQUEST['competition'] : 0;
        $aComptetition 			= Competition::getById($aId);
        $aAuthenticated 		= AuthHelper::isAuthenticated();	
        $aTeam					= null;
        $user					= null;
        $isAdmin				= false;
        $aCompetitors			= userFindAll();
        
        if($aAuthenticated) {
            $user				= AuthHelper::getAuthenticatedUser();
            $aTeam				= competitionFindTeamByLeaderId($aId, $user['id']);
            
            $isAdmin 			= $user->isLevel(User::USER_LEVEL_ADMIN);
        }

        if (isset($_REQUEST['register']) && $aComptetition != null && $aAuthenticated && $user != null) {
            $aTeamId = @$_REQUEST['id'];
            
            $aTeam['fk_leader'] = $user['id'];
            $aTeam['name']		= isset($_POST['name']) ? $_POST['name'] : '';
            $aTeam['url'] 		= isset($_POST['url']) ? $_POST['url'] : '';
            $aTeam['members'] 	= serialize(array(@$_POST['member0'], @$_POST['member1'], @$_POST['member2'], @$_POST['member3'], @$_POST['member4']));
            
            $aOk = competitionUpdateOrCreateTeam($aComptetition['id'], $aTeamId, $aTeam);
            $aTeam = competitionFindTeamByLeaderId($aComptetition['id'], $user['id']);
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
            'isAdmin'			=> $isAdmin,
        ));
        return $response;
    }
}