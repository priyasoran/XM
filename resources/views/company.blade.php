<!DOCTYPE html>
<html>
<head>
    <title>Company details</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $( function() {
            
            jQuery.validator.addMethod("greaterThanOrEqual", 
                function(value, element, params) {

                    if (!/Invalid|NaN/.test(new Date(value))) {
                        return new Date(value) >= new Date($(params).val());
                    }

                    return isNaN(value) && isNaN($(params).val()) 
                        || (Number(value) >= Number($(params).val())); 
                },'Must be greater than {0}.'
            );

            $('.date').datepicker(
                {
                    dateFormat : 'yy-mm-dd',
                    maxDate: new Date()
                }
            );        
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Please fill company details</h2>
        <form class="form-inline" action="{{ url('company') }}" method="get" id="myform">
            @csrf
            <div class="form-group">
                <label class="sr-only" for="companySymbol">Name</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="companySymbol" name="companySymbol" placeholder="Company Symbol*">
                <div class="valid-feedback">
                    @if ($errors->has('companySymbol'))
                        <span class="text-danger">{{ $errors->first('companySymbol') }}</span>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="sr-only" for="startDate">Name</label>
                <input type="text" class="date form-control mb-2 mr-sm-2" id="startDate" name="startDate" placeholder="start Date*">
                <div class="valid-feedback">
                    @if ($errors->has('startDate'))
                        <span class="text-danger">{{ $errors->first('startDate') }}</span>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="sr-only" for="endDate">Name</label>
                <input type="text" class="date form-control mb-2 mr-sm-2" id="endDate" name="endDate" placeholder="End Date*">
                <div class="valid-feedback">
                    @if ($errors->has('endDate'))
                        <span class="text-danger">{{ $errors->first('endDate') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="sr-only" for="email">Name</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="email" name="email" placeholder="Email*">
                <div class="valid-feedback">
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
    </div>
    @isset($data)
        <div class="container mt-5">
            @isset($data['data']['prices'])
                <h2>Company Details</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Company Name</th>
                            <th scope="col">Financial Status</th>
                            <th scope="col">Market Category</th>
                            <th scope="col">Round Lot Size</th>
                            <th scope="col">Security Name</th>
                            <th scope="col">Symbol</th>
                            <th scope="col">Test Issue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $data['companyDetails']['Company Name'] }}</td>
                            <td>{{ $data['companyDetails']['Financial Status'] }}</td>
                            <td>{{ $data['companyDetails']['Market Category'] }}</td>
                            <td>{{ $data['companyDetails']['Round Lot Size'] }}</td>
                            <td>{{ $data['companyDetails']['Security Name'] }}</td>
                            <td>{{ $data['companyDetails']['Symbol'] }}</td>
                            <td>{{ $data['companyDetails']['Test Issue'] }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
            <h2>Company History</h2>
            <table class="table" id="myTable">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Open</th>
                    <th scope="col">High</th>
                    <th scope="col">Low</th>
                    <th scope="col">Close</th>
                    <th scope="col">Volume</th>
                    <th scope="col">Adjclose</th>
                </tr>
                </thead>
                <tbody>
                    @isset($data['data']['prices'])
                        @foreach ($data['data']['prices'] as $singleData)
                            <tr>
                                <td>{{ $singleData['date']}}</td>
                                <td>{{ $singleData['open']}}</td>
                                <td>{{ $singleData['high']}}</td>
                                <td>{{ $singleData['low']}}</td>
                                <td>{{ $singleData['close']}}</td>
                                <td>{{ $singleData['volume']}}</td>
                                <td>{{ $singleData['adjclose']}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>
    @else
    @endif

    <script>
        $(document).ready(function() {
            $("#myform").validate({
                rules: {
                    companySymbol: {
                        required:   true,
                        minlength:  2,
                        maxlength:  6
                    },
                    startDate: {
                        required:   true,
                        date:       true
                    },
                    endDate: {
                        required:   true,
                        date:       true,
                        greaterThanOrEqual: "#startDate"
                    },
                    email: {
                        required:   true,
                        email:      true,
                        maxlength:  50
                    }
                },
                messages: {
                    companySymbol: {
                        required:   "Company Symbol is required",
                        minlength:  "Company Symbol cannot be less than 2 characters",
                        maxlength:  "Company Symbol cannot be more than 6 characters"
                    },
                    startDate: {
                        required:   "Start Date is required",
                        date:       "Start Date should be a valid date"
                    },
                    endDate: {
                        required:   "End Date is required",
                        date:       "End Date should be a valid date",
                        greaterThanOrEqual:"End Date must be greater than Start Date"    
                    },
                    email: {
                        required:   "Email is required",
                        email:      "Email must be a valid email address",
                        maxlength:  "Email cannot be more than 50 characters",
                    }
                }
            });
        });
    </script>
</body>
</html>