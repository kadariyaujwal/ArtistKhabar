<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\QuizCollection ;
use App\Http\Resources\Quiz as QuizResource;
use App\Http\Resources\Question as QuestionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Quiz;
class QuizController extends Controller
{
    //
    public function list(){
        return QuizResource::collection(Quiz::paginate(10));
    }
    public function getChildQuiz($id){
        $quiz = Quiz::where('parent_id','=',$id)->paginate(10);
        return QuizResource::collection($quiz);
    }

    public function getAllMainQuiz(){
        return  QuizResource::collection(Quiz::where('parent_id',0)->paginate(10));
    }

    public function getMainQuiz($id){
        return QuizResource::collection(Quiz::findOrFail($id));
    }

    public function getPrizes($id){
        $quiz = Quiz::findOrFail($id);
        return  QuizResource::collection($quiz->prizes()->paginate(10));
    }

    public function getQuestions($id){
        $quiz = Quiz::with('questions')->findOrFail($id);
        return QuestionResource::collection($quiz->questions()->where('date','=',Carbon::now()->toDateString())->paginate(10));
    }
}
