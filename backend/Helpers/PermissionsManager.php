<?php

namespace App\Helpers;

use App\Application;

class PermissionsManager
{

    public static function fieldPermissions(string $fieldName)
    {
        // Rudimentary permissions. Note, that this should be done in a considerably smarter way.
        $role = Application::$app->session->get('role');
        if ($role === 'R1') {
            return [
                'edit' => true,
                'view' => true,
            ];
        }

        return [
            'edit' => false,
            'view' => true,
        ];


    }
}