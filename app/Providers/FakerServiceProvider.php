<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //https: //source.unsplash.com/random/256x256
        $this->app->singleton('Faker', function ($app) {
            $faker = \Faker\Factory::create();
            $newClass = new class($faker) extends \Faker\Provider\Base
            {
                public static function unsplashImageUrl($width = 640, $height = 480)
                {
                    $baseUrl = "https://source.unsplash.com/random";
                    $url = "/{$width}x{$height}/";

                    $url .= "?query=face&fit=facearea";

                    return $baseUrl . $url;
                }

                public function unsplash($dir = null, $width = 640, $height = 480, $fullPath = true)
                {
                    $dir = is_null($dir) ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
                    // Validate directory path
                    if (!is_dir($dir) || !is_writable($dir)) {
                        throw new \InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
                    }

                    // Generate a random filename. Use the server address so that a file
                    // generated at the same time on a different server won't have a collision.
                    $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
                    $filename = $name . '.jpg';
                    $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

                    $url = static::unsplashImageUrl($width, $height);

                    // save file
                    if (function_exists('curl_exec')) {
                        // use cURL
                        $fp = fopen($filepath, 'w');
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        $success = curl_exec($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
                        fclose($fp);
                        curl_close($ch);

                        if (!$success) {
                            unlink($filepath);

                            // could not contact the distant URL or HTTP error - fail silently.
                            return false;
                        }
                    } elseif (ini_get('allow_url_fopen')) {
                        // use remote fopen() via copy()
                        $success = copy($url, $filepath);
                    } else {
                        return new \RuntimeException('The image formatter downloads an image from a remote HTTP server. Therefore, it requires that PHP can request remote hosts, either via cURL or fopen()');
                    }

                    return $fullPath ? $filepath : $filename;
                }
            };

            $faker->addProvider($newClass);
            return $faker;
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
