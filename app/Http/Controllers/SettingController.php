<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Hiển thị trang cài đặt
        return view('setting.index');
    }

    public function updateJars(Request $request)
    {
        // Xử lý cập nhật các hũ (jars)
        // Ví dụ: $request->all() chứa dữ liệu gửi lên

        // Thực hiện lưu dữ liệu...

        return redirect()->route('setting_index')->with('success', 'Cập nhật thành công!');
    }
}