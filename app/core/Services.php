<?php

class Services 
{
    public function routes() {
        return [
            'Controller' => App\Controllers::class,
            'Core' => App\Core::class,
            'Models' => App\Models::class,
            'Repositories' => App\Models\Repositories::class,
        ];
    }
}