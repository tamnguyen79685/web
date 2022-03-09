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
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Subject Name:</label>
                                                    <input type="text" class="form-control" required readonly="" value="{{$subjects['name']}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Class:</label>
                                                    <select class="form-control classes" name="class_id[]" multiple required>
                                                        @foreach ($classes as $class)
                                                            @if(in_array($class['id'], explode(",",$subjects['teacher'][0]['class_id'])))
                                                                <option value="{{$class['id']}}">{{ $class['name'] }}</option>
                                                            @endif
                                                        @endforeach

                                                    </select>
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
                                            <th>ID</th>
                                            <th>Subject Name</th>
                                            <th>Class</th>
                                            <th>Teacher</th>
                                            <th>Start time</th>
                                            <th>End time</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($exams as $i => $exam)

                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>
                                                    @foreach ($subjects as $subject)
                                                        @if ($subject['id'] == $exam['subject_id'])
                                                            {{ $subject['name'] }} @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $exam['grade'] }}</td>
                                                <td>{{ $exam['teacher_id'] }}</td>
                                                <td>{{ $exam['start_time'] }}</td>
                                                <td>{{ $exam['end_time'] }}</td>
                                                <td >

                                                    <div class="modal fade" id="exampleModal{{ $exam['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Exam
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
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Subject Name:</label>
                                                                            <select class="form-control" name="subject_id">

                                                                                @foreach ($subjects as $subject)
                                                                                    @if ($subject['id'] == $exam['subject_id'])
                                                                                        <option
                                                                                            value="{{ $subject['id'] }}"
                                                                                            selected>
                                                                                            {{ $subject['name'] }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $subject['id'] }}">
                                                                                            {{ $subject['name'] }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach

                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Grade:</label>
                                                                            <select class="form-control" name="grade">
                                                                                @foreach ($grades as $grade)
                                                                                    @if ($grade == $exam['grade'])
                                                                                        <option value="{{ $grade }}"
                                                                                            selected>{{ $grade }}
                                                                                        </option>
                                                                                    @else <option
                                                                                            value="{{ $grade }}">
                                                                                            {{ $grade }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Start time:</label>
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
                                                        href="{{ url('/admin/index-question/exam', $exam['id']) }}"><i class="fas fa-plus-circle"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Edit Exam" role="button" type="submit" data-toggle="modal" style="font-size: 20px"
                                                        data-target="#exampleModal{{ $exam['id'] }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Exam" href="javascript:void(0)" record='exam' style="font-size: 20px"
                                                        recordid={{ $exam['id'] }} class="confirmdelete"><i
                                                            class="fa fa-trash-alt" style="color: red"></i></a>
                                                </td>
                                            </tr>

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
