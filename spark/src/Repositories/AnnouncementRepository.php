<?php

namespace Laravel\Spark\Repositories;

use App\Zen\System\Model\Team;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use Laravel\Spark\Announcement;
use Laravel\Spark\Events\AnnouncementCreated;
use Laravel\Spark\Contracts\Repositories\AnnouncementRepository as AnnouncementRepositoryContract;

class AnnouncementRepository implements AnnouncementRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function recent()
    {
        $allOwners = Team ::get() -> pluck('owner_id') -> toArray();
        return Announcement ::with('creator')-> where(function ($query) use ($allOwners) {
            $query = $query -> where('for_owner', 0);
            if(in_array(auth() -> id(), $allOwners)) {
                $query -> orWhere('for_owner', 1);
            }
        }) -> orderBy('created_at', 'desc') -> take(8) -> get();
    }

    /**
     * {@inheritdoc}
     */
    public function create($user, array $data)
    {
        $announcement = Announcement ::create([
            'id' => Uuid ::uuid4(),
            'user_id' => $user -> id,
            'body' => $data['body'],
            'action_text' => Arr ::get($data, 'action_text'),
            'action_url' => Arr ::get($data, 'action_url'),
        ]);

        event(new AnnouncementCreated($announcement));

        return $announcement;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Announcement $announcement, array $data)
    {
        $announcement -> fill([
            'body' => $data['body'],
            'action_text' => Arr ::get($data, 'action_text'),
            'action_url' => Arr ::get($data, 'action_url'),
        ]) -> save();
    }
}
