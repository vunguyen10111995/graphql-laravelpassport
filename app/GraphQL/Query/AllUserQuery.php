<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL;
use App\User;
use Rebing\GraphQL\Support\Query;

class AllUserQuery extends Query
{
    public function type()
    {
        return Type::listOf(GraphQL::type('user'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $users = User::all();

        if (isset($args['name'])) {
            $users = $users->where('name', $args['name']);
        }

        if (isset($args['id'])) {
            $users = $users->where('id', $args['id']);
        }

        if (isset($args['email'])) {
            $users = $users->where('id', $args['email']);
        }

        return $users;
    }
}
