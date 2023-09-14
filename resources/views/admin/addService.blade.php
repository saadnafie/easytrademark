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
							<h3 class="panel-title">
							    <i class="lnr lnr-layers"></i>
							    Add New Service</h3>
							<hr>
						</div>
						<div class="panel-body">

                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="lnr lnr-layers"></i> Add New Service</div>
                              <div class="panel-body">
 <form  action="{{route('add_new_service')}}" method="post">
     @csrf

	 <div class="form-group">
    <label for="service">Service Abbreviation</label>
    <input type="text" class="form-control" id="service_abbre" name="service_abbre" required>
      </div>

  <div class="form-group">
    <label for="service">Service Name (en)</label>
    <input type="text" class="form-control" id="service_type" name="service_type" required>
      </div>

	    <div class="form-group">
    <label for="service">Service Name (ar)</label>
    <input type="text" class="form-control" id="service_type" name="service_type_ar" required>
      </div>

	   <div class="form-group">
    <label for="service">Service Name (zh)</label>
    <input type="text" class="form-control" id="service_type" name="service_type_zh" required>
      </div>

	  <div class="form-group">
    <label for="service">Service Name (tr)</label>
    <input type="text" class="form-control" id="service_type" name="service_type_tr" required>
      </div>

	  <div class="form-group">
    <label for="service">Execution Days No</label>
    <input type="text" class="form-control" id="days_no" name="days_no" required>
      </div>

      <div class="form-group">
  <label for="comment">Icon Code:</label>
    <input type="text" class="form-control" id="icon_code" name="icon_code" required>
  </div>

    <div class="form-group">
  <label for="comment">Description (en):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc"required></textarea>
</div>

<div class="form-group">
  <label for="comment">Description (ar):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc_ar"required></textarea>
</div>

<div class="form-group">
  <label for="comment">Description (zh):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc_zh"required></textarea>
</div>

<div class="form-group">
  <label for="comment">Description (tr):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc_tr"required></textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (en):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc" required></textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (ar):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc_ar" required></textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (zh):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc_zh" required></textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (tr):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc_tr" required></textarea>
</div>

    <div class="form-group">
  <label for="comment">Why Section (en):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc" required></textarea>
</div>

   <div class="form-group">
  <label for="comment">Why Section (ar):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc_ar" required></textarea>
</div>

   <div class="form-group">
  <label for="comment">Why Section (zh):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc_zh" required></textarea>
</div>

   <div class="form-group">
  <label for="comment">Why Section (tr):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc_tr" required></textarea>
</div>

    <div class="form-group">
  <label for="comment">When Section (en):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc" required></textarea>
</div>

  <div class="form-group">
  <label for="comment">When Section (ar):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc_ar" required></textarea>
</div>

  <div class="form-group">
  <label for="comment">When Section (zh):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc_zh" required></textarea>
</div>

  <div class="form-group">
  <label for="comment">When Section (tr):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc_tr" required></textarea>
</div>

    <div class="form-group">
  <label for="comment">How Section (en):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc" required></textarea>
</div>

<div class="form-group">
  <label for="comment">How Section (ar):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc_ar" required></textarea>
</div>

<div class="form-group">
  <label for="comment">How Section (zh):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc_zh" required></textarea>
</div>

<div class="form-group">
  <label for="comment">How Section (tr):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc_tr" required></textarea>
</div>



  <button type="submit" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Service</button>
  </form>
                              </div>

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
		@endsection

