<?php

use App\Models\SettingsModel;
use App\Models\UserModel;


function settings($params)
{
    $settingsModel = new SettingsModel();
    return $settingsModel->getSettings()[$params];  // getSettings ile tek bir ayarı al
}
function user($params)
{
    $userModel = new UserModel();
    return $userModel->getUser()[$params];  // Oturumdaki kullanıcıyı al
}