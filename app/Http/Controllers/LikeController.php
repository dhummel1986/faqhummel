<?php

namespace App\Http\Controllers;

use App\User;
use App\Question;
use App\Like;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LikeController extends Controller
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function like(Question $question)
    {
        $like = TRUE;
        return view('questionForm', ['question' => $question, 'like' => $like ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $profile = Auth::profile();
        $like = $profile->likes()->where('question_id', $question_id)->first();
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
        $like->profile = $profile->id;
        $like->question_id = $question_id;
        if ($update) {
            $like->update();
        }else{
            $like->save();
        }
                return null;
    }

}