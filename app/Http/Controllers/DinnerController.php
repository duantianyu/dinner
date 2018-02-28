<?php

namespace App\Http\Controllers;

use App\Dinner as Dinner;
//use Request;
use Illuminate\Http\Request;
use DB;
use Excel;

class DinnerController extends Controller
{
    protected $week;
    protected $last_week;

    public function get_date($array)
    {
        $data = [];
        foreach ($array as $v) {
            for ($i = 1; $i < 8; $i++) {
                $data[$v][$i] = date('Y-m-d', strtotime(date('Y') . '01' . '01') + (($v - 1) * 7 + $i - 1) * 86400);
            }
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->get('name', '');
        $name == '' ? $name = $request->cookie('name') : '';
        $time = date('Y-m-d', time() - 86400 * 10);

        $lists = DB::table('dinner')
            ->where('name', '=', $name)
            ->where('created_at', '>', $time)
            ->orderBy('week', 'desc')
            ->orderBy('name', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()
            ->view('index', compact('lists', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $name = $request->cookie('name');
        $week = date('w');
        $weeks = date('W');
        $last_week = $weeks - 1;
        if ($last_week == 0) {
            $last_week = 53;
        }
        $data = json_encode($this->get_date([$weeks, $last_week]));

        return response()
            ->view('dinner', compact('name', 'week', 'weeks', 'last_week', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $data['week'] = $request->get('week');
        $data['time_kind'] = $request->get('time_kind');
        $data['name'] = $request->get('name');
        $data['amount'] = $request->get('amount');
        $data['dinner_date'] = $request->get('dinner_date');
        $data['diner'] = $request->get('diner');

        if (array_filter($data) != $data) {
            return response([
                                'status' => 0,
                                'info' => '所有选项都是必填的',
                            ]);
        }


        $dinner = new Dinner();
        $res = $dinner->create($data);

        if ($res == true) {
            $res = [
                'status' => 1,
                'info' => '提交成功',
            ];
        } elseif ($res === 1) {
            $res = [
                'status' => 1,
                'info' => '请勿重复提交',
            ];
        } else {
            $res = [
                'status' => 0,
                'info' => '发生错误，请重试',
            ];
        }

        return response($res)->cookie(
            'name', $data['name'], 86400 * 30
        );
    }

    public function export()
    {
        $time = date('Y-m-d', time() - 86400 * 30);
        $lists = DB::table('dinner')
            ->select('week', 'time_kind', 'name', 'diner', 'amount', 'created_at')
            ->where('created_at', '>', $time)
            ->orderBy('week', 'desc')
            ->orderBy('name', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $title = [['第几周', '时间餐种', '付款人', '用餐人', '金额', '提交时间']];//'ID',  , '修改时间'
        $lists = json_decode(json_encode($lists), true);
        //dd($lists, $title);
        $cellData = array_merge($title, $lists);
        Excel::create('快金订餐记录', function ($excel) use ($cellData) {
            $excel->sheet('score', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dinner $dinner
     * @return \Illuminate\Http\Response
     */
    public function show(Dinner $dinner)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dinner $dinner
     * @return \Illuminate\Http\Response
     */
    public function edit(Dinner $dinner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Dinner $dinner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dinner $dinner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dinner $dinner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dinner $dinner)
    {
        //
    }
}

