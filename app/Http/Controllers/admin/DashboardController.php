<?php
namespace App\Http\Controllers\admin;
use App\Model\Service;
use App\User;
use App\Http\Controllers\Controller;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminDashboard()
    {
        $data['title'] = __('Admin Dashboard');
        $data['total_user'] = User::where(['role' => 2])->count();
        $data['earnings'] = Service::count();
        return view('admin.dashboard', $data);
    }

}
