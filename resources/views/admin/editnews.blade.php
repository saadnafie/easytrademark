@extends('admin.layouts.header')

@section('content')
    <head>
        <script src="https://cdn.tiny.cloud/1/n1zcgfb4ivb5446189cxtc624qc6738ilaulkexlbd67mrrl/tinymce/5/tinymce.min.js"
                referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#mytextarea',
                menubar: true,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | ' +
                  'bold italic backcolor | alignleft aligncenter ' +
                  'alignright alignjustify | bullist numlist outdent indent | ' +
                  'removeformat | help',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });

            tinymce.init({
                selector: '#mytextarea1',
                menubar: true,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | ' +
                  'bold italic backcolor | alignleft aligncenter ' +
                  'alignright alignjustify | bullist numlist outdent indent | ' +
                  'removeformat | help',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
			
			tinymce.init({
                selector: '#mytextarea_ar',
                menubar: true,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | ' +
                  'bold italic backcolor | alignleft aligncenter ' +
                  'alignright alignjustify | bullist numlist outdent indent | ' +
                  'removeformat | help',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
			
			 tinymce.init({
                selector: '#mytextarea_zh',
                menubar: true,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | ' +
                  'bold italic backcolor | alignleft aligncenter ' +
                  'alignright alignjustify | bullist numlist outdent indent | ' +
                  'removeformat | help',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
			
			 tinymce.init({
                selector: '#mytextarea_tr',
                menubar: true,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | ' +
                  'bold italic backcolor | alignleft aligncenter ' +
                  'alignright alignjustify | bullist numlist outdent indent | ' +
                  'removeformat | help',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
        </script>
    </head>
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Blog Detail</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
					@if($errors->any())
						<div class="alert alert-danger text-center">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							<h4>{{$errors->first()}}</h4>
						</div>
					@endif
                        <form action="{{route('update_article')}}" method="post">
                            @csrf

                            <input type="hidden" id="id" name="id" value="{{ $newdetail->id }}" required>
                            <div class="form-group">
                                <label for="service">Title (en)<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="title" name="title_en"
                                       value="{{ (old('title_en') != '')? old('title_en') : $newdetail->title_en}}" required>
                            </div>
							<div class="form-group">
									<label for="service">Title (ar)<span style="color:red">*</span></label>
									<input type="text" class="form-control" id="title" name="title_ar"
										   value="{{ (old('title_ar') != '')? old('title_ar') : $newdetail->title_ar}}" required>
								</div>
								
								<div class="form-group">
									<label for="service">Title (zh)<span style="color:red">*</span></label>
									<input type="text" class="form-control" id="title" name="title_zh"
										   value="{{ (old('title_zh') != '')? old('title_zh') : $newdetail->title_zh}}" required>
								</div>
								
								<div class="form-group">
									<label for="service">Title (tr)<span style="color:red">*</span></label>
									<input type="text" class="form-control" id="title" name="title_tr"
										   value="{{ (old('title_tr') != '')? old('title_tr') : $newdetail->title_tr}}" required>
								</div>

                            <div class="form-group">
                                <label for="service">Description (en)<span style="color:red">*</span></label>
                                <textarea rows="20" class="form-control" id="mytextarea1"
                                          name="description_en">{{ (old('description_en') != '')? old('description_en') : $newdetail->description_en}}</textarea>
                            </div>
							
							<div class="form-group">
								<label for="service">Description (ar)<span style="color:red">*</span></label>
								<textarea rows="6" class="form-control" id="mytextarea_ar"
										  name="description_ar">{{ (old('description_ar') != '')? old('description_ar') : $newdetail->description_ar}}</textarea>
							</div>
							
							<div class="form-group">
								<label for="service">Description (zh)<span style="color:red">*</span></label>
								<textarea rows="6" class="form-control" id="mytextarea_zh"
										  name="description_zh">{{ (old('description_zh') != '')? old('description_zh') : $newdetail->description_zh}}</textarea>
							</div>
							
							<div class="form-group">
								<label for="service">Description (tr)<span style="color:red">*</span></label>
								<textarea rows="6" class="form-control" id="mytextarea_tr"
										  name="description_tr">{{ (old('description_tr') != '')? old('description_tr') : $newdetail->description_tr}}</textarea>
							</div>

                            <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i>
                                Edit Data
                            </button>
                        </form>
                    </div>
                </div>
                <!-- END OVERVIEW -->
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <div class="clearfix"></div>
@endsection
