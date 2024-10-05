<?php

namespace App\Modules\Topics\Services;

use App\Modules\Topics\Models\Topic;
use Illuminate\Support\Str;

class TopicService
{
    public function all($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = Topic::where(function ($query) use ($keyword) {
            if ($keyword != '') {
                $query->where('name', 'LIKE', "%$keyword%");
            }
        });

        if ($request->sort != null && $request->sort != '') {
            $sorts = explode(',', $request->input('sort', ''));

            foreach ($sorts as $sortColumn) {
                $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
                $sortColumn    = ltrim($sortColumn, '-');

                $data->orderBy($sortColumn, $sortDirection);
            }
        } else {
            $data->orderBy('created_at', 'DESC');
        }

        $data = $data->paginate($per_page);

        return $data;
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
            // 'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'created_by'  => $user->id,
        ]);

        return $topic;
    }

    public function update($topic, $request, $user)
    {
        $topic->name        = $request->name;
        // $topic->slug        = Str::slug($request->name);
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
