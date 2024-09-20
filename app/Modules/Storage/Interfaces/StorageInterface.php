<?php

namespace App\Modules\Storage\Interfaces;

interface StorageInterface
{
    public function store($path, $file);
}
