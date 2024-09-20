<?php

namespace App\Modules\Categories\Services;

use App\Modules\Categories\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function all($request)
    {
        $keyword = $request->search ? $request->search : '';
        $limit   = $request->limit ? $request->limit : 10;

        $categories = Category::where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
        })
            ->paginate($limit);

        return $categories;
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
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'created_by'  => $user->id,
        ]);

        return $category;
    }

    public function update($category, $request, $user)
    {
        $category->name        = $request->name;
        $category->slug        = Str::slug($request->name);
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
