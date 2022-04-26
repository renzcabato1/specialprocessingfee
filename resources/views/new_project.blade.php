
<div class="modal" id="new_project" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-project' onsubmit='show();' autocomplete="off"  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='col-md-12'>
                        Company :
                        <select name='company' class='form-control-sm form-control category' required>
                            <option value=""></option>
                            @foreach($companies as $company)
                                @if($company->status)
                                @else
                                <option value='{{$company->id}}' @if(old('company') == $company->id) selected @endif>{{$company->company_code}} - {{$company->company_name}}</option>
                                @endif
                            @endforeach
                        </select>
                     </div>
                    <div class='col-md-12'>
                        Project ID :
                        <input type="text" class="form-control-sm form-control "   value="{{ old('project_id') }}"  name="project_id" required/>
                     </div>
                    <div class='col-md-12'>
                        Project Description :
                        <textarea class="form-control "  value="{{ old('project_description') }}"  name="project_description" required></textarea>
                     </div>
                     {{-- <div class='row'> --}}
                    <div class='col-md-12'>
                        Contract Amount: 
                        <input type="number" class="form-control-sm form-control "  id='awarded_amount' value="" step='0.01' placeholder='0.00' min='0.01'  name="awarded_amount" required/>
                    </div>
                    <div class='col-md-12'>
                        Actual Budget Contract : 
                        <input type="number" class="form-control-sm form-control "  id='amount' value="" step='0.01' placeholder='0.00' min='0.01'  name="amount" required/>
                    </div>
                    <div class='col-md-12'>
                        Budget for SPF : 
                        <input type="number" class="form-control-sm form-control "  id='spf_budget' value="" step='0.01' placeholder='0.00' min='0.01'  name="awarded_amount" required/>
                    </div>
                    {{-- </div> --}}
                    <div class='col-md-12'>
                        Agency :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('location') }}"  name="location" required/>
                     </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type='submit'  class="btn btn-primary" >Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>