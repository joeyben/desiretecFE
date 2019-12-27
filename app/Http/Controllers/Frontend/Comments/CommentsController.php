<?php

namespace App\Http\Controllers\Frontend\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Comments\ManageCommentsRequest;
use App\Http\Requests\Frontend\Comments\StoreCommentsRequest;
use App\Http\Requests\Frontend\Comments\UpdateCommentsRequest;
use App\Models\Comments\Comment;
use App\Repositories\Frontend\Comments\CommentsRepository;

/**
 * Class CommentsController.
 */
class CommentsController extends Controller
{
    const BODY_CLASS = 'comment';

    /**
     * @var CommentsRepository
     */
    protected $comment;

    /**
     * @param \App\Repositories\Frontend\Comments\CommentsRepository $comment
     */
    public function __construct(CommentsRepository $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param \App\Http\Requests\Frontend\Comments\ManageCommentsRequest $request
     *
     * @return mixed
     */
    public function index(ManageCommentsRequest $request)
    {
        //var_dump($request->get('type'));
        $comments = $this->comment->getForDataTable();

        $response = [
            'data' => $comments
        ];

        return response()->json($response);
    }

    /**
     * @param \App\Http\Requests\Frontend\Comments\StoreCommentsRequest $request
     *
     * @return mixed
     */
    public function store(StoreCommentsRequest $request)
    {
        $comment = $this->comment->create($request->except('_token'));

        $response = [
            'data' => [
                'comment'    => $comment->comment,
                'type'       => $comment->type,
                'created_at' => $comment->created_at->format('d M Y H:i:s'),
                'first_name' => $comment->owner->first_name,
                'last_name'  => $comment->owner->last_name,
                'me'         => $comment->owner->id === access()->user()->id
            ]
        ];

        return response()->json($response);
    }

    /**
     * @param \App\Models\Comments\Comment                               $comment
     * @param \App\Http\Requests\Frontend\Comments\ManageCommentsRequest $request
     *
     * @return mixed
     */
    public function edit(Comment $comment, ManageCommentsRequest $request)
    {
        return view('frontend.comments.edit')->with([
            'comment'               => $comment,
            'status'                => $this->status,
            'category'              => $this->category,
            'catering'              => $this->catering,
            'body_class'            => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Models\Comments\Comment                               $comment
     * @param \App\Http\Requests\Frontend\Comments\UpdateCommentsRequest $request
     *
     * @return mixed
     */
    public function update(Comment $comment, UpdateCommentsRequest $request)
    {
        $input = $request->all();

        $this->comment->update($comment, $request->except(['_token', '_method']));

        return redirect()
            ->route('frontend.comments.index')
            ->with('flash_success', trans('alerts.frontend.comments.updated'));
    }

    /**
     * @param \App\Models\Comments\Comment                               $comment
     * @param \App\Http\Requests\Frontend\Comments\ManageCommentsRequest $request
     *
     * @return mixed
     */
    public function destroy(Comment $comment, ManageCommentsRequest $request)
    {
        $this->comment->delete($comment);

        return redirect()
            ->route('admin.comments.index')
            ->with('flash_success', trans('alerts.frontend.comments.deleted'));
    }
}
