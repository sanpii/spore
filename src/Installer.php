<?php

use Composer\Script\Event;

class Installer
{
    public static function postUpdate(Event $event)
    {
        $rootDir = __DIR__ . '/../';
        $webDir = "$rootDir/web";
        $bootstrapDir = "$rootDir/vendor/twitter/bootstrap/twitter/bootstrap/";

        self::createDirectory("$webDir/css");
        self::createDirectory("$webDir/js");
        self::createDirectory("$webDir/img");

        require "$rootDir/vendor/leafo/lessphp/lessc.inc.php";
        $lessc = new \lessc();
        $css = $lessc->compileFile("$bootstrapDir/less/bootstrap.less");
        file_put_contents("$webDir/css/bootstrap.css", $css);

        foreach (glob("$bootstrapDir/js/*.js") as $src) {
            $dst = "$webDir/js/" . basename($src);
            copy($src, $dst);
        }

        foreach (glob("$bootstrapDir/img/*.png") as $src) {
            $dst = "$webDir/img/" . basename($src);
            copy($src, $dst);
        }
    }

    static private function createDirectory($name)
    {
        if (!is_dir($name)) {
            mkdir($name);
        }
    }
}
