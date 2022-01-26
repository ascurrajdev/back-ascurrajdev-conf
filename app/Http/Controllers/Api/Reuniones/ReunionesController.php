<?php
namespace App\Http\Controllers\Api\Reuniones;
use App\Http\Controllers\Controller;
use App\Models\Reunion;
use App\Http\Resources\Reuniones\ReunionesResource;
class ReunionesController extends Controller{

    public function index(){
        return ReunionesResource::collection(Reunion::where('user_id',auth()->id())->get());
    }

    public function store(){
        $reunion = Reunion::create([
            "user_id" => auth()->id()
        ]);
        return ReunionesResource::make($reunion);
    }

}