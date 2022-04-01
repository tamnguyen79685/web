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
        <form action="{{ url('admin/add-question/exam', $id) }}" method="POST" enctype="multipart/form-data" novalidate>
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
                            <div class="appendnewquestion">
                                <div class="row">
                                    <div class="col-md-1">

                                        <label for="exampleInputEmail1">Answer</label><br>
                                        <input type="checkbox" style="width:30px; height:30px;" name="correct_answer[]"
                                            value="0">

                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">

                                            <div class="form-group">


                                                <textarea name="answer[]" style="height:50px" class="form-control answer"
                                                    required></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" class="addnewquestion"><i
                                                class="fas fa-plus-circle fa-3x" style="margin-top:25px;"></i></a>

                                    </div>

                                </div>
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
        ClassicEditor.create(document.querySelector('.answer'));

        // config.enterMode=ClassicEditor.ENTER_DIV;

    </script>
@endpush
