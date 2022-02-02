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
}
