<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $result = Area::get();

        return view('backend.pages.area.index', compact('result'));
    }

    public function create()
    {
        return view('backend.pages.area.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:areas'
        ]);

        $input              = $request->all();
        // dd($request->all());
        $input['status']    = 1;

        Area::create($input);

        return back()->with('success', 'Thanks! Area Create Successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $info = Area::findOrFail($id);

        return view('backend.pages.area.edit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $area                   = Area::find($id);
        $area->name    = $request->name;
        $area->note    = $request->note;
        $area->save();

        return back()->with('success', 'Thanks! Area Update Successfully.');
    }

    public function destroy($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect()->route('area.index')->with('failed', 'area not found.');
        }

        if ($area->sale()->exists()) {
            return redirect()->route('area.index')->with('failed', 'Cannot delete area because it has associated sale.');
        }
        $area->delete();
        return redirect()->route('area.index')->with('success', 'area deleted successfully.');
    }


    public function changeAreastatus(Request $request)
    {
        $id     = $request->id;
        $info   = Area::find($id);

        if ($info->status == 1) {
            $info->status = 2;
        } else {
            $info->status = 1;
        }
        $info->save();

        return "success";
    }

    public function allcategory()
    {
        $data = Area::where('status', 1)->orderBy('name', 'asc')->get();

        return response()->json($data);
    }
}