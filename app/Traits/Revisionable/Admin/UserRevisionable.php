<?php

namespace App\Traits\Revisionable\Admin;

use App\Models\Admin\Role;
use App\Traits\Revisionable\Revisionable;

trait UserRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['name', 'surname', 'email', 'active', 'password'];

    protected $revisionableMediaCollections = ['profile-image'];

    protected $revisionableManyToManyRelations = [
        [
            'input_name' => 'roles',
            'related_title_attributes' => ['name'],
            'class' => Role::class,
            'relation' => 'roles',
        ],
    ];

    public static $revisionableRoute = 'admin.users.show';

    public static $revisionableEnums = [
        'locale',
        'locale-form-label'
    ];

    public static $revisionableBooleans = [
        'active',
        'active-form-label'
    ];

    public static $revisionableTags = [
        'roles',
        'roles-form-label'
    ];
}

