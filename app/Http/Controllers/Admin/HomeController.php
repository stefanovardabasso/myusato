<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Event;
use App\Models\Admin\Option;
use App\Models\Admin\Place;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $labels = Event::getAttrsTrans();

        $widgetsOrder = Auth::user()->getWidgets();

        return view('admin.home', compact('labels', 'widgetsOrder'));
    }

    public function setupsmtp(Request $request)
    {
        $mymail = DB::table('mailes')->get();
        return view('admin.mail.setupsmtp', compact('mymail'));
    }

    public function storesmtp(Request $request)
    {
        $mymail = DB::table('mailes')->get();

        $envFile = app()->environmentFilePath();
        $str = "\n";
        $str .= file_get_contents($envFile);
        $str .= "\n"; // In case the searched variable is in the last line without \n


        $str = str_replace($mymail[0]->host, $request->get('host'), $str);
        $str = str_replace($mymail[0]->port, $request->get('port'), $str);
        $str = str_replace($mymail[0]->user, $request->get('user'), $str);
        $str = str_replace($mymail[0]->password, $request->get('password'), $str);
        $str = str_replace($mymail[0]->encryption, $request->get('encryption'), $str);
        $str = substr($str, 1, -1);
        file_put_contents($envFile, $str);
//        Artisan::call("config:cache");

        DB::table('mailes')->truncate();

        $data = [
            'host'=>$request->get('host'),
            'port'=>$request->get('port'),
            'user'=>$request->get('user'),
            'password'=>$request->get('password'),
            'encryption'=>$request->get('encryption'),
            'created_at'=>date('Y-m-d h:m:s'),
            'updated_at' =>date('Y-m-d h:m:s')
        ];


        DB::table('mailes')->insert($data);

        $mymail = DB::table('mailes')->get();

        $values = [
            'host'=>$request->get('host'),
            'port'=>$request->get('port'),
            'user'=>$request->get('user'),
            'password'=>$request->get('password'),
            'encryption'=>$request->get('encryption'),
        ];

        return redirect()->back()->with(['success'=>'La configurazione SMTP è stata modificata correttamente']);

    }

    public function statistics(Request $request){

        $places = Place::query()->where('deleted_at','=', null)->get();

        return view('admin.statistics.index', compact('places'));
    }

    public function checkbydate(Request $request){
        // input parametres: date_start, date_end, placeid

        $period_days = (new DateTime($request->date_start))->diff(new DateTime($request->date_end))->days;
        // set groupBy for chart X axis
        // $groupByFormat = 'M-Y';
        // if ($period_days < 31) {$groupByFormat = 'd-M';}

        // OPTIONS number
        $options =  DB::table('options')
        ->join('place_user', 'place_user.user_id', '=', 'options.user_id')
        ->where('place_user.place_id', '=', $request->placeid)
        ->whereBetween('options.created_at',[$request->date_start, $request->date_end])
        ->get()->count();

        // OPTIONS chart data
        if($period_days < 32) {
            // groupBy DAY
            $options_chart_records =  DB::table('options')
            ->join('place_user', 'place_user.user_id', '=', 'options.user_id')
            ->where('place_user.place_id', '=', $request->placeid)
            ->whereDate('options.created_at', '>=', $request->date_start)
            ->whereDate('options.created_at', '<=', $request->date_end)
            ->orderBy('options.created_at', 'asc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d-M');
            });
        } else {
            // groupBy MONTH
            $options_chart_records =  DB::table('options')
            ->join('place_user', 'place_user.user_id', '=', 'options.user_id')
            ->where('place_user.place_id', '=', $request->placeid)
            ->whereDate('options.created_at', '>=', $request->date_start)
            ->whereDate('options.created_at', '<=', $request->date_end)
            ->orderBy('options.created_at', 'asc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('M-Y');
            });
        }

        $opt_chart_data_arr_x = [];
        $opt_chart_data_arr_y = [];
        foreach ($options_chart_records as $key => $value) {
            $arr_elements = $value->count();
            array_push($opt_chart_data_arr_x, $key);
            array_push($opt_chart_data_arr_y, $arr_elements);
        }

        // vers 2 TEST
        // $options_chart_data =  DB::table('options')
        // ->join('place_user', 'place_user.user_id', '=', 'options.user_id')
        // ->where('place_user.place_id', '=', $request->placeid)
        // ->whereBetween('options.created_at',[$request->date_start, $request->date_end])
        // ->groupBy(DB::raw('MONTH(created_at)'))
        // ->get()->count();

        // SALES number
        $sales =  DB::table('options')
        ->join('place_user', 'place_user.user_id', '=', 'options.user_id')
        ->where('place_user.place_id', '=', $request->placeid)
        ->whereDate('options.created_at', '>=', $request->date_start)
        ->whereDate('options.created_at', '<=', $request->date_end)
        ->where('status', '=', 3)
        ->get()->count();

        // SALES: chart data
        if($period_days < 32) {
            // groupBy DAY
            $sales_chart_records =  DB::table('options')
            ->join('place_user', 'place_user.user_id', '=', 'options.user_id')
            ->where('place_user.place_id', '=', $request->placeid)
            ->whereDate('options.created_at', '>=', $request->date_start)
            ->whereDate('options.created_at', '<=', $request->date_end)
            ->where('options.status', '=', 3)
            ->orderBy('options.created_at', 'asc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d-M');
            });
        } else {
            // groupBy MONTH
            $sales_chart_records =  DB::table('options')
            ->join('place_user', 'place_user.user_id', '=', 'options.user_id')
            ->where('place_user.place_id', '=', $request->placeid)
            ->whereDate('options.created_at', '>=', $request->date_start)
            ->whereDate('options.created_at', '<=', $request->date_end)
            ->where('options.status', '=', 3)
            ->orderBy('options.created_at', 'asc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('M-Y');
            });
        }

        $sales_chart_data_arr_x = [];
        $sales_chart_data_arr_y = [];
        foreach ($sales_chart_records as $key => $value) {
            $sales_arr_elements = $value->count();
            array_push($sales_chart_data_arr_x, $key);
            array_push($sales_chart_data_arr_y, $sales_arr_elements);
        }

        // vendors number
        $place_vendors = Place::find($request->placeid)->users()
        ->whereDate('created_at', '>=', $request->date_start)
        ->whereDate('created_at', '<=', $request->date_end)
        ->get()->count();

        // VENDORS: chart data
        if($period_days < 32) {
            // groupBy DAY
            $vendors_chart_data =  DB::table('users')
            ->join('place_user', 'place_user.user_id', '=', 'users.id')
            ->where('place_user.place_id', '=', $request->placeid)
            ->whereDate('users.created_at', '>=', $request->date_start)
            ->whereDate('users.created_at', '<=', $request->date_end)
            ->orderBy('users.created_at', 'asc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d-M');
            });
        } else {
            // groupBy MONTH
            $vendors_chart_data =  DB::table('users')
            ->join('place_user', 'place_user.user_id', '=', 'users.id')
            ->where('place_user.place_id', '=', $request->placeid)
            ->whereDate('users.created_at', '>=', $request->date_start)
            ->whereDate('users.created_at', '<=', $request->date_end)
            ->orderBy('users.created_at', 'asc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('M-Y');
            });
        }

        $vendors_chart_data_arr_x = [];
        $vendors_chart_data_arr_y = [];
        foreach ($vendors_chart_data as $key => $value) {
            $vendors_arr_elements = $value->count();
            array_push($vendors_chart_data_arr_x, $key);
            array_push($vendors_chart_data_arr_y, $vendors_arr_elements);
        }

        // define Y axis max value
        // if(empty($vendors_chart_data_arr_y)){
        //     $vendor_y_axis_max = 6;
        // } else {
        //     $vendor_y_axis_max = max($vendors_chart_data_arr_y);
        //     if ($vendor_y_axis_max < 6) {
        //         $vendor_y_axis_max = 6;
        //     } else {
        //         $vendor_y_axis_max = null;
        //     }
        // }

        $resp['resp'] = [
            // 'options_chart_data' => $options_chart_data,
            'options_numb' => $options,
            'sales_numb' => $sales,
            'vendors_numb' => $place_vendors,
            'options_char_values' => $options_chart_records,
            'options_chart_values_x' => $opt_chart_data_arr_x,
            'options_chart_values_y' => $opt_chart_data_arr_y,
            'sales_char_values' => $sales_chart_records,
            'sales_chart_values_x' => $sales_chart_data_arr_x,
            'sales_chart_values_y' => $sales_chart_data_arr_y,
            'vendors_char_values' => $vendors_chart_data,
            'vendors_chart_values_x' => $vendors_chart_data_arr_x,
            'vendors_chart_values_y' => $vendors_chart_data_arr_y,
        ];

        return json_encode($resp);

    }
    public function newsl()
    {
        return view('admin.news.generator');
    }
}
