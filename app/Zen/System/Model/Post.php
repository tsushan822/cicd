<?php
namespace App\Zen\System\Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Laravel\Scout\Searchable;

class Post extends \Wink\WinkPost
{
    use UsesSystemConnection;
    use Searchable;

    public $asYouType = true;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }
}