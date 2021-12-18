<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Jobs\VacationStatusChange;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Facades\Verta;
use App\Http\Requests\AdminUpdateVacationRequest;

class AdminVacationController extends Controller
{
    public function dashboard()
    {
        $vacations = Vacation::orderBy('updated_at', 'DESC')->get();
        
        return view('admin.dashboard', ['vacations' => $vacations]);
    }

    public function update(AdminUpdateVacationRequest $request, Vacation $vacation)
    {
        $user = User::find($vacation->user_id);

        $vacation->response_message = $request->response_message;
        $vacation->status = $request->status;
        
        if($vacation->isDirty('status')) {
            $vacation->save();

            VacationStatusChange::dispatch($user, $vacation);

            session()->flash('successMessage', 'تغییرات با موفقیت ثبت شد');
            return redirect()->back();
        } else {
            $vacation->save();

            session()->flash('successMessage', 'تغییرات با موفقیت ثبت شد');
            return redirect()->back();
        }
    }
}
