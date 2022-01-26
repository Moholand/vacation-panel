<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Facades\Verta;
use App\Http\Requests\CreateVacationRequest;
use App\Http\Requests\UpdateVacationRequest;

class VacationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified.check', ['except' => ['index']]);
    }

    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10; // 10 is the default perPage

        $vacations = Vacation::where('user_id', auth()->user()->id)
            ->when($request->search && $request->search !== null, function($query) use($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%');
            })
            ->when($request->vacation_status && $request->vacation_status !== null, function($query) use($request) {
                $query->where('status', $request->vacation_status);
            })
            ->when($request->fromDate && $request->toDate, function($query) use($request) {
                //convert dates to gerogrian -- return array of from and to dates
                $dates = $this->dateToGerogrian($request->fromDate, $request->toDate);

                $query->whereBetween('updated_at', [$dates['fromDate'], $dates['toDate']]);
            })
            ->orderBy('updated_at', 'DESC')
            ->paginate($perPage)
            ->withQueryString();

        return view('user.dashboard', ['vacations' => $vacations]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(CreateVacationRequest $request) 
    {
        $vacation = auth()->user()->vacations()->create([
            'title' => $request->title,
            'request_message' => $request->request_message,
            'type' => $request->type,
            'mode' => $request->mode,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'from_hour' => $request->from_hour,
            'to_hour' => $request->to_hour,
        ]);

        $vacation->save();
        
        session()->flash('successMessage', 'درخواست شما با موفقیت ثبت شد');

        return redirect()->back();
    }

    public function edit(Vacation $vacation) 
    {
        return view('user.create', ['vacation' => $vacation]);
    }

    public function update(UpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->update([
            'title' => $request->title,
            'request_message' => $request->request_message,
            'type' => $request->type,
            'mode' => $request->mode,
            'from_date' => $request->from_date
        ]);

        if($request->mode === 'daily') {
            $vacation->to_date = $request->to_date;
        }
        if($request->mode === 'hourly') {
            $vacation->from_hour = $request->from_hour;
            $vacation->to_hour = $request->to_hour;
        }
        $vacation->save();

        session()->flash('successMessage', 'درخواست شما با موفقیت ویرایش شد');
        return redirect()->back();
    }

    public function destroy(Vacation $vacation) 
    {
        $vacation->delete();

        session()->flash('successMessage', 'درخواست شما با موفقیت حذف گردید');
        return redirect()->back();
    }

    public function dateToGerogrian($fromDate, $toDate) : array
    {
        // Convert to gerogrian date manually -- any better idea??
        $fromDateGerogrian = implode('-', Verta::getGregorian(
            explode('/',$fromDate)[0],
            explode('/',$fromDate)[1],
            explode('/',$fromDate)[2]
        ));
        
        $toDateGerogrian = implode('-', Verta::getGregorian(
            explode('/',$toDate)[0],
            explode('/',$toDate)[1],
            explode('/',$toDate)[2]
        ));

        // Delete the effect of clock
        $fromDateStandard = Carbon::createFromFormat('Y-m-d', $fromDateGerogrian)->startOfDay();
        $toDateStandard = Carbon::createFromFormat('Y-m-d', $toDateGerogrian)->endOfDay();

        return [
            'fromDate' => $fromDateStandard,
            'toDate' => $toDateStandard
        ];
    }
}
