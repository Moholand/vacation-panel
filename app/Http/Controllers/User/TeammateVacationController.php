<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;
use App\Http\Controllers\Controller;

class TeammateVacationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 20; // 20 is the default if there is no perPage in the request

        $vacations = Vacation::with('user')->whereIn('user_id', $this->getTeammatesIds()) // Find a better way for doing this!
            ->when($request->search && $request->search !== null, function($query) use($request) {
                // Search in the username column - notice user comes with eager loading
                $query->whereHas('user', function($nested_query) use($request) {
                    $nested_query->where('name', 'LIKE', '%' . $request->search . '%');
                });
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
            ->withQueryString();;

        return view('user.teammate_vacations', ['vacations' => $vacations]);
    }

    public function update(Request $request, Vacation $teammate_vacation)
    {
        if($request->has('submit')) {
            if($request->submit === 'confirm') {
                $teammate_vacation->status = 'initial-approval';
            } elseif($request->submit === 'refuse') {
                $teammate_vacation->status = 'refuse';
            }

            $teammate_vacation->save();

            return redirect()->back()->with('successMessage', 'تغییرات با موفقیت ذخیره شد');
        }
    }

    public function getTeammatesIds() 
    {
        $teammate_ids = [];

        $employees = auth()->user()->department()->with(['employees'])
        ->get()
        ->pluck('employees')
        ->collapse();

        foreach ($employees as $employer) {
            array_push($teammate_ids, $employer->id);
        }

        return $teammate_ids;
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
