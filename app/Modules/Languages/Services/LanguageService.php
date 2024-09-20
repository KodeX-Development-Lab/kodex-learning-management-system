<?php

namespace App\Modules\Languages\Services;

use App\Modules\Languages\Models\Language;

class LanguageService
{
    public function all($request)
    {
        try {
            $languages = Language::query();

            if ($request->has('search') && !empty($request->search)) {
                $languages = $languages->where('name', 'LIKE', '%' . $request->search . '%');
            }

            $languages = $languages->paginate($request->get('per_page', 10));

            return response()->json([
                "status"  => true,
                "data"    => [
                    'languages' => $languages,
                ],
                "message" => "Lists of Languages",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error fetching languages: " . $e->getMessage(),
            ], 500);
        }
    }

    public function show($language)
    {
        try {
            return response()->json([
                "status"  => true,
                "data"    => [
                    'language' => $language,
                ],
                "message" => "Language fetched successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error fetching language: " . $e->getMessage(),
            ], 500);
        }
    }

    public function store($request, $user)
    {
        try {
            $language = Language::create([
                'name'       => $request->name,
                'code'       => $request->code,
                'created_by' => $user->id,
            ]);

            return response()->json([
                "status"  => true,
                "data"    => [
                    'language' => $language,
                ],
                "message" => "Language created successfully",
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error creating language: " . $e->getMessage(),
            ], 500);
        }
    }

    public function update($language, $request, $user)
    {
        try {
            $language->update([
                'name'       => $request->name,
                'code'       => $request->code,
                'updated_by' => $user,

            ]);

            return response()->json([
                "status"  => true,
                "data"    => [
                    'language' => $language,
                ],
                "message" => "Language updated successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error updating language: " . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($language)
    {
        try {
            $language->delete();

            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error deleting language: " . $e->getMessage(),
            ], 500);
        }
    }
}
