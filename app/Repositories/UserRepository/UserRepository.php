<?php 

namespace App\Repositories\UserRepository;

use App\Repositories\BaseRepositoriy;
use App\Models\User;

class UserRepository extends BaseRepositoriy
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}