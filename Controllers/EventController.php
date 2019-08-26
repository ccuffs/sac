<?php

namespace Controllers;

use \core\View;

class EventController {
    public function  adminIndex ($request, $response, $args)
    {
        authAllowAuthenticated();
	
        $aData		= array();
        $aUser 		= userGetById($_SESSION['user']['id']);
        $aIsAdmin 	= userIsLevel($aUser, USER_LEVEL_ADMIN);
        $aEventId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        $aData['user'] = $aUser;
        $aData['event'] = array();
        
        if (!$aIsAdmin) {
            header("Location: restricted.php");
            exit();
        }

        if (isset($_REQUEST['delete'])) {
            $aData['createdOrUpdated'] = eventDelete($_REQUEST['delete']);
            
        } else {
            $aData['event'] = eventGetById($aEventId);	
        }
        
        $aData['competitions'] = competitionFindAll();

        View::render('event-manager', $aData);
        return $response;
    }

    public function create ($request, $response, $args)
    {
        authAllowAuthenticated();
	
        $aData		= array();
        $aUser 		= userGetById($_SESSION['user']['id']);
        $aIsAdmin 	= userIsLevel($aUser, USER_LEVEL_ADMIN);
        $aEventId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        if (!$aIsAdmin) {
            header("Location: restricted.php");
            exit();
        }

        $aData['user'] = $aUser;
        $aData['event'] = array();

        $aData['createdOrUpdated'] = eventUpdateOrCreate($aEventId, $_POST);

        $aData['competitions'] = competitionFindAll();

        View::render('event-manager', $aData);
        return $response;
    }
}