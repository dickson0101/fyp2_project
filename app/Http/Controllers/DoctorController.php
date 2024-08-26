<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller{
    public function add(Request $request)
    {
        // 处理医生图像
        if ($request->hasFile('DoctorImage')) {
            $image = $request->file('DoctorImage');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = 'empty.jpg';
        }
    
        // 处理日期和时间槽
        $datesAndTimes = $request->input('datesAndTimes');
    $datesAndTimesJson = $datesAndTimes ? json_decode($datesAndTimes, true) : null;

    
        // 创建新医生记录
        Doctor::create([
            'name' => $request->input('DoctorName'),
            'image' => $imageName,
            'certificate' => $request->input('Certificate'),
            'specialist' => $request->input('Specialist'),
            'telephone' => $request->input('Telephone'),
            'language' => $request->input('Language'),
           'dates_and_times' => $datesAndTimesJson  // 使用处理后的 JSON 数据
        ]);
    
        return redirect()->route('doctorPage')->with('success', 'Doctor added successfully!');
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctorEdit')->with('doctor', $doctor);
    }

    public function update(Request $request, $id)
{
    $doctor = Doctor::findOrFail($id);

    // 处理图像
    if ($request->hasFile('DoctorImage')) {
        $image = $request->file('DoctorImage');
        $imageName = time() . '-' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $doctor->image = $imageName;
    }

    // 更新医生信息
    $doctor->name = $request->input('DoctorName');
    $doctor->certificate = $request->input('Certificate');
    $doctor->specialist = $request->input('Specialist');
    $doctor->telephone = $request->input('Telephone');
    $doctor->language = $request->input('Language');

    // 处理日期和时间槽
    $datesAndTimes = $request->input('datesAndTimes');
    $datesAndTimesJson = $datesAndTimes ? json_decode($datesAndTimes, true) : null;

    // 更新日期和时间槽
    $doctor->dates_and_times = $datesAndTimesJson;

    $doctor->save();

    return redirect()->route('doctorPage')->with('success', 'Doctor updated successfully!');
}


    // 获取所有医生的信息
    public function view()
    {
        $doctors = Doctor::all();
        return view('doctorPage', ['doctors' => $doctors]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('searchDoctor'); // Get the search keyword
        $doctors = Doctor::query()
            ->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('specialist', 'like', '%' . $keyword . '%')
            ->get();

        return view('appointment', ['doctors' => $doctors]);
    }

    public function delete($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return redirect()->route('doctorPage')->with('error', 'Doctor not found');
        }

        // 删除图像
        $imagePath = public_path('images') . '/' . $doctor->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $doctor->delete();

        return redirect()->route('doctorPage')->with('success', 'Doctor deleted successfully');
    }
}
