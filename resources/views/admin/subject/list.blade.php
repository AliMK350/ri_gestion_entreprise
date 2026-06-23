@extends('layouts.admin')

@section('title', 'Subjects')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Subjects</h1>
    <a href="{{ url('admin/subject/add') }}" class="btn btn-primary mb-3">Add New Subject</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Class</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getRecord as $subject)
                <tr>
                    <td>{{ $subject->id }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->code ?? '' }}</td>
                    <td>{{ $subject->class_name }}</td>
                    <td>{{ $subject->status == 0 ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ url('admin/subject/edit/' . $subject->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ url('admin/subject/delete/' . $subject->id) }}" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this subject?');">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
