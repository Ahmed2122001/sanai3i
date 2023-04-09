<?php

namespace App\Http\Controllers\region;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    public function showAllRegions()
    {
        $regions = Region::all();
        return response()->json(['region' => $regions, 'تم استرجاع البيانات بنجاح']);
    }
    public function showOneRegion($id)
    {
        $region = Region::find($id);
        if (is_null($region)) {
            return $this->returnError('001', 'هذا المنطقة غير موجود');
        }
        return response()->json(['region' => $region, 'تم استرجاع البيانات بنجاح']);
    }
    public function create(Request $request)
    {
        $rules = [
            'city_name' => 'required | unique:region',
            'code' => 'required | unique:region',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $region = Region::create($request->all());
        return response()->json(['region' => $region, 'تم اضافة المنطقة بنجاح']);
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'city_name' => 'required',
            'code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->returnError('001', $validator->errors());
        }
        $region = Region::find($id);
        if (is_null($region)) {
            return $this->returnError('001', 'هذا المنطقة غير موجود');
        }
        $region->update($request->all());
        return response()->json(['region' => $region, 'تم تحديث المنطقة بنجاح']);
    }
    public function delete(Request $request, $id)
    {
        $region = Region::find($id);
        if (is_null($region)) {
            return $this->returnError('001', 'هذا المنطقة غير موجود');
        }
        $region->delete();
        return response()->json(['تم حذف المنطقة بنجاح']);
    }
}
