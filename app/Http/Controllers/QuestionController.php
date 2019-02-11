<?php

namespace App\Http\Controllers;

use App\Question;
use App\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Bsdate;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllQuestions()
    {
        $questions = Question::with('quiz')->get();
        return Datatables::of($questions)->addColumn('action', function ($quiz) {
            return '
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="'.route('question.show',[$quiz->id]).'">View</a></li>
                        <li><a href="'.route('question.edit',[$quiz->id]).'">Edit</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="'.route('question.destroy', [$quiz->id]).'" class="delete">Delete</a>
                        </li>
                    </ul>
                </div>
            ';
        })
            ->editColumn('date', function (Question $question) {
                $date = (object)Carbon::createFromFormat("Y-m-d", $question->date);
                $date = Bsdate::eng_to_nep($date->year,$date->month,$date->day);
                return $date['day'].', '.$date['date'].' '.$date['nmonth'].', '.$date['year'];
            })
            ->make(true);
    }

    public function index()
    {
        return view('admin.views.question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['quizs'] = Quiz::where('parent_id','!=',1)->get();
        return view('admin.views.question.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question();
        foreach ($request->question as $key => $value) {
            if($key == 'quiz_id' || $key == 'correct_answer') {
                $value = (int)$value;
            }
            $question->$key = $value;
        }
        $question->save();
        \Session::flash('success', 'Question is created successfully.');
        return redirect()->action('QuestionController@create');
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
        $data = Question::find($id);
        $delete = $data->delete();
        if($delete) {
            \Session::flash('success', 'Question is deleted successfully.');
        } else {
            \Session::flash('error', 'Some internal error occurred.');
        }
        return $delete;
    }
}
