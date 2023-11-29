<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository
{
    protected $model = User::class;

    public function chainOnIndexQuery($query, $request = null)
    {
        if (request('name')) {
            $names = explode(',', request('name'));
            foreach ($names as $name) {
                $query->orWhere(function (Builder $builder) use ($name) {
                   $builder->orWhere('name', 'like', "%$name%");
                });
            }
        }

        if (request('selected_ids') && is_array(request('selected_ids'))) {
            $query->whereIn('id', request('selected_ids'));
        }

        if (! is_null(request('is_active'))) {
            $query->where('is_active', request()->boolean('is_active'));
        }

        return $query;
    }

    public function store(array $data = [])
    {
        $data= collect($data);
        $user = User::create($data->only((new User())->getFillable())->toArray());

        return $user->refresh()->loadRelations();
    }

    public function update(int $id, array $data)
    {
        /** @var User $user */
        $user = $this->findOrFail($id);

        $user->update($data);

        if (isset($data['profile_picture'])) {
            $user->addMediaFromRequest('profile_picture')->toMediaCollection('profile_picture');
        }

        return $user->refresh()->loadRelations();
    }
}
