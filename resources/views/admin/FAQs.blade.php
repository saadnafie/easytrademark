@extends('admin.layouts.header')

@section('content')
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">FAQs</h3>
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
                                        <h4 class="modal-title"> Add</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{route('add_new_FAQs')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf

                                             @if($errors->any())
                                            <div class="alert alert-danger text-center">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                    <h4>{{$errors->first()}}</h4>
                                                </div>
                                            @endif

                                            <div class="form-group">
                                            <label for="service">Question (en)<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="question" name="question" value="" required>
                                              </div>
                                        	  <div class="form-group">
                                            <label for="service">Question (ar)<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="question" name="question_ar" value="" required>
                                              </div>
                                        	  <div class="form-group">
                                            <label for="service">Question (zh)<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="question" name="question_zh" value="" required>
                                              </div>
                                        	  <div class="form-group">
                                            <label for="service">Question (tr)<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="question" name="question_tr" value="" required>
                                              </div>

                                            <div class="form-group">
                                              <label for="service">URL Slug<span style="color:red">*</span></label>
                                              <input type="text" onkeypress="return /[a-z,-]/i.test(event.key)" class="form-control" id="url_slug" name="q_slug"
                                                               value="{{old('url_slug')}}" required>
                                               <p style="color:red;font-size:11px;">
                                               1- Ex: What-is-a-trademark<br>
                                               2- English only, Space not allowed!<br>
                                               3- Any special character or symbols is forbidden (?,$,*,&,#,@,..)<br> 
                                               </p>
                                             </div>

                                        	  	   <div class="form-group">
                                            <label for="service">Answer (en)<span style="color:red">*</span></label>
                                            <textarea rows="8" class="form-control" id="answer" name="answer" required></textarea>
                                              </div>
                                        	  <div class="form-group">
                                            <label for="service">Answer (ar)<span style="color:red">*</span></label>
                                            <textarea rows="8" class="form-control" id="answer" name="answer_ar" required></textarea>
                                              </div>
                                        	  <div class="form-group">
                                            <label for="service">Answer (zh)<span style="color:red">*</span></label>
                                            <textarea rows="8" class="form-control" id="answer" name="answer_zh" required></textarea>
                                              </div>
                                        	  <div class="form-group">
                                            <label for="service">Answer (tr)<span style="color:red">*</span></label>
                                            <textarea rows="8" class="form-control" id="answer" name="answer_tr" required></textarea>
                                              </div>


                                          <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i> Add</button>
                                          </form>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>


                              						<div class="table-responsive">
                              							<table class="table table-bordered table-striped">
                              								<thead>
                              									<tr>
                              										<th>#</th>
                              										<th>Question (en)</th>
                              										<th>Question (ar)</th>
                              										<th>Question (zh)</th>
                              										<th>Question (tr)</th>
                              										<!--<th>Answer (en)</th>
                              										<th>Answer (ar)</th>
                              										<th>Answer (zh)</th>
                              										<th>Answer (tr)</th>-->
                              										<th>Settings</th>
                              									</tr>
                              								</thead>
                              								<tbody>
                              								@foreach($FAQs as $index=>$value)
                              									<tr>
                              										<td>{{$index+1}}</td>
                              										<td>{{$value->question_en}}</td>
                              										<td>{{$value->question_ar}}</td>
                              										<td>{{$value->question_zh}}</td>
                              										<td>{{$value->question_tr}}</td>
                              										<!--<td>{{$value->answer_en}}</td>
                              										<td>{{$value->answer_ar}}</td>
                              										<td>{{$value->answer_zh}}</td>
                              										<td>{{$value->answer_tr}}</td>-->
                              										<td>

                              										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaledit{{$index+1}}"><i class="fa fa-edit" aria-hidden="true"></i></button>

                                                            <!-- Modal -->
                                <div class="modal fade" id="myModaledit{{$index+1}}" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> Edit data</h4>
                                      </div>
                                      <div class="modal-body">

                               <form  action="{{route('update_FAQs')}}" method="post">
                                   @csrf

                                <input type="hidden"  id="id" name="id" value="{{ $value->id }}" required>




                                <div class="form-group">
                                  <label for="service">Question (en)<span style="color:red">*</span></label>
                                  <input type="text" class="form-control" id="question" name="question" value="{{$value->question_en}}" required>
                                    </div>

                              	    <div class="form-group">
                                  <label for="service">Question (ar)<span style="color:red">*</span></label>
                                  <input type="text" class="form-control" id="question" name="question_ar" value="{{$value->question_ar}}" required>
                                    </div>

                              	    <div class="form-group">
                                  <label for="service">Question (zh)<span style="color:red">*</span></label>
                                  <input type="text" class="form-control" id="question" name="question_zh" value="{{$value->question_zh}}" required>
                                    </div>

                              	    <div class="form-group">
                                  <label for="service">Question (tr)<span style="color:red">*</span></label>
                                  <input type="text" class="form-control" id="question" name="question_tr" value="{{$value->question_tr}}" required>
                                    </div>

                              	  	   <div class="form-group">
                                  <label for="service">Answer (en)<span style="color:red">*</span></label>
                                  <textarea rows="8" class="form-control" id="answer" name="answer" required>{{$value->answer_en}}</textarea>
                                    </div>

                              	   <div class="form-group">
                                  <label for="service">Answer (ar)<span style="color:red">*</span></label>
                                  <textarea rows="8" class="form-control" id="answer" name="answer_ar" required>{{$value->answer_ar}}</textarea>
                                    </div>

                              	   <div class="form-group">
                                  <label for="service">Answer (zh)<span style="color:red">*</span></label>
                                  <textarea rows="8" class="form-control" id="answer" name="answer_zh" required>{{$value->answer_zh}}</textarea>
                                    </div>

                              	   <div class="form-group">
                                  <label for="service">Answer (tr)<span style="color:red">*</span></label>
                                  <textarea rows="8" class="form-control" id="answer" name="answer_tr" required>{{$value->answer_tr}}</textarea>
                                    </div>

                                <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i> Edit Data</button>
                                </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>



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

                                                                <a href="{{url('adminpanel/delete_faq')}}/{{$value->id}}"
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
		@endsection

