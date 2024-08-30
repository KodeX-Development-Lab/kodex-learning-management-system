<?php

namespace App\Modules\Topics\Services;

use App\Modules\Topics\Models\Topic;



class TopicService{
    public function all(){
        $topic=Topic::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%');
            $query->orWhere('description','like','%'.request('key').'%');
        })->paginate(5);

        return $topic;
    }

    public function get($id)
    {
        $topic = Topic::findOrFail($id);

        return $topic;
    }

    public function store($request,$user)
    {
        $topic = Topic::create([
            'name'        => $request->name,
            'description' => $request->description,
            'created_at'=>$user->id
        ]);

        return $topic;
    }

    public function update($topic, $data,$user)
    {
        $topic->name        = $data->name;
        $topic->description = $data->description;
        $topic->updated_by  = $user->id;
        $topic->save();

        return $topic;
    }

    public function delete($topic)
    {
        $topic->delete();

        return true;
    }
}
