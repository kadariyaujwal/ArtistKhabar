<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllQuiz()
    {
        $quizs = Quiz::with('parent')->get();
        return Datatables::of($quizs)->addColumn('action', function ($quiz) {
            return '
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="'.route('quiz.show',[$quiz->id]).'">View</a></li>
                        <li><a href="'.route('quiz.edit',[$quiz->id]).'">Edit</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="'.route('quiz.destroy', [$quiz->id]).'" class="delete">Delete</a>
                        </li>
                    </ul>
                </div>
            ';
        })
            ->make(true);
    }

    public function index()
    {
        return view('admin.views.quiz.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['parent_quiz'] = Quiz::where('parent_id', 1)->get();
        return view('admin.views.quiz.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parent_quiz = Quiz::find(1);
        if(!$parent_quiz) {
            $parent_quiz = new Quiz();
            $parent_quiz->id = 1;
            $parent_quiz->parent_id = 1;
            $parent_quiz->title = 'Main Quiz';
            $parent_quiz->description = 'This is the default Quiz';
            $parent_quiz->save();
        }
        $quiz = new Quiz;
        foreach ($request->quiz as $key => $value) {
            if($key == 'parent_id') {
                $value = (int)$value;
            }
            $quiz->$key = $value;
        }
        $quiz->save();
        \Session::flash('success', 'Quiz is created successfully.');
        return redirect()->action('QuizController@create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['quiz'] = Quiz::with('parent','children')->find($id)->toArray();
//        return $data['quiz'];
        return view('admin.views.quiz.view')->with($data);
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
        $data = Quiz::find($id);
        $delete = $data->delete();
        if($delete) {
            \Session::flash('success', 'Quiz is deleted successfully.');
        } else {
            \Session::flash('error', 'Some internal error occurred.');
        }
        return $delete;
    }
}
