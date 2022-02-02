<?php
namespace App\Http\Controllers\Api\Reuniones;
use App\Http\Controllers\Controller;
use App\Models\ReunionJoin;
use App\Http\Resources\Reuniones\ReunionesJoinResource;
class ReunionesJoinController extends Controller{
    public function index(){
        return ReunionesJoinResource::collection(ReunionJoin::where("user_id",request()->user()->id)->get());
    }

    public function joining(){
        request()->validate([
            "reunion_id" => ["required","exists:reuniones,id"]
        ]);
        $reunionJoin = ReunionJoin::updateOrCreate(
            [
                "user_id" => request()->user()->id,
                "reunion_id" => request("reunion_id"),
            ],
            [
                "joining_at" => now()
            ]
        );
        return $reunionJoin;
    }

    public function disconnect(){
        request()->validate([
            "reunion_id" => ["required","exists:reuniones,id"]
        ]);
        $reunionJoin = ReunionJoin::where("user_id",request()->user()->id)
        ->where("reunion_id",request("reunion_id"))->first();
        $reunionJoin->update([
            "disconnected_at" => now()
        ]);
        return $reunionJoin;
    }
}