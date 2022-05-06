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
                        @elseif (Session::has('error_message'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ Session::get('error_message') }}</strong>
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
                                <h3 class="card-title">Questions</h3>
                                <div style="float:right">
                                    {{-- <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/questions-exam') }}" record="questions-exam">Delete All</a> --}}
                                    @if(Auth::guard('admin')->user()->subject_id==$subject_id)
                                    <a role="button" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#exampleModal" class="btn btn-success chose-question">Add Choose
                                        Questions</a>

                                    <a role="button"
                                        href="{{ route('admin.add-question.subject.grade', ['subject_id' => $subject_id, 'grade_id' => $grade_id]) }}"
                                        class="btn btn-success">Add
                                        Question</a>
                                    @endif
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Question Exam
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ url('/admin/choose-question') }}">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Exam:</label>
                                                    <select class="form-control trythis" name="select_id[]" required>
                                                        <option value=0>Select</option>

                                                        @foreach ($teacher_exam['exam'] as $exam)
                                                            @if ($exam['grade_id'] == $grade_id&&$teacher_exam['subject_id']==$subject_id)
                                                                <option value="{{ $exam['id'] }}"
                                                                    data-examid="{{ $exam['id'] }}" data-subject="{{$subject_id}}" data-grade="{{$grade_id}}">
                                                                    {{ $exam['name'] }}-
                                                                    @foreach ($classes as $class)
                                                                        @if (in_array($class['id'], explode(',', $exam['class_id'])))
                                                                            {{ $class['name'] }}
                                                                        @endif
                                                                    @endforeach-
                                                                    @foreach ($subjects as $subject)
                                                                        @if ($subject['id'] == $exam['subject_id'])
                                                                            {{ $subject['name'] }}
                                                                        @endif
                                                                    @endforeach
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </form>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit"
                                                    class="btn btn-primary submit-question">Submit</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Teacher</th>
                                            <th>Subject</th>
                                            <th>Question</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th style="width:100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($questions as $key => $question)

                                            {{-- @if ($grade_id == $question['grade_id']) --}}
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $question['id'] }}>
                                                </th>
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    @foreach ($teachers as $teacher)
                                                        @if ($teacher['id'] == $question['teacher_id'])
                                                            {{ $teacher['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($subjects as $subject)
                                                        @if ($subject['id'] == $question['subject_id'])
                                                            {{ $subject['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{!! $question['question'] !!}</td>
                                                <td>
                                                    {{ date('Y-m-d', strtotime($question['created_at'])) }}
                                                </td>

                                                <td>
                                                    @if ($question['status'] == 1)
                                                        <a @if (Auth::guard('admin')->user()->id == $question['teacher_id']) class="status-question-exam" @endif href="javascript:void(0)" style="color:green"
                                                            data-id="{{ $question['id'] }}"
                                                            id="question-{{ $question['id'] }}">Active</a>
                                                    @else
                                                        <a @if (Auth::guard('admin')->user()->id == $question['teacher_id']) class="status-question-exam" @endif href="javascript:void(0)" style="color:red"
                                                            data-id="{{ $question['id'] }}"
                                                            id="question-{{ $question['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td style="font-size: 20px">
                                                    <a title="View Answer of Question" style="font-size: 20px"
                                                        href="{{ url('/admin/view-answer/question', $question['id']) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Edit Question" role="button"
                                                        href=" {{ route('admin.edit-question.subject.grade', ['question_id' => $question['id'], 'subject_id' => $question['subject_id'], 'grade_id' => $grade_id]) }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Question" href="javascript:void(0)" record='question'
                                                        recordid={{ $question['id'] }} class="confirmdelete"><i
                                                            class="fa fa-trash-alt" style="color: red"></i></a>
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
