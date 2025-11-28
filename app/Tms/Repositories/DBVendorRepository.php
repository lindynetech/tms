<?php

namespace Tms\Repositories;

use Tms\Repositories\VendorRepositoryInterface;
use Tms\Vendor;
use Tms\Task;
//use App\User;

class DBVendorRepository implements VendorRepositoryInterface
{
    public function listAll($userID)
    {
        //$user = User::where('id', $userID)->first();
        
        return Vendor::where('user_id', $userID)->orderBy('id', 'asc')->get();
    }

    public function edit($id, $params)
    {
        $vendor = Vendor::findOrFail($id);
        extract($params);
        $vendor->name = $name;
        $vendor->role = $role;
        $vendor->status = $status;
        $vendor->contact = $contact;

        $vendor->save();

    }

    public function add($params)
    {
        $vendor = new Vendor();
        extract($params);
        $vendor->name = $name;
        $vendor->role = $role;
        $vendor->status = $status;
        $vendor->contact = $contact;
        $vendor->user_id = $user_id;

        $vendor->save();
    }

    public function delete($id)
    {
        if (Task::where('vid', $id)->get()->count()) {
            return "Reassign Tasks with this vendor first";
        }

        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
    }

    /**
     * [getVendorList description]
     * @return [string]
     */
    public function getVendorsList($userID)
    {
        $vendors_list = "";
        $vendors = Vendor::where('user_id', $userID)
                        ->where('status', 'Active')
                        ->orderBy('id')
                        ->get();

        foreach ($vendors as $vendor) {
            $vendors_list .= "$vendor->id:$vendor->name;";
        }

        return rtrim($vendors_list, ";");
    }

    public function getVendorName($vid)
    {
        $vendor = Vendor::findOrFail($vid);
        return $vendor->name;
    }
}
