<?php

namespace App\Http\Controllers;

use App\Http\SettingsHelper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public function callAction($method, $parameters)
    {
       $setting =  SettingsHelper::getSetting('is_maintainance');
       if($setting->value == 1){
           return view('pages/maintainance');
       }
        return parent::callAction($method, $parameters);
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
