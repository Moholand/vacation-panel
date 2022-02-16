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
        $vacations = Vacation::with('user')
            ->whereIn('user_id', $this->getTeammatesIds()) // Find a better way for doing this!
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
}
