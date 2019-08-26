<?php

namespace Controllers;

class HomeController {
    public function home ($request, $response, $args)
    {
        $aAuthenticated = authIsAuthenticated();	
        $aData = array();
        $aUser = $aAuthenticated ? authGetAuthenticatedUserInfo() : null;
        
        $aData['events'] = array();
        $aEvents = eventFindAll();
        
        foreach($aEvents as $aId => $aInfo) {
            $aDate = $aInfo['day'] . ' de ' . utilMonthToString($aInfo['month']) . ' ('.utilWeekDayToString($aInfo['day'], $aInfo['month']).')';
            
            if (!isset($aData['events'][$aDate])) {
                $aData['events'][$aDate] = array();
            }
            
            $aData['events'][$aDate][$aId] = $aInfo;
        }
        
        if ($aAuthenticated) {
            $aData['attending']	= attendingFindByUserId($aUser['id']);
        }

        $aData['authenticated'] = $aAuthenticated;
        $aData['isAdmin'] = userIsLevel($aUser, USER_LEVEL_ADMIN);
        
        \core\View::render('index', $aData);
        return $response;
    }
}