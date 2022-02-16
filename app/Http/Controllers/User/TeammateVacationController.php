<?php

namespace App\Http\Controllers\User;

use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class TeammateVacationController extends Controller
{
    public function index(Request $request, UserService $userService)
    {
        $vacations = Vacation::with('user')
            ->whereIn('user_id', $userService->getTeammatesIds())
            ->searchInAuthor()
            ->filterByStatus()
            ->filterByDate()
            ->orderBy('updated_at', 'DESC')
            ->paginate($request->perPage ?? 20) // 20 is the default
            ->withQueryString();;

        return view('user.teammate_vacations', compact('vacations'));
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
}
