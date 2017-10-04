<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use Illuminate\Http\Request;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getFiles($id){
        $student = Student::find($id);
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path;
        $contents = File::allFiles($directory);

        foreach ($contents as $key => $file) {
            $path = pathinfo((string)$file."");
            $files[$key] = (object) array('name' => $path['basename'], 'type' => $path['extension'], 'path' => $path['dirname']);
        }
        return $files;

    }

}
