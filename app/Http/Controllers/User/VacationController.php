<?php

namespace App\Http\Controllers\User;

use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vacation\StoreVacationRequest;
use App\Http\Requests\Vacation\UpdateVacationRequest;

class VacationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified.check', ['except' => ['index']]);
        $this->middleware('throttle:limit_3_times', ['only' => ['store']]);
    }

    public function index(Request $request)
    {
        $vacations = Vacation::where('user_id', auth()->user()->id)
            ->searchInTitle()
            ->filterByStatus()
            ->filterByDate()
            ->orderBy('updated_at', 'DESC')
            ->paginate($request->perPage ?? 10) // 10 is the default perPage
            ->withQueryString();

        return view('user.dashboard', compact('vacations'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(StoreVacationRequest $request) 
    {
        auth()->user()->vacations()->create( $request->validated() );

        return redirect()->route('vacations.index')->with('successMessage', 'درخواست شما با موفقیت ثبت شد');
    }

    public function edit(Vacation $vacation) 
    {
        return view('user.create', compact('vacation'));
    }

    public function update(UpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->update( $request->only(['title', 'request_message', 'type', 'mode', 'from_date']) );

        if($request->mode === 'daily') {
            $vacation->to_date = $request->to_date;
        }
        if($request->mode === 'hourly') {
            $vacation->from_hour = $request->from_hour;
            $vacation->to_hour = $request->to_hour;
        }
        $vacation->save();

        return redirect()->route('vacations.index')->with('successMessage', 'درخواست شما با موفقیت ویرایش شد');
    }

    public function destroy($slug) 
    {
        $vacation = Vacation::withTrashed()->where([['user_id', auth()->user()->id], ['slug', $slug]])->first();

        if($vacation->trashed()) {
            $vacation->forceDelete();
            $message = 'درخواست شما با موفقیت حذف گردید';
        } else {
            $vacation->delete();
            $message = 'درخواست شما با موفقیت به زباله‌دان منتقل گردید';
        }

        return redirect()->back()->with('successMessage', $message);
    }

    public function trashed(Request $request)
    {
        $vacations = Vacation::onlyTrashed()
        ->where('user_id', auth()->user()->id)
        ->searchInTitle()
        ->filterByDate()
        ->orderBy('updated_at', 'DESC')
        ->paginate($request->perPage ?? 10) // 10 is the default perPage
        ->withQueryString();

        return view('user.dashboard', compact('vacations'));
    }

    public function restore($slug)
    {
        Vacation::withTrashed()->where([['user_id', auth()->user()->id], ['slug', $slug]])->restore();

        return redirect()->back()->with('successMessage', 'درخواست شما با موفقیت بازیابی گردید');
    }
}
