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
    public function dashboard(Request $request)
    {
        // 20 is the default if there is no perPage in the request
        $perPage = $request->perPage ?? 20; 

        if($request->fromDate) {
            //convert dates to gerogrian
            $fromDate = implode('-', Verta::getGregorian(
                explode('/', $request->fromDate)[0],
                explode('/', $request->fromDate)[1],
                explode('/', $request->fromDate)[2]
            ));
            
            $toDate = implode('-', Verta::getGregorian(
                explode('/', $request->toDate)[0],
                explode('/', $request->toDate)[1],
                explode('/', $request->toDate)[2]
            ));

            // Delete the effect of clock
            $fromDateStandard = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
            $toDateStandard = Carbon::createFromFormat('Y-m-d', $toDate)->endOfDay();

            $vacations = Vacation::whereBetween('updated_at', [$fromDateStandard, $toDateStandard])
            ->orderBy('updated_at', 'DESC')
            ->paginate($perPage)
            ->withQueryString();
        } else {
            $vacations = Vacation::orderBy('updated_at', 'DESC')
            ->paginate($perPage)
            ->withQueryString();
        }
        
        return view('admin.dashboard', ['vacations' => $vacations]);
    }

    public function update(AdminUpdateVacationRequest $request, Vacation $vacation)
    {
        $user = User::find($vacation->user_id);

        $vacation->response_message = $request->response_message;
        $vacation->status = $request->status;
        
        if($vacation->isDirty('status')) {
            $vacation->save();
            // notify user about the request result
            VacationStatusChange::dispatch($user, $vacation);
        } else {
            $vacation->save();
        }

        session()->flash('successMessage', 'تغییرات با موفقیت ثبت شد');
        return redirect()->back();
    }
}
