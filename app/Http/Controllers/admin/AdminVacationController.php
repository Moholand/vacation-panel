<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Jobs\VacationStatusChange;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Facades\Verta;
use App\Http\Requests\AdminUpdateVacationRequest;

class AdminVacationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 20; // 20 is the default perPage

        $vacations = Vacation::with('user')->where('status', '<>', 'submitted')
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
        ->withQueryString();
        
        return view('admin.dashboard', ['vacations' => $vacations]);
    }

    public function update(AdminUpdateVacationRequest $request, Vacation $vacation)
    {
        $user = User::find($vacation->user_id);

        $vacation->response_message = $request->response_message;
        if($request->submit === 'confirm') {
            $vacation->status = 'confirmed';
        } elseif($request->submit === 'refuse') {
            $vacation->status = 'refuse';
        }

        $vacation->save();

        // notify user about the request result
        VacationStatusChange::dispatch($user, $vacation);

        return redirect()->back()->with('successMessage', 'تغییرات با موفقیت ثبت شد');
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
