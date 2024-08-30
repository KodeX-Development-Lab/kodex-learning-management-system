<?php

namespace App\Modules\Topics\Http\Controller;
use App\Http\Controllers\Controller;
use App\Modules\Topics\Http\Request\TopicRequest;
use App\Modules\Topics\Models\Topic;
use App\Modules\Topics\Services\TopicService;

class TopicController extends Controller{

    private $service;

    public function index(TopicService $service){
        $this->service=$service;
    }

    public function show(Topic $topic){
        return response()->json([
            'status'   => true,
            'data'    => [
                'topic' => $topic,
            ],
            'message' => 'Success',
        ], 201);
    }

    public function store(TopicRequest $request  ){
            $user=auth()->user();
        $topic = $this->service->store($request,$user);

        return response()->json([
            'status'   => true,
            'data'    => [
                'topic' => $topic,
            ],
            'message' => 'Successfully saved',
        ], 201);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $user=auth()->user();
        $topic = $this->service->update($topic, $request,$user);

        return response()->json([
            'status'   => true,
            'data'    => [
                'topic' => $topic,
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return response()->json([], 204);
    }
}
