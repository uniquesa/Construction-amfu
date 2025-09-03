<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\RequestEntry;
use App\Notifications\RequestApproved;
use App\Notifications\RequestRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ApprovalController extends Controller
{
    // ✅ Approve request
    public function approve(Request $req, RequestEntry $requestEntry)
    {
        $approval = Approval::where('request_id', $requestEntry->id)
            ->where('level', $requestEntry->current_level)
            ->firstOrFail();

        $this->authorize('act', $approval); // Policy check (agar policy banayi hai)

        $approval->update([
            'approver_id' => auth()->id(),
            'status'      => 'Approved',
            'comments'    => $req->comments,
            'acted_at'    => now(),
        ]);

        // Move to next level or mark complete
        $nextLevel = $this->nextLevel($requestEntry->current_level);
        if ($nextLevel) {
            $requestEntry->update([
                'current_level' => $nextLevel,
                'status'        => 'Under_Review'
            ]);
        } else {
            $requestEntry->update(['status' => 'Approved']);
        }

        // ✅ Notify request owner
        $requestEntry->user->notify(new RequestApproved($requestEntry));

        return back()->with('success', 'Request approved.');
    }

    // ✅ Reject request
    public function reject(Request $req, RequestEntry $requestEntry)
    {
        $approval = Approval::where('request_id', $requestEntry->id)
            ->where('level', $requestEntry->current_level)
            ->firstOrFail();

        $approval->update([
            'approver_id' => auth()->id(),
            'status'      => 'Rejected',
            'comments'    => $req->comments,
            'acted_at'    => now(),
        ]);

        $requestEntry->update(['status' => 'Rejected']);

        // ✅ Notify request owner
        $requestEntry->user->notify(new RequestRejected($requestEntry));

        return back()->with('error', 'Request rejected.');
    }

    // ✅ Helper function: Next level approval
    private function nextLevel($current)
    {
        $levels = ['PM','FCO','PMO','CSO'];
        $index = array_search($current, $levels);
        return $index !== false && $index < count($levels)-1 ? $levels[$index+1] : null;
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
