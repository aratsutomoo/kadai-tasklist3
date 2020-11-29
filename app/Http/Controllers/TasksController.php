<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //ログインしているかチェックする
        if (\Auth::check()) {
            //ログイン中のユーザーを取得
            $user = \Auth::user();
            //ログイン中のユーザーのhasManyなTasksを取得->降順->ページネート10個
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
        
            $data = [
                'user' =>$user,
                'tasks' => $tasks,
            ];
            return view('tasks.index', $data); 
        
        //ログインしていない場合はwelcomへ
        }else {
        
            return view('welcome'); 
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $task =new Task;
        
            return view('tasks.create',[
                'task' => $task,
                ]);
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'status'=>'required|max:10',
            'content'=>'required|max:191',
        ]);
        
            $request->user()->tasks()->create([
                'content' =>$request->content,
                'status' =>$request->status, 
                ]);
            return redirect('/');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if(\Auth::id() === $task->user_id){  
            return view('tasks.show',[
                'task' => $task,
                ]);
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        //ログイン中の人とtaskのuser_idが同じだったら
        if(\Auth::id() === $task->user_id){       
            return view('tasks.edit',[
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }
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
        $this->validate($request,[
            'status'=>'required|max:10',
            'content'=>'required|max:191',
        ]);
        
        $task = Task::find($id);
        //ログイン中の人とtaskのuser_idが同じだったら
        if(\Auth::id() === $task->user_id){
            $task->status = $request->status;
            $task->content = $request->content;
            //更新を保存する
            $task->save();
        
            return redirect('/');
    
        }else{
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if(\Auth::id() === $task->user_id){
             $task->delete();
        
             return redirect('/');
        
        //ログインしていない場合はwelcomへ
        }else {
        
            return redirect('/'); 
        }   
       
    }
}
