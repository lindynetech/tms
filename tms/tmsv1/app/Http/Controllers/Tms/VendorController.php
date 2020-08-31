<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tms\Repositories\VendorRepositoryInterface;

class VendorController extends Controller
{
    public function __construct(VendorRepositoryInterface $vendor)
    {
        $this->vendor = $vendor;
    }
    public function index()
    {
        return view('tms.vendors');
    }

    public function listAll()
    {
        return $this->vendor->listAll();
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

        $params = ['name' => $name,
                   'role' => $role,
                   'status' => $status,
                   'contact' => $contact
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
