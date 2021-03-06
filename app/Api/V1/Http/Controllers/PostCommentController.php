<?php

namespace App\Api\V1\Http\Controllers;

use League\Fractal\{Manager, Serializer\DataArraySerializer, Resource\Item};
use App\Domain\Posts\Policies\PostCommentPolicy;
use App\Api\V1\Http\Transformers\PostCommentTransformer;
use App\Domain\Posts\DataObjects\PostCommentData;
use App\Domain\Posts\Actions\{CreatePostComment, UpdatePostComment, DeletePostComment};
use App\Domain\Posts\Requests\CreateUpdatePostCommentRequest;
use App\Domain\Posts\PostComment;

class PostCommentController extends Controller
{
    private $manager;

    public function __construct(Manager $manager)
    {
        $this->middleware(['auth:api']);

        $this->manager = $manager->setSerializer(new DataArraySerializer);
        $this->manager->parseIncludes(isset($_GET['include']) ? $_GET['include'] : '');
    }

    public function create($post, CreateUpdatePostCommentRequest $request, CreatePostComment $create)
    {
        $created = $create->execute(PostCommentData::fromRequest($request));
        $resource = new Item($created, new PostCommentTransformer);

        return $this->manager->createData($resource)->toArray();
    }

    public function delete($post, $comment, DeletePostComment $delete)
    {
        $post_comment = PostComment::findOrFail($comment);

        $this->authorize(PostCommentPolicy::class, $post_comment);

        $delete->execute($post_comment);
        
        return response(null, 204);
    }
}