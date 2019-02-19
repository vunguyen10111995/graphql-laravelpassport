<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int())
            ],

            'name' => [
                'type' => Type::string()
            ],

            'email' => [
                'type' => Type::string()
            ],
        ];
    }
}
