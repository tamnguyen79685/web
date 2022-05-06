@extends('layouts.admin.admin_dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                        @if (Session::has('error_message'))
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
                            <li class="breadcrumb-item active">Question Exam</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <!-- Main content -->
        <form action="{{ route('admin.add-question.grade.exam', ['grade_id'=>$grade_id, 'id'=>$id]) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Add Question</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Question</label>
                                            <textarea name="question" id="question" class="form-control"
                                                required></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image"
                                                        id="exampleInputFile" onchange="loadfile(event)">
                                                    <label class="custom-file-label" for="exampleInputFile"></label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Score</label>
                                            <input type="text" class="form-control" placeholder="Enter score" name="score">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <img id="output" width="300" height="300">

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="appendnewquestion">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label for="exampleInputEmail1">Answer</label><br>
                                        <input type="hidden" value="0" name="correct_answer[]">
                                        <input type="checkbox" style="width:30px; height:30px;" name="correct_answer[]"
                                            id="correct_answer" value="1">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <textarea class="form-control answer" name="answer[]"
                                                    style="height:50px" required></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" class="addnewquestion" ><i
                                                class="fas fa-plus-circle fa-3x" style="margin-top:25px;"></i></a>
                                    </div>

                                </div>
                            </div> --}}
                            {{-- {{var_dump(Session::get('count'))}} --}}

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary create-question-exam">Submit</button>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <!-- SELECT2 EXAMPLE -->
    </div>

@endsection
@push('script')
    {{-- <script src="//cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script> --}}
    <script src="//cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace( 'question' );
    </script>

@endpush
