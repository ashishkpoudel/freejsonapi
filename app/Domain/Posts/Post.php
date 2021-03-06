<?php

namespace App\Domain\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Domain\Users\User;
use App\Domain\Posts\Traits\PostRelationship;
use App\Domain\Helpers\HasSlug;

final class Post extends Model
{
    use PostRelationship, HasSlug;

    const TABLE = 'posts';

    protected $table = self::TABLE;

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function featuredImage(): string
    {
        return url(storage_url_for($this->featured_image));
    }

    public function body(): string
    {
        return $this->body;
    }

    public function user(): User
    {
        return $this->userRelation;
    }

    public function comments(): Collection
    {
        return $this->commentsRelation;
    }

    public function createdAt(): Carbon
    {
        return $this->created_at;
    }

    public function updatedAt(): Carbon
    {
        return $this->updated_at;
    }
}