<?php

namespace App\Controllers;

use Slim\Http\UploadedFile;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;    
use App\Models\User;
use App\Models\Event;
use App\Helpers\View;
use App\Models\Speaker;

class SpeakerController {
    public function index($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();

        $speakers = Speaker::findAll();
        $events = Event::findAll();

        $data = compact('user', 'events', 'speakers');

        View::render('layout/admin/header', $data);
        View::render('speaker/index', $data);
        View::render('layout/admin/footer');

        return $response;
    }
    
    public function create($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();

        $events = Event::findAll();

        $data = compact('user', 'events');

        View::render('layout/admin/header', $data);
        View::render('speaker/create', $data);
        View::render('layout/admin/footer');

        return $response;
    }

    public function store($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_CO_ORGANIZER);

        $speaker = new Speaker();
        $body = $request->getParsedBody();
        $speaker->setAttr('name', $body['name']);
        $speaker->setAttr('description', $body['description']);
        
        $img = $request->getUploadedFiles()['img'];
        $img_file_name = $img->getClientFilename();

        $speaker->setAttr('img_path', $img_file_name);

        if ($img->getError() === UPLOAD_ERR_OK) {
            print_r(UPLOAD_FOLDER.'/'.$img_file_name);
            $img->moveTo(UPLOAD_FOLDER.'/'.$img_file_name);  
        }

        $id = $speaker->save();

        if (!$id) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/admin/palestrantes/create"))
                ->withStatus(302);   
        }

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/palestrantes/$id"))
            ->withStatus(302);

        return $response;   
    }

    public function show ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $speaker = Speaker::findById($args['id']);

        $data = compact(['user', 'speaker', 'speaker']);

        View::render('layout/admin/header', $data);
        View::render('speaker/show', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function edit ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $speaker = Speaker::findById($args['id']);
        $data = compact(['user', 'speaker']);

        View::render('layout/admin/header', $data);
        View::render('speaker/edit', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function update ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $speaker = Speaker::findById($args['id']);
        $body = $request->getParsedBody();
        $speaker->setAttr('name', $body['name']);
        $speaker->setAttr('description', $body['description']);
        $speaker->save();

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/palestrantes/".$args['id']))
            ->withStatus(302);      
    }

    public function delete ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $speaker = Speaker::findById($args['id']);
        $speaker->delete();
        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/palestrantes"))
            ->withStatus(302);  
    }
}

