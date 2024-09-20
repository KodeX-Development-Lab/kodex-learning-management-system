<?php

namespace App\Modules\Topics\Services;

use App\Modules\Topics\Models\Topic;

class TopicService
{
    public function all($request)
    {
        $keyword = $request->search ? $request->search : '';
        $limit   = $request->limit ? $request->limit : 10;

        $topics = Topic::where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
        })
            ->paginate($limit);

        return $topics;
    }

    public function get($id)
    {
        $topic = Topic::findOrFail($id);

        return $topic;
    }

    public function store($request, $user)
    {
        $topic = Topic::create([
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => $user->id,
        ]);

        return $topic;
    }

    public function update($topic, $request, $user)
    {
        $topic->name        = $request->name;
        $topic->description = $request->description;
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
