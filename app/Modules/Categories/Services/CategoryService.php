<?php

namespace App\Modules\Categories\Services;

use App\Modules\Categories\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function all($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = Category::where(function ($query) use ($keyword) {
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
        $category = Category::findOrFail($id);

        return $category;
    }

    public function store($request, $user)
    {
        $category = Category::create([
            'name'        => $request->name,
            // 'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'created_by'  => $user->id,
        ]);

        return $category;
    }

    public function update($category, $request, $user)
    {
        $category->name        = $request->name;
        // $category->slug        = Str::slug($request->name);
        $category->description = $request->description;
        $category->updated_by  = $user->id;
        $category->save();

        return $category;
    }

    public function delete($category)
    {
        $category->delete();

        return true;
    }
}
