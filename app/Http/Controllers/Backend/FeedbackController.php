<?php

namespace App\Http\Controllers\Backend;

use App\Models\Feedback;
use App\Models\Translate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
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
        $perPage = 25;
        $feedback = Feedback::latest()->paginate($perPage);

        return view('feedback.index', compact('feedback'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $feedback = new Feedback();
        $feedback->name = $requestData['name'];
        $feedback->phone_number = $requestData['phone_number'];
        $feedback->type = $requestData['type'];
        $feedback->text = $requestData['text'];
        $feedback->save();

        return redirect('admin/feedback')->with('flash_message', 'Добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('feedback.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('feedback.edit', compact('feedback'));
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
        $requestData = $request->all();

        $feedback = Feedback::findOrFail($id);
        $feedback->name = $requestData['name'];
        $feedback->phone_number = $requestData['phone_number'];
        $feedback->type = $requestData['type'];
        $feedback->text = $requestData['text'];

        $feedback->update();


        return redirect('admin/feedback')->with('flash_message', 'Cохранен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->delete();

        return redirect('admin/feedback')->with('flash_message', 'Удален');
    }
}
