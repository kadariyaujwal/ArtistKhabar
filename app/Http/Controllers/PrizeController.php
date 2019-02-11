<?php

namespace App\Http\Controllers;

use App\Prize;
use App\Quiz;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPrizes()
    {
        $prizes = Prize::with('quiz')->get();
        return Datatables::of($prizes)->addColumn('action', function ($prize) {
            return '
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="'.route('prizes.show',[$prize->id]).'">View</a></li>
                        <li><a href="'.route('prizes.edit',[$prize->id]).'">Edit</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="'.route('prizes.destroy', [$prize->id]).'" class="delete">Delete</a>
                        </li>
                    </ul>
                </div>
            ';
        })
            ->editColumn('image', function (Prize $prize) {
                return '<img src="'.url($prize->image).'" class="img img-responsive">';
            })
            ->make(true);
    }
    public function index() {
        return view('admin.views.prizes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['quizs'] = Quiz::where('parent_id','!=',1)->get();
        return view('admin.views.prizes.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prizeModel = new Prize;
        foreach ($request->prize as $key => $prize) {
            $prizeModel->$key = $prize;
        }
        $prizeModel->save();
        \Session::flash('success', 'Prize added successfully.');
        return redirect()->action('PrizeController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Prize::find($id);
        $delete = $data->delete();
        if($delete) {
            \Session::flash('success', 'Quiz is deleted successfully.');
        } else {
            \Session::flash('error', 'Some internal error occurred.');
        }
        return $delete;
    }
}
