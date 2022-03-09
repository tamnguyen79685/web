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
                                <h3 class="card-title">Questions</h3>
                                <a href="{{ url('/admin/add-question') }}" role="button"
                                    style="max-width: 150px;float:right" class="btn btn-block btn-success">Add
                                    Question</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Answer</th>
                                            <th>Teacher</th>
                                            <th>Grade</th>

                                            <th style="width: 120px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($products as $i=>$product)

                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $product->product_name }}</td>
                                                    @if(isset($product->main_image))
                                                    <td>
                                                        <img src="imgs/{{$product->main_image}}" width="80px" height="80px">
                                                    </td>
                                                    @else
                                                    <td>
                                                        <img src="imgs/noimage.png" width="80px" height="80px">
                                                        {{-- <img src="imgs/{{$product->main_image}}" width="80px" height="80px"> --}}
                                                    </td>
                                                    @endif
                                                    <td>{{ $product->product_code }}</td>
                                                    <td>{{$product->product_price}}</td>
                                                    <td>{{ $product->product_color }}</td>
                                                    <td>{{$product->category->category_name}}</td>
                                                    <td>{{$product->section->name}}</td>
                                                    <td>
                                                        @if ($product->status == 1)
                                                            <a class="updateproductstatus text text-success"
                                                                product_id="{{ $product->id }}"
                                                                id="product-{{ $product->id }}"
                                                                href="javascript:void(0)">Active</a>
                                                        @else
                                                            <a class="updateproductstatus text text-danger"
                                                                product_id="{{ $product->id }}"
                                                                id="product-{{ $product->id }}"
                                                                href="javascript:void(0)">Inactive</a>
                                                        @endif
                                                    </td>
                                                    <td style="font-size: 20px">
                                                        <a title="Add Attribute Product" href="{{ url('/admin/attr-product', $product->id) }}"><i class="fa fa-plus"></i></a>
                                                            &nbsp;
                                                        <a title="Add Image Product" href="{{ url('/admin/add-images', $product->id) }}"><i class="fa fa-plus-circle"></i></a>
                                                            &nbsp;
                                                        <a title="Edit Product" href="{{ url('/admin/edit-product', $product->id) }}"><i class="fas fa-edit" style="color: green"></i></a>
                                                            &nbsp;
                                                        <a title="Delete Product" href="javascript:void(0)" record='product' recordid={{$product->id}}
                                                            class="confirmdelete"><i
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
