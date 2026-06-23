<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function list()
    {
        $data['getRecord'] = SubjectModel::getRecord();
        $data['header_title'] = 'Subject List';
        return view('admin.subject.list', $data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::where('is_delete', 0)->orderBy('name')->get();
        $data['header_title'] = 'Add new subject';
        return view('admin.subject.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'by_class' => 'required|exists:class,id',
            'status' => 'required|in:0,1',
        ]);

        $save = new SubjectModel();
        $save->name = $request->name;
        $save->type = $request->type;
        $save->by_class = $request->by_class;
        $save->status = $request->status;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/subject/list')->with('success', 'Successfully added new subject');
    }

    public function edit($id)
    {
        $data['getRecord'] = SubjectModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['getClass'] = ClassModel::where('is_delete', 0)->orderBy('name')->get();
            $data['header_title'] = 'Edit Subject';
            return view('admin.subject.edit', $data);
        }

        abort(404);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'by_class' => 'required|exists:class,id',
            'status' => 'required|in:0,1',
        ]);

        $save = SubjectModel::getSingle($id);
        if (empty($save)) {
            abort(404);
        }

        $save->name = $request->name;
        $save->type = $request->type;
        $save->by_class = $request->by_class;
        $save->status = $request->status;
        $save->save();

        return redirect('admin/subject/list')->with('success', 'Subject updated successfully');
    }

    public function delete($id)
    {
        $save = SubjectModel::getSingle($id);
        if (!empty($save)) {
            $save->is_delete = 1;
            $save->save();
        }

        return redirect('admin/subject/list')->with('success', 'Subject deleted successfully');
    }
}
