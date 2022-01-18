<?php

namespace App\Http\Controllers;
use App\Models\DetailModel;
use App\Models\SangridModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SangridController extends Controller
{
    public function __construct()
    {
		// $responce = new SangridModel();
    }

    public function index()
    {
        return view('sangrid', [
            "title" => "Sangrid CRUD"
        ]);

    }

    // public function tampilMaster(){
	// 	echo 'hehehes</br>ini jumlah baris';

    //     $users_count = DB::table('sangrid_models')->count();

    //     return response()->json([$users_count]);
    //     return response([$users_count]);
    // }

    public function tampilMaster(Request $request){
		$page = $_GET['page'];
		$limit = $_GET['rows'];
		$sidx = $_GET['sidx'];
		$sord = $_GET['sord'];
        // dd($limit);
		$responce = new \stdClass();
		// @$page = $_POST['page'];
		// @$limit = $_POST['rows'];
		// @$sidx = $_POST['sidx'];
		// @$sord = $_POST['sord'];
		/*ini sidx sudah index name berdaskan sortname : sortName, di page view sangrid */
		// var_dump($sidx);
		// die;
		@$cariTanggal = $request->input('tanggal');
		@$cari = $request->input('nama');
		@$cariClient = $request->input('clientID');
		@$cariGlobal = $request->input('cariSangrid');

		if (!$sidx)
			$sidx = 1;
		$sql = DB::table('sangrid_models')->count();;
		$count = $sql;
        // dd($sql);

		if ($count >= 0) {
			@$total_pages = ceil($count / $limit);
		} else {
			$total_pages = 0;
		}
        // dd($total_pages);
		if ($page > $total_pages)
			@$page = $total_pages;
		if ($limit < 0)
			@$limit = 0;
		$start = $limit * $page - $limit;
        // dd($start);
		if ($start < 0)
			@$start = 0;

		if ($cari){
		$data = $this->db->query("SELECT * FROM `clients` WHERE `name` LIKE '%$cari%'");
		$dataCari = $this->db->query("SELECT * FROM `clients` WHERE `name` LIKE '%$cari%'")->getNumRows();
		// var_dump($data);
		// die;
		$count = $dataCari;
		if ($count >= 0) {
			@$total_pages = ceil($count / $limit);
		}
		}
		else if ($cariClient){
		$data = $this->db->query("SELECT * FROM `clients` WHERE `client_id` LIKE '%$cariClient%'");
		}
		else if ($cariTanggal){
		$data = $this->db->query("SELECT * FROM `clients` WHERE `tanggal` LIKE '%$cariTanggal%'");
		}
		else if ($cariGlobal){
		$data = $this->db->query("SELECT * FROM `clients` WHERE `client_id` LIKE '%$cariGlobal%' OR `name` LIKE '%$cariGlobal%' OR `tanggal` LIKE '%$cariGlobal%'");
		}
		else {
                // SELECT * FROM `sangrid_models` ORDER BY nama ASC LIMIT 0 , 10;
        // cara 1 bisa sorting
		$data = DB::table('sangrid_models')
                ->orderBy($sidx, $sord)
                ->offset($start)
                ->limit($limit)
                ->get();
        // cara 2 bisa sorting
		// $data = DB::table('sangrid_models')
        //         ->orderBy($sidx, $sord)
        //         ->limit($limit)
        //         ->get();
        // cara 3 tapi tidak bisa sorting
		// $data = DB::table('sangrid_models')->paginate($limit);
        // cara 4 tapi tidak bisa sorting
        // $data = SangridModel::paginate($limit);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
        // dd($responce->page);
		$i=0;
		foreach($data as $row){
			$responce->rows[$i]['clientID']   = $row->clientID;
			$responce->rows[$i]['cell'] = array(
				$row->clientID,
				date('d-m-Y', strtotime($row->tanggal)),
				$row->nama,
			);
			$i++;
		}
        // dd($responce);
		// echo json_encode($responce);
        return response()->json($responce);
	}
}
