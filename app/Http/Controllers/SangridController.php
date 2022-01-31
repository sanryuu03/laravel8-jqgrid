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
		$data = $this->db->query("SELECT * FROM `clients` WHERE `clientID` LIKE '%$cariClient%'");
		}
		else if ($cariTanggal){
		$data = $this->db->query("SELECT * FROM `clients` WHERE `tanggal` LIKE '%$cariTanggal%'");
		}
		else if ($cariGlobal){
		$data = $this->db->query("SELECT * FROM `clients` WHERE `clientID` LIKE '%$cariGlobal%' OR `name` LIKE '%$cariGlobal%' OR `tanggal` LIKE '%$cariGlobal%'");
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

    public function formCreate()
    {
		return view('formAdd');
	}

    public function insertJqgrid(Request $request, $limit)
    {
		$tanggalVar = $request->input('tanggal');
		$nameVar = $request->input('nama');
		$jobdeskVar = $request->input('jobdesk');
		$hobiVar = $request->input('hobi');
		$hargaHobiVar = $request->input('hargaHobi');
        $sort_index = 'nama';
		$sort_order = 'asc';
        $countJobdesk = count($jobdeskVar);
		// var_dump(count($jobdeskVar));
		// die;
        $data = [
			// 'tanggal' => $tanggalVar,
			'tanggal' => date('Y-m-d', strtotime($tanggalVar)),
			'nama' => $nameVar,
		];
        $insert_id = DB::table('sangrid_models')->insertGetId($data);
        // dd($insert_id);
		for ($x = 0; $x < $countJobdesk; $x++) {
			if ($jobdeskVar[$x] !== '' && $hobiVar[$x] !== '' && $hargaHobiVar[$x] !== '') {
				$data = [
					'clientID' => $insert_id,
					'jobdesk' => $jobdeskVar[$x],
					'hobi' => $hobiVar[$x],
					'hargaHobi' => str_replace(".", "", $hargaHobiVar[$x])
				];
				// $this->db->insert('jobdesk',$data);
                 DB::table('detail_models')->insert($data);
			}
		}
		$clientID = $insert_id;
		$dataSql = DB::select("
			SELECT temp.position, temp.*
			FROM (
				SELECT @rownum := @rownum + 1 AS position,
							 sangrid_models.*
				FROM sangrid_models
				JOIN (
					SELECT @rownum := 0
				) rownum
				ORDER BY $sort_index $sort_order
			) temp
			WHERE temp.clientID = ". $clientID ."
		");
		$row = $dataSql[0]->position;
		$page = ceil($row / $limit);
		echo json_encode([
			'status' => 'submitted',
			'operid' => $insert_id,
			'page' => $page,
			'row' => $row,
		]);
	}

    public function selectJqgrid($clientID){
		$responce = new \stdClass();

		// $data = DB::select("SELECT sangrid_models.clientID,detail_models.jobdesk, detail_models.hobi, detail_models.hargaHobi FROM detail_models INNER JOIN sangrid_models ON detail_models.clientID = sangrid_models.clientID WHERE sangrid_models.clientID = '$clientID'");

		// $data = DetailModel::join('sangrid_models', 'sangrid_models.clientID', '=', 'detail_models.clientID')
        //         ->select('*')
        //         ->get();

        // $data = DetailModel::where('clientID', $clientID)->findOrFail();
        // ini sukses
        $data = DetailModel::where('clientID', $clientID)->get();
        // $data = DetailModel::select('*')->where('clientID', $clientID)->get();
		// $data = DetailModel::findOrFail($clientID);
		// $data = DetailModel::findOrFail($clientID)->where('clientID', $clientID)->get();;
		// $data = DetailModel::with('sangrid')->find($clientID);
		// $data = DetailModel::findOrFail($id, $clientID = ['clientID']);
		// $data = DetailModel::where('clientID','=',$clientID)->firstOrFail();
		// $data = DetailModel::where('clientID','=',$clientID)->first();
        // dd($data);
        // return response()->json($data);
		// var_dump($data);
		// die;
		$i=0;
		$hargaHobiVar=0;
        // dd({{ $data->hargaHobi }});
        // $hargaHobiVar += {{ $data->hargaHobi }};
		foreach($data as $row){
            // dd($row);
			$hargaHobiVar += $row->hargaHobi;
			// var_dump($hargaHobiVar);
			// die;
			$responce->rows[$i]['clientID'] = $row->clientID;
			$responce->rows[$i]['cell'] = array(
				$row->jobdesk,
				$row->hobi,
				number_format($row->hargaHobi, 0, ',', '.')
			);
			$i++;
		}
		$responce->userdata['hobi'] = 'Totals:';
		$responce->userdata['hargaHobi']= number_format($hargaHobiVar, 0, ',', '.');
		$responce->userdata['result'] = 'Data Berhasil di panggil';
		// var_dump($hargaHobiVar);
		// 	die;
        return response()->json($responce);

		// echo json_encode($responce);
	}

    public function formDetail($clientID){
		$data['clients'] = SangridModel::where('clientID', $clientID)->get();
		$data['jobdesk'] = DetailModel::where('clientID', $clientID)->get();
		$data['totalHarga'] = DB::select("SELECT SUM(hargaHobi) as total FROM detail_models WHERE clientID='$clientID'");
        // return response()->json($data['total']);
        // return response()->json($data['clients']->tanggal);
		// var_dump($data['total']);
		// die;
		return view('formDetail', $data);
	}

    public function formEdit($clientID){
		$data['clients'] = SangridModel::where('clientID', $clientID)->get();
		$data['jobdesk'] = DetailModel::where('clientID', $clientID)->get();
		$data['totalHarga'] = DB::select("SELECT SUM(hargaHobi) as total FROM detail_models WHERE clientID='$clientID'");
		// var_dump($data['total']);
		// die;
		return view('formEdit', $data);
	}

    public function updateJqgrid(Request $request, $clientID){
        // konsep update yaitu delete insert
		$tanggalVar = $request->input('tanggal');
		$nameVar = $request->input('nama');
		$jobdeskVar = $request->input('jobdesk');
		$hobiVar = $request->input('hobi');
		$hargaHobiVar = $request->input('hargaHobi');
		$countJobdesk = count($jobdeskVar);
		// var_dump($hargaHobiVar);
		// var_dump(str_replace(".", "", $hargaHobiVar));
		// die;
        // ini menggunakan Eloquent
        DetailModel::where('clientID', $clientID)->delete();
		for ($x = 0; $x < $countJobdesk; $x++) {
			if ($jobdeskVar[$x] !== '' && $hobiVar[$x] !== '' && $hargaHobiVar[$x] !== '') {
				$data = [
					'clientID' => $clientID,
					'jobdesk' => $jobdeskVar[$x],
					'hobi' => $hobiVar[$x],
					'hargaHobi' => str_replace(".", "", $hargaHobiVar[$x])
				];
                // Eloquent
				DetailModel::create($data);
			}
		}
		// //ini untuk master
		$data = [
			'tanggal' => date('Y-m-d', strtotime($tanggalVar)),
			'nama' => $nameVar,
		];
		// ini menggunakan Query Builder
        DB::table('sangrid_models')
              ->where('clientID', $clientID)
              ->update($data);
		echo json_encode($data);
	}

    public function formDelete($clientID){
		$data['clients'] = SangridModel::where('clientID', $clientID)->get();
		$data['jobdesk'] = DetailModel::where('clientID', $clientID)->get();
		$data['totalHarga'] = DB::select("SELECT SUM(hargaHobi) as total FROM detail_models WHERE clientID='$clientID'");
		return view('formDelete', $data);
	}

    public function deleteJqgrid($clientID){
        SangridModel::where('clientID', $clientID)->delete();
        DetailModel::where('clientID', $clientID)->delete();
	}
}
