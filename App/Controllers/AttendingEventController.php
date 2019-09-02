<?php

namespace App\Controllers;

use App\Models\Event;
use App\Models\Subscription;

class AttendingEventController {
    public function updateSubscription ($request, $response, $args)
    {
        authAllowAuthenticated();

        $aEventId 	= isset($_REQUEST['event']) ? (int)$_REQUEST['event'] : '';
        $aAction 	= isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        $aRet 		= '';
        
        header('Content-Type: text/html; charset=utf-8');
        
        switch($aAction) {
            case 'subscribe':
                $aEvent = Event::getById($aEventId);
                $aUser	= authGetAuthenticatedUserInfo();
        
                if ($aEvent != null) {
                    try {
                        Subscription::Add($aUser->id, $aEvent['id'], 0);
                        $aRet = '<span class="label label-success"><i class="fa fa-check-square"></i> Inscrito</span>';
                        $aRet .= ' <a href="javascript:void(0);" onclick="SAC.unsubscribe('.$aEventId.')" title="Clique para remover sua inscrição dessa atividade."><i class="fa fa-remove"></i></a>';
                        
                    } catch(Exception $aError) {
                        $aRet = 'Oops! ' . $aError->getMessage();
                    }
                    
                } else {
                    $aRet = 'Evento desconhecido!';
                }
                break;
                
            case 'unsubscribe':
                $aEvent = Event::getById($aEventId);
                $aUser	= authGetAuthenticatedUserInfo();
        
                if ($aEvent != null) {
                    try {
                        Subscription::remove($aUser->id, $aEvent->id, 0);
                        $aRet = '<a href="javascript:void(0);" onclick="SAC.subscribe('.$aEventId.', '.($aEvent['capacity'] != 0 ? 'true' : 'false').')" title="Clique para se inscrever nessa atividade."><i class="fa fa-square-o"></i></a>';
                        
                    } catch(Exception $aError) {
                        $aRet = 'Oops! ' . $aError->getMessage();
                    }
                    
                } else {
                    $aRet = 'Evento desconhecido!';
                }
                break;
                
            default:
                $aRet['msg'] = 'Opção inválida!';
        }
        
        echo $aRet;
        return $response;
    }
}