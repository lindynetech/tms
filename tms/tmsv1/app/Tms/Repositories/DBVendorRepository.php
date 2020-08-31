<?php

namespace Tms\Repositories;

use Tms\Repositories\VendorRepositoryInterface;
use Tms\Vendor;

class DBVendorRepository implements VendorRepositoryInterface
{
    public function listAll()
    {
        return Vendor::all();
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

        $vendor->save();
    }

    public function delete($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
    }

    /**
     * [getVendorList description]
     * @return [string]
     */
    public function getVendorsList()
    {
        $vendors_list = "";
        $vendors = Vendor::where('status', 'active')
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
