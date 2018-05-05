<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Like;
use App\User;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'body' => 'required|min:5',
        ], [

            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',

        ]);
        $input = request()->all();

        $question = new Question($input);
        $question->user()->associate(Auth::user());
        $question->save();

        return redirect()->route('home')->with('message', 'IT WORKS!');



        // return redirect()->route('questions.show', ['id' => $question->id]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('question')->with('question', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $edit = TRUE;
        return view('questionForm', ['question' => $question, 'edit' => $edit ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {

        $input = $request->validate([
            'body' => 'required|min:5',
        ], [

            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',

        ]);

        $question->body = $request->body;
        $question->save();

        return redirect()->route('questions.show',['question_id' => $question->id])->with('message', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('home')->with('message', 'Deleted');

    }
public function questionLikeQuestion(Request $request)
{
   $question_id = $request [question_id];
   $is_like = $request['islike']=== 'true';
   $update = false;
   $question = Post::find($question_id);
   if (!$question) {
       return null;
   }
   $user = Auth::user();
   $like = $user->likes()->where('question_id', $question_id)->first();
   if ($like){
       $like_inuse = $like->like;
       $update = true;
       if ($like_inuse == $is_like){
           $like->delete();
           return null;
       }
   }else {
       $like= new Like();
   }
   $like->like = $is_like;
   $like->uer_id = $user->id;
   $like->question_id = $question->id;
   if ($update) {
       $like->update();
   }else{
       $like->save();
   }

}

}