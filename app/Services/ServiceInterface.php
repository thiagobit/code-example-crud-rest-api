<?php

namespace App\Services;

interface ServiceInterface
{
    public function store(array $data);
    public function all(array $request);
    public function get(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);
}
