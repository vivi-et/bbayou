<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Valiadator;

class AjaxUploadController extends Controller

{
    function action(Request $request)
    {
        if($_FILES["file"]["name"] != '')
        {
         $test = explode('.', $_FILES["file"]["name"]);
         $ext = end($test);
         $name = rand(100, 999) . '.' . $ext;
         $location = '/storage/cover_images/' . $name;  
         move_uploaded_file($_FILES["file"]["tmp_name"], $location);
         echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
        }
    }
}
