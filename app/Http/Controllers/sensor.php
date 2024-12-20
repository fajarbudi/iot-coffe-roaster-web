<?php

namespace App\Http\Controllers;

use App\Models\data;
use App\Models\project;
use App\Models\setting;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sensor extends Controller
{
    public function data(Request $request)
    {
        // if (count(data::where('idProject', $request->projectKe)->latest()->limit(6)->get()) > 5) {
        //     $dataTerakhir = data::latest()->limit(6)->get()[5]->suhu;
        // } else {
        //     $dataTerakhir = 0;
        // }
        data::create([
            "suhu" => $request->suhu,
            "RoR" => $request->RoR,
            "power" => $request->power,
            "rpm" => $request->rpm,
            "idProject" => $request->projectKe
        ]);
    }

    public function sensor_json()
    {

        $data1 = setting::first();
        if (count(data::get()) > 0) {
            // $datas = data::join('projects', function (JoinClause $join) {
            //     $terakhir = project::latest()->get()[0]->id;
            //     $join->on('data.idProject', '=', 'projects.id')

            //         ->where('projects.id', $terakhir);
            // })->select('`')->get();
            $terakhir = project::latest()->get()[0]->id;
            $data2 = DB::table('data')
                ->join('projects', 'data.idProject', '=', 'projects.id')
                ->where('projects.id', $terakhir)
                ->selectRaw('*,date_format(data.created_at,"%i:%s") AS Menit')
                ->get();
        } else {
            $data2 = [];
        }
        return ["sensorFull" => $data2, "setting" => $data1];
    }

    public function getData()
    {
        $data = setting::get();
        return $data;
    }
}
