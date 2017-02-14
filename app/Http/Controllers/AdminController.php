<?php

namespace App\Http\Controllers;

use App\JsonVersion;
use App\SpaiClass;
use App\SpaiLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function downloadZip()
    {
        file_put_contents(storage_path('temp/json.zip'), fopen("http://m.spailocarno.ch/spaihub/json.zip", 'r'));
    }

    public function extractZip()
    {
        if (is_file(storage_path('temp/json.zip')))
        {
            $zip = new \ZipArchive();
            $zip_status = $zip->open(storage_path('temp/json.zip'));

            if ($zip_status === true)
            {
                if ($zip->setPassword(base64_decode('MTJzcGFpMTI=')))
                {
                    if (!$zip->extractTo(storage_path('temp/json')))
                        echo "Extraction failed (wrong password?)";
                }

                $zip->close();
            }
            else
            {
                die("Failed opening archive: ". @$zip->getStatusString() . " (code: ". $zip_status .")");
            }
        }
    }

    public function importClasses()
    {
        // clear database
        DB::table('spai_classes')->truncate();

        // load json classes
        $string = file_get_contents(storage_path('temp/json/json/classi.json'));
        $json_a = json_decode($string, true);

        foreach ($json_a as $classes => $class_a) {

            $spaiclass = new SpaiClass;

            $spaiclass->class=$class_a['classe'];
            $spaiclass->category=$class_a['categoria'];
            $spaiclass->save();
        }
    }

    public function importLessons()
    {
        // clear database
        DB::table('spai_lessons')->truncate();

        // load json lessons
        $string = file_get_contents(storage_path('temp/json/json/lezioni.json'));
        $json_a = json_decode($string, true);

        $hours = [["08:20:00","09:05:00"],
            ["09:05:00","09:50:00"],
            ["10:05:00","10:50:00"],
            ["10:50:00","11:35:00"],
            ["11:35:00","12:20:00"],
            ["12:20:00","13:05:00"],
            ["13:05:00","13:50:00"],
            ["13:50:00","14:35:00"],
            ["14:45:00","15:30:00"],
            ["15:30:00","16:15:00"],
            ["16:15:00","17:00:00"]];

        foreach ($json_a as $lessons => $lesson_a) {
            $dt = \Carbon\Carbon::now();
            $spailesson = new SpaiLesson;

            $date = explode(" ",$dt->timestamp($lesson_a['data'])->timezone('Europe/Zurich'))[0];
            $start = $hours[intval($lesson_a['ora'])-1][0];
            $end = $hours[intval(($lesson_a['ora'])-1)+(intval($lesson_a['ore'])-1)][1];
            $docente = $lesson_a['docente'];
            $classe = $lesson_a['classe'];
            $aula = $lesson_a['aula'];
            $materia = $lesson_a['materia'];
            $categoria = $lesson_a['categoria'];

            $spailesson->start=$date.' '.$start;
            $spailesson->end=$date.' '.$end;
            $spailesson->docente=$docente;
            $spailesson->classe=$classe;
            $spailesson->aula=$aula;
            $spailesson->materia=$materia;
            $spailesson->categoria=$categoria;
            $spailesson->save();
        }
    }

    public function checkVersion()
    {
       $checkversion = new JsonVersion;

        DB::table('json_versions')->truncate();

        $offlineversion = $checkversion->limit(1)->get();

        $actualversion = preg_replace('/[^0-9]/', '', file_get_contents('http://m.spailocarno.ch/spaihub/index.php?op=version'));
        $checkversion->version=$actualversion;
        $checkversion->save();


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->input('update')=="Update")
        {
            $this->downloadZip();
            $this->extractZip();
            $this->importClasses();
            $this->importLessons();
            $this->checkVersion();
        }

        $checkversion = new JsonVersion;
        $offlineversion = $checkversion->limit(1)->get();
        $actualversion = preg_replace('/[^0-9]/', '', file_get_contents('http://m.spailocarno.ch/spaihub/index.php?op=version'));
        /*
        try{

        }catch (\Exception $e){
            dd($e->getTrace());
        }*/
        return view('admin_home',compact('offlineversion','actualversion'));

    }
}
