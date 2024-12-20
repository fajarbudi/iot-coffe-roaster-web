<?php

namespace App\Http\Controllers;

use App\Models\data;
use App\Models\project;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class page extends Controller
{
    public function home()
    {
        $terakhir = project::latest()->limit(1)->first();
        $data = DB::table('projects')
            ->join('data', 'projects.id', "=", "data.idProject")
            ->where('projects.id', ($terakhir ? $terakhir->id : ""))
            ->get();
        return view('home', ["data" => ($data ? $data : []), "project" => ($terakhir)]);
    }
    public function tugas($id)
    {
        $data = project::findOrFail($id);
        $data2 = setting::first();
        return view('tugas', ["projects" => $data, "setting" => $data2]);
    }
    public function listTugas()
    {
        $data = project::latest()->get();
        return view('daftarTugas', ["data" => $data,]);
    }

    public function hasilTugas($id)
    {
        $data = DB::table('projects')
            ->join('data', 'projects.id', '=', 'data.idProject')
            ->where('projects.id', $id)
            ->selectRaw('*,date_format(data.created_at,"%i:%s") as waktu')
            ->get()->toArray();
        $ndata = [];
        foreach ($data as $dd) {
            if (!isset($firsttime)) {
                $firsttime = $dd->created_at;
                $sfirsttime = strtotime($firsttime);
            }
            $stime = strtotime($dd->created_at);
            $ndata[$dd->id] = $dd;
            $selisih_awal = (int) abs($sfirsttime - $stime);
            $selisih_bagi = (5 * round($selisih_awal / 5, 0, PHP_ROUND_HALF_EVEN));

            if ($selisih_bagi >= 60) {
                $hitmenit = floor($selisih_bagi / 60);
                $hitdetik = $selisih_bagi - ($hitmenit * 60);
            } else {
                $hitmenit = 0;
                $hitdetik = $selisih_bagi;
            }
            if ($hitdetik < 10) {
                $tulisdetik = '0' . $hitdetik;
            } else {
                $tulisdetik = $hitdetik;
            }
            $ndata[$dd->id]->menit = (($hitmenit <= 10) ? '0' . $hitmenit : $hitmenit) . ':' . $tulisdetik;

            $class = '';
            if ($hitdetik == 0 or $hitdetik == 30) {
                $class = 'bg-warning';
            }
            $ndata[$dd->id]->bg = $class;
        }

        return view("hasilTugas", ["data" => $ndata]);
    }
    public function addTugas(Request $request)
    {
        $tugas = $request->validate([
            'namaProject' => ['required', 'min: 4'],
            'namaPembuat' => ['required', 'min: 3'],
            'waktuProses' => ['required', 'numeric', 'max_digits: 2']
        ]);
        project::create($tugas);

        return back();
    }
    public function dellTugas($id)
    {
        $projects = project::findOrFail($id);
        $projects->delete();
        data::where('idProject', $id)->delete();

        return back();
    }

    public function setting(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $setting = setting::first();
        $projects = project::findOrFail($id);
        $waktuEnd = ($setting->waktuEnd != 0) ? $setting->waktuEnd : date('H:i', time() + 60 * $projects->waktuProses);
        if ($request->sistem == "mati") {
            $data = [
                "sistem" => $request->sistem,
                "projectKe" => 0,
                "waktuEnd" => 0,
                "maxSuhu" => 0,
                "servo" => 0,
                "rpm" => 0
            ];
            $data2 = [
                "namaProject" => $projects->namaProject,
                "namaPembuat" => $projects->namaPembuat,
                "status" => "selesai",
                "waktuProses" => $projects->waktuProses
            ];
            $projects->update($data2);
            $setting->update($data);
        } else {
            $data = [
                "sistem" => $request->sistem,
                "projectKe" => $projects->id,
                "waktuEnd" => $waktuEnd,
                "maxSuhu" => $request->maxSuhu,
                "servo" => $request->servo,
                "rpm" => $request->rpm
            ];
            $setting->update($data);
        }
        // setting::create([
        //     "sistem" => "mati",
        //     "projectKe" => 0,
        //     "waktuEnd" => 0,
        //     "maxSuhu" => 0,
        //     "servo" => 0,
        //     "rpm" => 0
        // ]);
        return redirect()->route('hasilTugas', $id);
    }
}
