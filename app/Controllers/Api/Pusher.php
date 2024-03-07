<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

use Exception;
use ReflectionException;

class Pusher extends ResourceController
{
    protected $modelName = 'App\Models\ArusStokModel';
    protected $format = 'json';

    protected $pusher;
    public function __construct () {
        $this->pusher = new \Pusher\Pusher(
            'b67c982cfe9b4de71605',
            'c42d18f2f239d7f51162',
            '1440695',
            array(
                'cluster' => 'ap1',
                'useTLS' => true
            )
        );
    }
    

    public function index()
    {
        $request = $this->request->getGet('data');

        /**
         * "Scan" : Global Event Firing
         * "1"    : Mesin
         */
        $this->pusher->trigger('scan', '1', $request);

        return $this->respond("success",200);
    }

    public function show($id = null)
    {
        $request = $this->request->getGet('data');
        $explode_request = str_split($request, 16);
        
        /**
         * "Scan" : Global Event Firing
         * "1"    : Mesin
         */
        $send = array();
        foreach ($explode_request as $value) {
            $send[] = [
                'channel' => 'scan',
                'name' => '1',
                'data' => $value
            ];
        }

        if($send){
            $this->pusher->triggerBatch($send);
        }
        
        return $this->respond("success",200);
    }

} 

