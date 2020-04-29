<?php


namespace App\Tools;


class LibsLoader
{

    public function loadLibraries(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }


}
