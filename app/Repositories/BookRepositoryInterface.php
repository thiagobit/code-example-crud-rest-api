<?php

namespace App\Repositories;

interface BookRepositoryInterface
{
    public function store(array $data);
    public function all();
    public function get(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);
}
