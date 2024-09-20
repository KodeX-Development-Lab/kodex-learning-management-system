<?php

namespace App\Modules\Languages\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Languages\Http\Requests\LanguageRequest;
use App\Modules\Languages\Models\Language;
use App\Modules\Languages\Services\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private $service;

    public function __construct(LanguageService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->all($request);
    }

    public function show(Language $language)
    {
        return $this->service->show($language);
    }

    public function store(LanguageRequest $request)
    {
        $user = auth()->user();

        return $this->service->store($request, $user);
    }

    public function update(LanguageRequest $request, Language $language)
    {
        $user = auth()->user();

        return $this->service->update($language, $request, $user);
    }

    public function destroy(Language $language)
    {
        return $this->service->destroy($language);
    }

}
