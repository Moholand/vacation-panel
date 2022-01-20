<?php

namespace App\Http\Controllers\User;

use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeammateVacationController extends Controller
{
    public function index()
    {
        $vacations = auth()->user()->department()
            ->with(['users.vacations' => function($query) {
                // This isn`t work because order of users count first -- Fix it! 
                $query->orderBy('vacations.updated_at', 'DESC');
            }])
            ->get()
            ->pluck('users')
            ->collapse()
            ->pluck('vacations')
            ->collapse();

        return view('user.teammate-vacations', [
            'vacations' => $vacations
        ]);
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
