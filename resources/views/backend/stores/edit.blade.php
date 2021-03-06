@extends('layout.base')
@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('backend/assets/css/store_list.css')}}">
@stop
    @section('content')
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row page-title">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb" class="float-right mt-1">
                            <a href="/admin/store" class="btn btn-primary">Go Back</a>
                        </nav>
                        <h4 class="mt-2">Edit My Store</h4>
                    </div>
                </div>

                @if(session('message'))
                <p class="alert alert-success">{{ session('message') }}</p>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                            <div class="card-body">
                                        <form id="submitForm" action="{{ route('store.update', $response->_id) }}" method="POST">
                                      @csrf
                                      @method('PUT')
                                        <div class="form-row">
                                          <div class="form-group col-md-6">
                                            <label for="store name">Store Name</label>
                                            <input type="text" name="store_name" class="form-control" value="{{old('store_name', $response->store_name)}}"  placeholder="XYZ Stores" required minlength="2" maxlength="25" minlength="2">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for="inputTagline">Tagline</label>
                                            <input type="text" name="tagline" class="form-control" id="inputTagline" value="{{old('tagline', $response->tagline)}}" required maxlength="50" minlength="4">
                                          </div>
                                        </div>
                                        <div class="form-row">
                                          <div class="form-group col-md-6">
                                            <label for="inputPhoneNumber">Phone Number</label>
                                            <input type="text" name="" id="phone" class="form-control" value="{{old('phone_number', $response->phone_number)}}" placeholder="8173644654" minlength="6" maxlength="16">
                                            <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                                            <small id="helpPhone" class="form-text text-muted">Enter your number without the starting 0, eg 813012345</small>
                                          </div>
                                        <div class="form-group col-md-6" >
                                            <label for="inputEmailAddress"> Email Address (Optional) </label>
                                            <input name="email" class="form-control" value="{{old('email', $response->email)}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="inputAddress">Address</label>
                                          <input type="text" name="shop_address" class="form-control" value="{{old('shop_address', $response->shop_address)}}"  minlength="5" maxlength="100">
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            Update Changes
                                        </button>
                                    </form>
                                    
                                </div>
                             </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        
              </div>
            </div>
          </div>
@endsection

@section("javascript")
   <script src="/backend/assets/build/js/intlTelInput.js"></script>
   <script>
    var input = document.querySelector("#phone");
    var test = window.intlTelInput(input, {
        separateDialCode: true,
        // any initialisation options go here
    });

    $("#phone").keyup(() => {
        if ($("#phone").val().charAt(0) == 0) {
            $("#phone").val($("#phone").val().substring(1));
        }
    });

    $("#submitForm").submit((e) => {
        e.preventDefault();
        const dialCode = test.getSelectedCountryData().dialCode;
        if ($("#phone").val().charAt(0) == 0) {
            $("#phone").val($("#phone").val().substring(1));
        }
        $("#phone_number").val(dialCode + $("#phone").val());
        $("#submitForm").off('submit').submit();
    });

</script>
@stop
