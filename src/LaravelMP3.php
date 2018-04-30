<?php

namespace Acekyd\LaravelMP3;

class LaravelMP3
{

    private $info;
    
    private $path;
    
    public function load($path = null)
    {
        if ($path !== $this->path || $this->info === null) {
            //using include causes redeclaration exception, while using this class to process more than one file (eg. in a loop on all mp3s)
            include_once('getid3/getid3.php');
            $getID3 = new \getID3;
            $this->info = $getID3->analyze( $path );
            $this->path = $path;
        }
        return $this->info;
    }
 /*   public function test($path)
    {
        $lib = $this->load($path);
        return $lib['mime_type'];
    }
*/

    public function getAlbum($path)
    {
        $lib = $this->load($path);
        return isset($lib['tags']['id3v2']['album'][0]) ? $lib['tags']['id3v2']['album'][0] : '';
    }

    public function getArtist($path)
    {
        $lib = $this->load($path);
        return isset($lib['tags']['id3v2']['artist'][0]) ? $lib['tags']['id3v2']['artist'][0] : '';
    }

    public function getBitrate($path)
    {
        $lib = $this->load($path);
        return isset($lib['audio']['bitrate'][0]) ? $lib['audio']['bitrate'][0] : '';
    }

    public function getDuration($path)
    {
        $lib = $this->load($path);
        $play_time = $lib['playtime_string'];
        $hours = 0;
        list($mins , $secs) = explode(':' , $play_time);

        if($mins > 60)
        {
            $hours = intval($mins / 60);
            $mins = $mins - $hours*60;
        }
        if($hours)
        {
            $play_time = sprintf("%02d:%02d:%02d" , $hours , $mins , $secs);
        }
        else $play_time = sprintf("%02d:%02d" , $mins , $secs);

        return $play_time;
    }

    public function getFormat($path)
    {
        $lib = $this->load($path);
        return isset($lib['audio']['dataformat']) ? $lib['audio']['dataformat'] : '';
    }

    public function getGenre($path)
    {
        $lib = $this->load($path);
        return isset($lib['tags']['id3v2']['genre'][0]) ? $lib['tags']['id3v2']['genre'][0] : '';
    }

    public function getMime($path)
    {
        $lib = $this->load($path);
        return isset($lib['mime_type']) ? $lib['mime_type'] : '';
    }

    public function getTitle($path)
    {
        $lib = $this->load($path);
        return isset($lib['tags']['id3v2']['title'][0]) ? $lib['tags']['id3v2']['title'][0] : '';
    }

    public function getTrackNo($path)
    {
        $lib = $this->load($path);
        return isset($lib['tags']['id3v2']['track_number'][0]) ? $lib['tags']['id3v2']['track_number'][0] : '';
    }

    public function getYear($path)
    {
        $lib = $this->load($path);
        return isset($lib['tags']['id3v2']['year'][0]) ? $lib['tags']['id3v2']['year'][0] : '';
    }

    public function isLossless($path)
    {
        $lib = $this->load($path);
        return isset($lib['audio']['lossless']) ? $lib['audio']['lossless'] : '';
    }

    public function getComment($path){
        $lib = $this->load($path);
        return isset($lib['tags']['id3v2']['comment'][0]) ? $lib['tags']['id3v2']['comment'][0] : '';
    }
    
    public function getAlbumCover($path){
        $lib = $this->load($path);
        return isset($lib['comments']['picture']['0']['data']) ? $lib['comments']['picture']['0']['data'] : false;
     }
}


?>
