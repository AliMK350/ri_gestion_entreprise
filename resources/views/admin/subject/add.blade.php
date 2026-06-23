@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add new Subject</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/subject/list') }}">Back</a></li>
                            <li class="breadcrumb-item active">Add New Subject</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('_message')
                        <div class="card card-primary">
                            <form method="POST" action="">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Subject Name</label>
                                        <input type="text" class="form-control" name="name" required
                                            placeholder="Subject name" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control" required>
                                            <option value="">Select type</option>
                                            <option value="Theory" {{ old('type') == 'Theory' ? 'selected' : '' }}>Theory
                                            </option>
                                            <option value="Practical" {{ old('type') == 'Practical' ? 'selected' : '' }}>
                                                Practical</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="by_class" class="form-control" required>
                                            <option value="">Select class</option>
                                            @foreach ($getClass as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('by_class') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
