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

    private $responseMessage = array();

    private static $IMG_PATH = __DIR__ . '/../../public/img';
    
    //private static $IMG_PATH = '/home/arufonsekun/Imagens';
    
    public function index($request, $response, $args) {
        
        $user = AuthHelper::getAuthenticatedUser();

        $speakers = Speaker::findAll();
        $events = Event::findAll();

        $data = compact('user', 'events', 'speakers');

        View::render('layout/header', $data);
        View::render('speakers/index', $data);
        View::render('layout/footer');

        return $response;
    }
    
    public function create($request, $response, $args) {
        
        $user = AuthHelper::getAuthenticatedUser();

        $events = Event::findAll();

        $data = compact('user', 'events');

        View::render('layout/header', $data);
        View::render('speakers/create', $data);
        View::render('layout/footer');

        return $response;
    }

    public function store($request, $response, $args) {

        //AuthHelper::restrictToPermission(User::USER_CO_ORGANIZER);

        $speaker = new Speaker();
        $body = $request->getParsedBody();
        $speaker->setAttr('name', $body['name']);
        $speaker->setAttr('description', $body['description']);
        $img = $request->getUploadedFiles()['img'];
        $speaker->setAttr('img_path', $img->getClientFilename());


        $img_client_file_name = $img->getClientFilename();

        // echo SpeakerController::$IMG_PATH.'/'.$img_client_file_name;
        // exit();

        // echo $img->getClientFilename();
        // exit();

        /*if ($img->getError() === UPLOAD_ERR_OK) {
            $img->moveTo('/opt/lampp/htdocs/sac/public/img/'.$img_client_file_name);  
        }*/

        $id = $speaker->save();

        if (!$id) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato/create"))
                ->withStatus(302);   
        }

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato/$id"))
            ->withStatus(302);

        return $response;
        
    }

    private function moveUploadedFile($directory, $uploadedFile) {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }


}

