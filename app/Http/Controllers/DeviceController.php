<?php

namespace App\Http\Controllers;

use App\Http\Requests\Device\CreateDeviceRequest;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index()
    {
        $title = 'Data Device';
        $devices = Device::get();

        return view('device.index', compact('title', 'devices'));
    }

    public function create()
    {
        $title = 'Tambah Device';
        $device = new Device();
        $method = 'POST';
        $action = route('devices.store');

        return view('device.form', compact('title', 'device', 'method', 'action'));
    }

    public function store(CreateDeviceRequest $request)
    {
        try {
            DB::beginTransaction();

            Device::create($request->all());

            DB::commit();

            return redirect()->route('devices.index')->with('success', 'Device berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show(Device $device)
    {
        //
    }

    public function edit(Device $device)
    {
        $title = 'Edit Device';
        $method = 'PUT';
        $action = route('devices.update', $device->id);

        return view('device.form', compact('title', 'device', 'method', 'action'));
    }

    public function update(Request $request, Device $device)
    {
        try {
            DB::beginTransaction();

            $device->update($request->all());

            DB::commit();

            return redirect()->route('devices.index')->with('success', 'Device berhasil diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Device $device)
    {
        //
    }
}
