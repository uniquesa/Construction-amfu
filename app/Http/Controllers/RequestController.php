<?php

namespace App\Http\Controllers;

use App\Models\RequestEntry;
use App\Models\Approval;
use App\Models\Attachment;
use App\Models\User;
use App\Notifications\RequestSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class RequestController extends Controller
{
    public function __construct()
    {
        // ensure sab actions sirf logged-in users k liye hain
        $this->middleware('auth');
    }

    // 📄 Show all requests
    public function index()
    {
        $requests = RequestEntry::with('user')->latest()->get();
        return view('requests.index', compact('requests'));
    }

    // 📝 Create request form
    public function create()
    {
        return view('requests.create');
    }

    // 💾 Store new request
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'attachments.*' => 'file|max:2048'
        ]);

        $userId = auth('web')->id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a request.');
        }

        DB::transaction(function () use ($request, $userId) {

            // Create request entry
            $requestEntry = RequestEntry::create([
                'user_id'       => $userId,
                'title'         => $request->title,
                'description'   => $request->description,
                'status'        => 'Pending',
                'current_level' => 'PM',
            ]);

            // Seed approvals (4 steps)
            foreach (['PM','FCO','PMO','CSO'] as $level) {
                Approval::create([
                    'request_id' => $requestEntry->id,
                    'level'      => $level,
                    'status'     => 'Pending',
                ]);
            }

            // Save attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments', 'public');
                    Attachment::create([
                        'request_id' => $requestEntry->id,
                        'file_name'  => $file->getClientOriginalName(),
                        'file_path'  => $path,
                    ]);
                }
            }

            // Notify PMs (first approver role)
            $approvers = User::role('PM')->get();
            Notification::send($approvers, new RequestSubmitted($requestEntry));
        });

        return redirect()->route('requests.index')->with('success', 'Request submitted successfully!');
    }

    // 👁 Show single request
    public function show(RequestEntry $requestEntry)
    {
        $requestEntry->load(['user','attachments','approvals.approver']);
        return view('requests.show', compact('requestEntry'));
    }

    // ✏ Edit
    public function edit(RequestEntry $requestEntry)
    {
        abort_unless(auth()->id() === $requestEntry->user_id && $requestEntry->status === 'Pending', 403);
        return view('requests.edit', compact('requestEntry'));
    }

    // 🔄 Update
    public function update(Request $request, RequestEntry $requestEntry)
    {
        abort_unless(auth()->id() === $requestEntry->user_id && $requestEntry->status === 'Pending', 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $requestEntry->update($request->only('title','description'));

        return redirect()->route('requests.show', $requestEntry)->with('success', 'Request updated.');
    }

    // ❌ Delete
    public function destroy(RequestEntry $requestEntry)
    {
        abort_unless(auth()->id() === $requestEntry->user_id && $requestEntry->status === 'Pending', 403);

        $requestEntry->delete();
        return redirect()->route('requests.index')->with('success', 'Request deleted.');
    }
}
