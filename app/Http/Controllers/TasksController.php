<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Task;    // 追加

class TasksController extends Controller
{
    public function index()
    {
        // メッセージ一覧を取得
        $tasks = Task::all();
        // メッセージ一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
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
    public function create()
    {
        $task = new Task;
          
       
        // メッセージ作成ビューを表示
        return view('tasks.create', [
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
         // メッセージを作成
        $tasks = new Task;
        $tasks->content = $request->content;
        $tasks->save();

        // トップページへリダイレクトさせる
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
        $task = Task::findOrFail($id);
      return view('tasks.show', [
            'tasks' => $tasks, 
            ]);
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
        $tasks = Task::findOrFail($id);
        return view('tasks.edit', [
            'tasks' => $tasks,
        ]);
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
        $tasks = Task::findOrFail($id);
        // メッセージを更新
        $tasks->content = $request->content;
        $tasks->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $tasks = Task::findOrFail($id);
        // メッセージを削除
        $tasks->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}