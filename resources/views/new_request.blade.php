
<div class="modal" id="new_request" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New Request ({{date('F d, Y')}})</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-request' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='row'>
                        <div class='col-md-4'>
                            Name : {{Auth::user()->name}}
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            Company : {{Auth::user()->company->company_name}}({{Auth::user()->company->company_code}})
                        </div>
                        <div class='col-md-6'>
                            Department : {{Auth::user()->department->department_name}}({{Auth::user()->department->department_code}})
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;<br>
                            <label> <input type="radio"  name="project" onchange="project_control(this.value)" required  value="Project">Projects</label>
                        </div>
                        <div class='col-md-2'>
                            &nbsp;<br>
                            <label>   <input type="radio"  name="project" onchange="project_control(this.value)"  required value="Others"> Others</label>
                        </div>
                        <div class='col-md-8' id='project_id_data' style='display:none;'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    Project ID : 
                            
                                    <select name='project_id' id='project_id' class='form-control-sm form-control category'  onchange='select_project(this.value)' readonly="readonly">
                                        <option value="" ></option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" >{{$project->project_id}} - {{$project->agency}}</option>
                                        @endforeach
                                    </select>   
                                </div>
                            <div class='col-md-6'>
                                &nbsp;<br>
                                SPF Budget :  <span id='budget'></span>
                             </div> 
                            </div>
                        </div>
                        
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            Purpose : 
                            <textarea class='form-control' name='purpose' required></textarea>  
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            Name of Payee : 
                            <input type="text" class="form-control-sm form-control "  id='payee' value=""  name="payee" required/>
                        </div>
                        <div class='col-md-4'>
                            Bank : 
                            <select name='bank' id='bank' class='form-control-sm form-control category'>
                                <option value="" ></option>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}" >{{$bank->bank_name}} - {{$bank->bank_code}}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class='col-md-4'>
                            Account Number : 
                            <input type="number" class="form-control-sm form-control "  id='account_number' value=""  name="account_number" required/>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            Amount : 
                            <input type="number" class="form-control-sm form-control "  id='amount' value="" step='0.01' placeholder='0.00' min='0.01'  name="amount" required/>
                        </div>
                        <div class='col-md-8'>
                            Amount in Words: 
                            <textarea class="form-control "  id='amount_in_words' value=""  name="amount_in_words" readonly ></textarea>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-md-4'>
                            Attachment (optional): 
                            <input type="file" class="form-control-sm "  id='attachment'  name="attachment[]" multiple/>
                        </div>
                        <div class='col-md-8'>
                            Remarks: 
                            <textarea class="form-control "  id='remarks' value=""  name="remarks" required ></textarea>
                        </div>
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
<script>
     var projects = {!! json_encode($projects->toArray()) !!};
       function project_control(value)
    {
        document.getElementById("budget").innerHTML = "";
        // alert(value);
        if(value == "Project")
        {
            document.getElementById("project_id_data").style.display="block";
            $("#project_id").prop('required',true);
        }
        else
        {
            $("#project_id_chosen a span").html("Please select Project");
            document.getElementById("project_id_data").style.display="none";
            $("#project_id").attr("readonly", true); 
            $("#project_id").prop('required',false);
            $('#project_id').val('');  
        }
    }
    function select_project(value)
    {

        for(var i = 0;i<projects.length;i++)
        {
            if(projects[i].id  == value)
           
            {
                var b = parseFloat(projects[i].spf_budget);
                document.getElementById("budget").innerHTML = b.toLocaleString();
                document.getElementById("amount").max = b;
                break;
            }
        }
          

    }
    // System for American Numbering 
var th_val = ['', 'thousand', 'million', 'billion', 'trillion'];
// System for uncomment this line for Number of English 
// var th_val = ['','thousand','million', 'milliard','billion'];
 
var dg_val = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
var tn_val = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
var tw_val = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
function toWordsconver(s) {
  s = s.toString();
    s = s.replace(/[\, ]/g, '');
    if (s != parseFloat(s))
        return 'not a number ';
    var x_val = s.indexOf('.');
    if (x_val == -1)
        x_val = s.length;
    if (x_val > 15)
        return 'too big';
    var n_val = s.split('');
    var str_val = '';
    var sk_val = 0;
    for (var i = 0; i < x_val; i++) {
        if ((x_val - i) % 3 == 2) {
            if (n_val[i] == '1') {
                str_val += tn_val[Number(n_val[i + 1])] + ' ';
                i++;
                sk_val = 1;
            } else if (n_val[i] != 0) {
                str_val += tw_val[n_val[i] - 2] + ' ';
                sk_val = 1;
            }
        } else if (n_val[i] != 0) {
            str_val += dg_val[n_val[i]] + ' ';
            if ((x_val - i) % 3 == 0)
                str_val += 'hundred ';
            sk_val = 1;
        }
        if ((x_val - i) % 3 == 1) {
            if (sk_val)
                str_val += th_val[(x_val - i - 1) / 3] + ' ';
            sk_val = 0;
        }
    }
    // if (x_val != s.length) {
    //     var y_val = s.length;
    //     str_val += 'point ';
    //     for (var i = x_val + 1; i < y_val; i++)
    //         str_val += dg_val[n_val[i]] + ' ';
    // }
    return str_val.replace(/\s+/g, ' ');
}

function withDecimal(n) {
    var nums = n.toString().split('.')
    var whole = toWordsconver(nums[0])
    if (nums.length == 2) {
        var fraction = toWordsconver(nums[1])
        return whole + 'and ' + fraction;
    } else {
        return whole;
    }
}


    document.getElementById('amount').onkeyup = function () {
        document.getElementById('amount_in_words').value = withDecimal(document.getElementById('amount').value);
    }
</script>