@extends('layouts.admin.admin_dashboard')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ Session::get('success_message') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Exams</h3>
                                <div style="float:right">
                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/exams') }}" record="exams">Delete All</a>
                                    <a role="button" href="{{ url('admin/add-exam') }}" data-toggle="modal"
                                        data-target="#exampleModal" class="btn btn-success">Add
                                        Exam</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Exam</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ url('/admin/add-exam') }}">
                                                @csrf
                                                <input type="hidden" class="form-control"
                                                    value="{{ Auth::guard('admin')->user()->id }}" name="teacher_id">
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Name:</label>
                                                    <input class="form-control" type="text" name='name' required>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Subject Name:</label>
                                                    @foreach ($subjects as $subject)
                                                        @if ($subject['id'] == $teacher['subject_id'])
                                                            <input type="text" name="subject_id" class="form-control"
                                                                required readonly="" value="{{ $subject['name'] }}">
                                                        @endif
                                                    @endforeach

                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Password:</label>
                                                    <input type="text" class="form-control" name="password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Grade:</label>
                                                    <select class="form-control" name="grade_id" id="append_grade_exam"
                                                        required>
                                                        <option>Select</option>
                                                        @foreach ($grades as $grade)
                                                            {{-- @if (in_array($class['id'], $teacher_classes)) --}}
                                                            <option value="{{ $grade['id'] }}">
                                                                {{ $grade['grade'] }}
                                                            </option>
                                                            {{-- @endif --}}
                                                        @endforeach

                                                    </select>

                                                </div>
                                                <div id="appendclassesexam">
                                                    <div class="form-group">

                                                        <label for="recipient-name" class="col-form-label">Class:</label>
                                                        <select class="form-control select2" name="class_id[]" multiple
                                                            required>

                                                            @foreach ($classes as $class)
                                                                @if (in_array($class['id'], $teacher_classes))
                                                                    <option value="{{ $class['id'] }}">
                                                                        {{ $class['name'] }}
                                                                    </option>
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Start time:</label>
                                                    <input class="form-control" type="datetime-local" name='start_time'
                                                        required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">End time:</label>
                                                    <input class="form-control" type="datetime-local" name='end_time'
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Status:</label>
                                                    <input type="radio" name="status" value="1" checked>Active
                                                    <input type="radio" name="status" value="0">Inactive
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="exams" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Subject</th>

                                            <th>Class</th>
                                            {{-- <th>Teacher</th> --}}
                                            <th>Start time</th>
                                            <th>End time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}

                                        @foreach ($exams as $i => $exam)
                                            {{-- @if (Auth::guard('admin')->user()->id == $exam['teacher_id']) --}}
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $exam['id'] }}>
                                                </th>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $exam['name'] }}</td>
                                                <td>
                                                    @foreach ($subjects as $subject)
                                                        @if ($subject['id'] == $exam['subject_id'])
                                                            {{ $subject['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($classes as $class)
                                                        @if (in_array($class['id'], explode(',', $exam['class_id'])))
                                                            {{ $class['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                {{-- <td>{{ $exam['teacher_id'] }}</td> --}}
                                                <td>{{ $exam['start_time'] }}</td>
                                                <td>{{ $exam['end_time'] }}</td>
                                                <td>
                                                    @if ($exam['status'] == 1)
                                                        <a class="status-exam" href="javascript:void(0)" style="color:green"
                                                            data-id="{{ $exam['id'] }}"
                                                            id="exam-{{ $exam['id'] }}">Active</a>
                                                    @else
                                                        <a class="status-exam" href="javascript:void(0)" style="color:red"
                                                            data-id="{{ $exam['id'] }}"
                                                            id="exam-{{ $exam['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td>

                                                    <div class="modal fade" id="exampleModal{{ $exam['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                        Exam
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        action="{{ url('/admin/edit-exam', $exam['id']) }}">
                                                                        @csrf
                                                                        <input type="hidden" class="form-control"
                                                                            value="{{ Auth::guard('admin')->user()->id }}"
                                                                            name="teacher_id">
                                                                        <div class="form-group">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Name:</label>
                                                                            <input class="form-control" type="text"
                                                                                name='name' value="{{ $exam['name'] }}"
                                                                                required>
                                                                        </div>
                                                                        {{-- <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Subject
                                                                                Name:</label>
                                                                            @foreach ($subjects as $subject)
                                                                                @if ($subject['id'] == $exam['subject_id'])
                                                                                    <input type="text" name="subject_id"
                                                                                        class="form-control" required
                                                                                        readonly=""
                                                                                        value="{{ $subject['name'] }}">
                                                                                @endif
                                                                            @endforeach
                                                                        </div> --}}
                                                                        <div class="form-group">
                                                                            <label for="recipient-name" class="col-form-label">Password:</label>
                                                                            <input type="text" class="form-control" name="password" @if(password_verify(Session::get('password'), $exam['password'])) value="{{Session::get('password')}}" @endif>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Grade:</label>
                                                                            <select class="form-control" name="grade_id"
                                                                                required>
                                                                                @foreach ($grades as $grade)
                                                                                    @if ($grade['id'] == $exam['grade_id'])
                                                                                        <option
                                                                                            value="{{ $grade['id'] }}"
                                                                                            selected>
                                                                                            {{ $grade['grade'] }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $grade['id'] }}">
                                                                                            {{ $grade['grade'] }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach

                                                                            </select>

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Class:</label>
                                                                            <select class="form-control select2"
                                                                                name="class_id[]" multiple required>
                                                                                @foreach ($classes as $class)

                                                                                    @if (in_array($class['id'], explode(',', $exam['class_id'])))
                                                                                        <option
                                                                                            value="{{ $class['id'] }}"
                                                                                            selected>
                                                                                            {{ $class['name'] }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                                @foreach ($classes as $class)
                                                                                    @if (in_array($class['id'], $teacher_classes)&&!in_array($class['id'], explode(',', $exam['class_id'])))
                                                                                        <option
                                                                                            value="{{ $class['id'] }}">
                                                                                            {{ $class['name'] }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach

                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Start
                                                                                time:</label>
                                                                            <input class="form-control"
                                                                                type="datetime-local" name='start_time'
                                                                                value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($exam['start_time'])) }}"
                                                                                required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="message-text"
                                                                                class="col-form-label">End time:</label>
                                                                            <input class="form-control"
                                                                                type="datetime-local" name='end_time'
                                                                                value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($exam['end_time'])) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Status:</label>
                                                                            @if ($exam['status'] == 1)
                                                                                <input type="radio" name="status" value="1"
                                                                                    checked>Active
                                                                                <input type="radio" name="status"
                                                                                    value="0">Inactive
                                                                            @else
                                                                                <input type="radio" name="status"
                                                                                    value="1">Active
                                                                                <input type="radio" name="status" checked
                                                                                    value="0">Inactive
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Edit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a title="Index Question Exam" style="font-size: 20px"
                                                        href="{{ route('admin.question.grade.exam', ['grade_id' => $exam['grade_id'], 'id' => $exam['id']]) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Edit Exam" role="button" type="submit" data-toggle="modal"
                                                        style="font-size: 20px"
                                                        data-target="#exampleModal{{ $exam['id'] }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Exam" href="javascript:void(0)" record='exam'
                                                        style="font-size: 20px" recordid={{ $exam['id'] }}
                                                        class="confirmdelete"><i class="fa fa-trash-alt"
                                                            style="color: red"></i></a>
                                                </td>
                                            </tr>
                                            {{-- @endif --}}
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
