<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Jobs\VacationStatusChange;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateVacationRequest;

class AdminVacationController extends Controller
{
    public function index(Request $request)
    {
        $vacations = Vacation::with('user')->where('status', '<>', 'submitted')
            ->searchInAuthor()
            ->filterByStatus()
            ->filterByDate()
            ->orderBy('updated_at', 'DESC')
            ->paginate($request->perPage ?? 20) // 20 is the default perPage
            ->withQueryString();
        
        return view('admin.dashboard', compact('vacations'));
    }

    public function update(AdminUpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->response_message = $request->response_message;
        $vacation->status = $request->verification === 'confirmed' ? 'confirmed' : 'refuse';

        $vacation->save();

        // notify user about the request result
        VacationStatusChange::dispatch(User::findOrFail($vacation->user_id), $vacation);

        return redirect()->back()->with('successMessage', 'تغییرات با موفقیت ثبت شد');
    }
}
