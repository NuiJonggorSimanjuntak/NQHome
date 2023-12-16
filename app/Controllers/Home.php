<?php

namespace App\Controllers;

use App\Models\ModelEvent;
use App\Models\ModelUsers;

class Home extends BaseController
{
    protected $modelEvent, $modelUsers;

    public function __construct()
    {
        $this->modelEvent = new ModelEvent();
        $this->modelUsers = new ModelUsers();
    }

    // public function yayasan()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $query = $this->modelEvent->getEvent()->where('status', '1')->get()->getResultObject();

    //     $currentDate = new \DateTime();

    //     $dataCount = count($query);

    //     $dayOfMonth = $currentDate->format('j');

    //     // $dayOfMonth = $currentDate->format('G');

    //     //jam per 1 jam ganti
    //     // $index = ($dayOfMonth % $dataCount);

    //     //Bulan per 1 bulan ganti
    //     $index = $dayOfMonth % $dataCount;

    //     $data['data'] = $query[$index];

    //     return view('auth/home', $data);
    // }

    // public function index()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $query = $this->modelEvent->getEvent()->where('status', '1')->get()->getResultObject();

    //     $currentDate = new \DateTime();

    //     $dataCount = count($query);

    //     $dayOfMonth = $currentDate->format('j');

    //     // $dayOfMonth = $currentDate->format('G');

    //     //jam per 1 jam ganti
    //     // $index = ($dayOfMonth % $dataCount);

    //     //Bulan per 1 bulan ganti
    //     $index = $dayOfMonth % $dataCount;

    //     $data['data'] = $query[$index];

    //     // return view('auth/home', $data);
    //     $user = user();

    //     if ($user && $user->id !== null) {
    //         $userDetails = $this->modelUsers->select('auth_groups.name')
    //             ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
    //             ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
    //             ->where('auth_groups_users.user_id', $user->id)
    //             ->first();

    //         if ($userDetails) {
    //             switch ($userDetails->name) {
    //                 case 'admin':
    //                     return redirect()->to(base_url('admin'));
    //                 case 'guru':
    //                     return redirect()->to(base_url('guru'));
    //                 case 'santri':
    //                     return redirect()->to(base_url('santri'));
    //                 default:
    //                     return redirect()->to(base_url('default'));
    //             }
    //         }
    //     } else {
    //         return view('auth/home', $data);
    //     }
    // }

    public function yayasan()
    {
        $data['data'] = $this->getDataByDay();
        return view('auth/home', $data);
    }

    public function index()
    {
        $data['data'] = $this->getDataByDay();

        $redirectMap = [
            'admin' => 'admin',
            'guru' => 'guru',
            'santri' => 'santri',
        ];

        return $this->redirectUser($redirectMap, 'default', $data);
    }

    private function getDataByDay()
    {
        date_default_timezone_set('Asia/Jakarta');
        $query = $this->modelEvent->getEvent()->where('status', '1')->get()->getResultObject();

        $currentDate = new \DateTime();
        $dayOfMonth = $currentDate->format('j');
        $dataCount = count($query);
        $index = $dayOfMonth % $dataCount;

        return $query[$index];
    }

    private function redirectUser(array $redirectMap, string $default, array $data)
    {
        $user = user();

        if ($user && $user->id !== null) {
            $userDetails = $this->modelUsers->select('auth_groups.name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
                ->where('auth_groups_users.user_id', $user->id)
                ->first();

            if ($userDetails && isset($redirectMap[$userDetails->name])) {
                return redirect()->to(base_url($redirectMap[$userDetails->name]));
            }
        }

        return view('auth/home', $data);
    }

    public function event()
    {
        $query = $this->modelEvent->getEvent()->where('status', '1')->findAll();
        $data = [
            'title' => 'Event Tahunan Pesantren Nurul Qomariyah Assakran',
            'data' => $query
        ];

        return view('auth/event', $data);
    }
}
