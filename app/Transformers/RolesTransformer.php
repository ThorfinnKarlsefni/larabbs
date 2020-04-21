<?php

namespace App\Transformers;

use Spatie\Permission\Models\Role;
use League\Fractal\TransformerAbstract;

class RolesTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name
        ];
    }
}