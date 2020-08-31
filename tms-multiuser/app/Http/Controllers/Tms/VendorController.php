<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tms\Repositories\VendorRepositoryInterface;
use Tms\Traits\CommonTrait;

class VendorController extends Controller
{
    use CommonTrait;

    public function __construct(VendorRepositoryInterface $vendor)
    {
        $this->vendor = $vendor;
    }
    public function index()
    {
        return view('tms.vendors')->with('title', 'Vendors');
    }

    public function listAll()
    {
        return $this->vendor->listAll($this->getUserID());
    }

    public function edit(Request $request)
    {
        if ($request->has('oper')) {
            $action = $request->input('oper');
        } else {
            $action = null;
        }

        $vendorId = $request->input('id');

        $name = $request->input('name');
        $role = $request->input('role');
        $status = $request->input('status');
        $contact = $request->input('contact');
        $user_id = $this->getUserID();

        $params = ['name' => $name,
                   'role' => $role,
                   'status' => $status,
                   'contact' => $contact,
                   'user_id' => $user_id
                   ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->vendor->add($params);
                    break;
                case "edit":
                    $this->vendor->edit($vendorId, $params);
                    break;
                case "del":
                    $this->vendor->delete($vendorId);
                    break;
            }
        } else {
            return null;
        }
    }
}
