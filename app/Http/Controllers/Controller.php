<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
  
    protected $ranks = array("Admin" => "#ff0000", 
                             "Dev'" => "#1DA720", 
                             "Resp. Modo" => "#0800ff", 
                             "Resp. Build"=> "#ff5100", 
                             "Modo"=> "#2C98B3", 
                             "Builder"=> "#ff9600", 
                             "Partner"=> "#E730FF"
                            );
}
