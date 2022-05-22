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
        <form action="{{ url('/admin/edit-teacher', $teacher['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Edit Teacher</h3>

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
                                                required value="{{ $teacher['name'] }}">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" placeholder="Enter Email" name="email" class="form-control"
                                                required value="{{ $teacher['email'] }}">

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Birth day</label>
                                            <input type="date" placeholder="" name="birth_day" class="form-control"
                                                required value="{{date('Y-m-d', strtotime($teacher['birth_day']))}}">

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <input type="text" placeholder="Enter Address" name="address" class="form-control"
                                                required value="{{$teacher['address']}}">

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mobile</label>
                                            <input type="number" placeholder="Enter Mobile" name="mobile"
                                                class="form-control" required value="{{ $teacher['mobile'] }}">

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
                                                <label class="custom-file-label"
                                                    for="exampleInputFile">{{ $teacher['image'] }}</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                        {{-- <a href="{{url('/admin/view-image')}}">View Image</a> --}}



                                    </div>
                                    @if (Auth::guard('admin')->user()->role == 1)
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Subject Name</label>
                                                <select class="form-control" name="subject_id" required>
                                                    @foreach ($subjects as $subject)
                                                        @if ($teacher['subject_id'] == $subject['id'])
                                                            <option value="{{ $subject['id'] }}" selected>
                                                                {{ $subject['name'] }}</option>
                                                        @else
                                                            <option value="{{ $subject['id'] }}">{{ $subject['name'] }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Subject Name</label>
                                                @foreach ($subjects as $subject)
                                                    @if ($subject['id'] == Auth::guard('admin')->user()->subject_id)
                                                        <input type="text" class="form-control" name="subject_id"
                                                            value="{{ $subject['name'] }}" readonly="">
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Classes Name</label>
                                            <select class="form-control classes" multiple="multiple" id="exampleInputEmail1"
                                                name="class_id[]">
                                                @foreach ($classes as $class)
                                                    @if (in_array($class['id'], $class_id))
                                                        <option value="{{ $class['id'] }}" selected>{{ $class['name'] }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $class['id'] }}">{{ $class['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>



                                    @if (Auth::guard('admin')->user()->role == 1)
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Leader Subject</label>
                                                <input type="checkbox" name="role" @if ($teacher['role'] == -1) checked @endif>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- /.col -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <img id="output" width="300" height="300" src="{{ $teacher['image'] }}">

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
                                            @if ($teacher['status'] == 1)
                                                <input type="radio" name="status" checked value="1">Active
                                                <input type="radio" name="status" value="0">Inactive
                                            @else
                                                <input type="radio" name="status" value="1">Active
                                                <input type="radio" name="status" value="0" checked>Inactive
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Sex</label>
                                            @if ($teacher['sex'] == 1)
                                                <input type="radio" name="sex" checked value="1">Male
                                                <input type="radio" name="sex" value="0">Female
                                            @else
                                                <input type="radio" name="sex" value="1">Male
                                                <input type="radio" name="sex" value="0" checked>Female
                                            @endif
                                        </div>
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
