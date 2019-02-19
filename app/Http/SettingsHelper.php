<?php
/**
 * Created by PhpStorm.
 * User: anowe
 * Date: 2/19/2019
 * Time: 4:19 PM
 */

namespace App\Http;


use App\Settings;

class SettingsHelper
{
    public static function getSetting($name){
        $setting = Settings::where("name",$name)->first();
        if(empty($setting->name)){
            dd("No Setting found for {$name}");
        }
        return $setting;
    }

}