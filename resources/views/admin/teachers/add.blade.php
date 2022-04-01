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
                            <li class="breadcrumb-item active">Teachers</li>
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
        <form action="{{ url('/admin/add-teacher') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Add Teacher</h3>

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
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" placeholder="Enter Name" name="name" class="form-control"
                                                required>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" placeholder="Enter Email" name="email" class="form-control"
                                                required>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mobile</label>
                                            <input type="number" placeholder="Enter Mobile" name="mobile"
                                                class="form-control" required>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Password</label>
                                            <input type="text" placeholder="Enter Password" name="password"
                                                class="form-control" value="1" required readonly="">

                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">

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
                                        {{-- <a href="{{url('/admin/view-image')}}">View Image</a> --}}



                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Subject Name</label>
                                            <select class="form-control" id="exampleInputEmail1" name="subject_id" required>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{$subject['id']}}">{{$subject['name']}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Grade</label>
                                            <select class="form-control select2" id="exampleInputEmail1" name="grade_id[]" multiple>
                                                @foreach ($grades as $grade)
                                                    <option value="{{$grade['id']}}">{{$grade['grade']}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Classes Name</label>
                                            <select class="form-control classes" multiple id="exampleInputEmail1" name="class_id[]">
                                                @foreach ($classes as $class)
                                                    <option value="{{$class['id']}}">{{$class['name']}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
                                            <input type="radio" name="status" checked value="1">Active
                                            <input type="radio" name="status" value="0">Inactive

                                        </div>
                                    </div>

                                    <!-- /.col -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <img id="output" width="300" height="300">

                                    </div>
                                </div>
                            </div>


                            <!-- /.row -->

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
