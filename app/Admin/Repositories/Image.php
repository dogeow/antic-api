<?php

namespace App\Admin\Repositories;

use App\Models\Image as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Image extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
