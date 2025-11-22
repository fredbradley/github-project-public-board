<?php

namespace App\Http\Controllers;

use App\Services\CachedGithubService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BoardItemsController extends Controller
{
    public function __construct(private CachedGithubService $github) {}

    /**
     * Display a listing of the resource.
     */
    public function index(string $boardId): View
    {
        $board = $this->github->getBoard($boardId);

        $items = $this->github->getBoardItems($boardId);

        $completedItems = $this->github->getCompletedBoardItems($boardId)->values();

        return view('board', compact('items', 'boardId', 'completedItems', 'board'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $boardId, string $itemId): View
    {
        $item = $this->github->getBoardItem($boardId, $itemId);

        $customFields = ['Status', 'Type', 'Repository', 'Assignees', 'Title', 'Iteration', 'Size', 'Priority', 'Milestone', 'Parent Issue', 'Labels'];
        return view('board-item', compact('item', 'boardId', 'customFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
