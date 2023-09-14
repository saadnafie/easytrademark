@extends('admin.layouts.header')

@section('content')
    <head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
                        <h3 class="panel-title">Blogs</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus" aria-hidden="true"></i> Add
                        </button>
                        <br><br>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> Add </h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('add_new_article')}}" method="post"
                                              enctype="multipart/form-data" >
                                            @csrf
											@if($errors->any())
											<div class="alert alert-danger text-center">
													<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
													<h4>{{$errors->first()}}</h4>
												</div>
											@endif
											
                                            <div class="form-group">
                                                <label for="service">Title (en)<span style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title_en"
                                                       value="{{old('title_en')}}" required>
                                            </div>
											
											<div class="form-group">
                                                <label for="service">Title (ar)<span style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title_ar"
                                                       value="{{old('title_ar')}}" required>
                                            </div>
											
											<div class="form-group">
                                                <label for="service">Title (zh)<span style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title_zh"
                                                       value="{{old('title_zh')}}" required>
                                            </div>
											
											<div class="form-group">
                                                <label for="service">Title (tr)<span style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title_tr"
                                                       value="{{old('title_tr')}}" required>
                                            </div>
											
											<div class="form-group">
                                                <label for="service">URL Slug<span style="color:red">*</span></label>
                                                <input type="text" onkeypress="return /[a-z,-]/i.test(event.key)" class="form-control" id="url_slug" name="url_slug"
                                                       value="{{old('url_slug')}}" required>
													   <p style="color:red;font-size:11px;">
													   1- Ex: What-is-a-trademark<br>
													   2- English only, Space not allowed!<br>
													   3- Any special character or symbols is forbidden (?,$,*,&,#,@,..)<br> 
													   </p>
                                            </div>

                                            <div class="form-group">
                                                <label for="service">Description (en)<span style="color:red">*</span></label>
                                                <textarea rows="6" class="form-control" id="mytextarea"
                                                          name="description_en"  >{{old('description_en')}}</textarea>
                                            </div>
											
											<div class="form-group">
                                                <label for="service">Description (ar)<span style="color:red">*</span></label>
                                                <textarea rows="6" class="form-control" id="mytextarea_ar"
                                                          name="description_ar" >{{old('description_ar')}}</textarea>
                                            </div>
											
											<div class="form-group">
                                                <label for="service">Description (zh)<span style="color:red">*</span></label>
                                                <textarea rows="6" class="form-control" id="mytextarea_zh"
                                                          name="description_zh" >{{old('description_zh')}}</textarea>
                                            </div>
											
											<div class="form-group">
                                                <label for="service">Description (tr)<span style="color:red">*</span></label>
                                                <textarea rows="6" class="form-control" id="mytextarea_tr"
                                                          name="description_tr" >{{old('description_tr')}}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="service">image-1<span style="color:red">*</span></label>
                                                <input type="file" class="form-control" name="img[0]" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="service">image-2</label>
                                                <input type="file" class="form-control" name="img[1]">
                                            </div>

                                            <div class="form-group">
                                                <label for="service">image-3</label>
                                                <input type="file" class="form-control" name="img[2]">
                                            </div>


                                            <button type="submit" class="btn btn-info" >Add Blog</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title (en)</th>
									<th>Title (ar)</th>
									<th>Title (zh)</th>
									<th>Title (tr)</th>
                                    <!--<th>Content</th>-->
                                    <th>Images</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($news as $index=>$value)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$value->title_en}}</td>
										<td>{{$value->title_ar}}</td>
										<td>{{$value->title_zh}}</td>
										<td>{{$value->title_tr}}</td>
											{{--<td>{!! $value->description !!}</td>--}}
                                        <td>
                                            @foreach($value->images as $value2)
                                                <img
                                                    src="{{ url('public/resource_center/news/') }}/{{$value2->image_path}}"
                                                    width="80px">
                                                <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{url('adminpanel/editnewscms')}}/{{$value->id}}"
                                               class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
											   
											    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#myModaldelete{{$index+1}}"><i class="fa fa-trash"
                                                                                                aria-hidden="true"></i>
                                            </button>
											
											   <!-- Modal delete-->
                                            <div class="modal fade" id="myModaldelete{{$index+1}}" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                             style=" background-color: darkred; color: white; ">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    style="color: white;">&times;
                                                            </button>
                                                            <h4 class="modal-title"> Confirm Delete!</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <center>
                                                                <img src="{{url('public/img/delete_icon.jpg')}}"
                                                                     width="200px"/><br>

                                                                <a href="{{url('adminpanel/deletenews')}}/{{$value->id}}"
                                                                   class="btn btn-danger">Yes</a>

                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">No
                                                                </button>
                                                            </center>
                                                        </div>
                                                        <div class="modal-footer">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END OVERVIEW -->
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <div class="clearfix"></div>
	
	@if($errors->any())
	<script type="text/javascript">
	$( document ).ready(function() {
		$('#myModal').modal('show');
		});
	</script>
	@endif
	
	
	<script>

	
			// Below Function Executes On Form Submit
		function ValidationEvent() {
		// Storing Field Values In Variables
		/*var description_en = document.getElementById("mytextarea").value;
		var description_ar = document.getElementById("mytextarea_ar").value;
		var description_zh = document.getElementById("mytextarea_zh").value;
		var description_tr = document.getElementById("mytextarea_tr").value;
		if (description_en != '' && description_ar != '' && description_zh != '' && description_tr != '') {
			return true;
		}else{
			alert("Please, set values before submit");
			return false;
		}onsubmit="return ValidationEvent()"*/
		
			var editorContent = tinyMCE.get('tinyeditor').getContent();
			if (editorContent == '')
			{
				alert("Please, set values before submit");
			return false;
				// Editor empty
			}
			else
			{
				return true;
				// Editor contains a value
			}
		}
		
		/*function submitForm(){
			var description_en = document.getElementById("mytextarea").value;
			var description_ar = document.getElementById("mytextarea_ar").value;
			var description_zh = document.getElementById("mytextarea_zh").value;
			var description_tr = document.getElementById("mytextarea_tr").value;
			if (description_en != '' && description_ar != '' && description_zh != '' && description_tr != '') {
			document.getElementById("myBtn").disabled = false;
			}else{
				document.getElementById("myBtn").disabled = true;
			}
			
		}*/
	</script>
	
@endsection
