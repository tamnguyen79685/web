@extends('layouts.admin.admin_dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
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
        <form action="{{ route('admin.edit-question.exam', ['question_id' => $question_id, 'id' => $id]) }}" method="POST"
            enctype="multipart/form-data" novalidate>
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Edit Question</h3>

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
                                                required>{!! $question['question'] !!}</textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="appendnewquestion">
                                {{-- {{$count=array()}} --}}
                                @foreach (explode(',', $question['answer']) as $key => $answer)
                                    {{-- @foreach (explode(',', $question['correct_answer']) as $correct_answer) --}}
                                    <div class="row inputform">
                                        <div class="col-md-1">

                                            <label for="exampleInputEmail1">Answer</label><br>
                                            @if (in_array($key, explode(',', $question['correct_answer'])))
                                                <input type="checkbox" style="width:30px; height:30px;"
                                                    name="correct_answer[]" value="{{ $key }}" checked>
                                            @else
                                                <input type="checkbox" style="width:30px; height:30px;"
                                                    name="correct_answer[]" value="{{ $key }}">
                                            @endif
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">

                                                <div class="form-group">


                                                    <textarea class="form-control answer" name="answer[]"
                                                        style="height:50px" required>{!! $answer !!}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                        @if ($key == 0)
                                            <div class="col-md-1">
                                                <a href="javascript:void(0)" class="addnewquestion"><i
                                                        class="fas fa-plus-circle fa-3x" style="margin-top:25px;"></i></a>

                                            </div>
                                        @else
                                            <div class="col-md-1">
                                                <a href="javascript:void(0)" class="minusnewquestion"><i
                                                        class="fas fa-minus-circle fa-3x" style="margin-top:25px;"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- @endforeach --}}
                                @endforeach
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#question'));
        var allEditors=document.querySelectorAll('.answer');
        for (var i = 0; i < allEditors.length; ++i) {
          ClassicEditor.create(allEditors[i]);
        }
        $(".minusnewquestion").click(function () {
            $(this).closest('.inputform').remove();
        });
        // config.enterMode=ClassicEditor.ENTER_DIV;

    </script>
@endpush
