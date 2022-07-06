@extends('layouts.admin')

@section('title', '| Create Coupon')

@section('stylesheet')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}

@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="container">
            <h1 class="text-center">Create New Coupon</h1>
            <hr>
            <div class="row">
                {!! Form::open(['route' => 'coupons.store', 'data-parsley-validate' =>'','method' => 'POST' ]) !!}
                    @csrf
                    <div class="row g-2 align-items-center">
                        <div class="col-1">
                            {{ Form::label('title:','Title:',array('style' => 'margin-top: 10px;')) }}
                        </div>
                        <div class="col-11">
                            {{ Form::text('title',null, array('class'=>'form-control','required' => '', 'maxlength' => '255', 'placeholder' => 'Title' ))  }}
                        </div>
                    </div>
                   
                    <!-- description -->
                    <div class="row g-2 align-items-center" style="margin-top: 5px;">
                        <div class="col-1">
                            {{ Form::label('description','Description: ',array('style' => 'margin-top: 15px;', 'style' => 'margin-right:10px;')) }}
                        </div>
                        <div class="col-11">
                            {{ Form::text('description',null, array('class'=>'form-control','required' => '', 'maxlength' => '255','placeholder' => 'Description' ))  }}
                        </div>
                    </div>
                    
                    <div class="row g-2 align-items-center">
                        <!-- Type coupon -->
                        <div class="col-1">
                            {{ Form::label('type','Coupon Type:',array('style' => 'margin-top: 10px;')) }}
                        </div>
                        <div class="col-3">
                            <select name="type" value="" class="form-control">
                                <option value="">Select</option>
                                <option value="Category_base">Category_base</option>
                                <option value="Product_base">Product_base</option>
                                <option value="Cart_base">Cart_base</option>
                            </select>
                        </div>
                        <!-- type coupon -->
                        <!-- Code -->
                        <div class="col-1">
                            {{ Form::label('code','Code:',array('style' => 'margin-top: 10px; margin-left: 20px;')) }}
                        </div>
                        <div class="col-3">
                            {{ Form::text('code',null, array('class'=>'form-control','required' => '','placeholder' => 'Code Coupon' ))  }}
                        </div>
                        <!-- end code -->
                        <!-- Seller_id -->
                        <div class="col-1">
                            {{ Form::label('seller_id','Seller_id:',array('style' => 'margin-top: 10px;')) }}
                        </div>
                        <div class="col-3">
                            <select name="seller_id" value="" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Admin</option>
                            </select>                        
                        </div>
                        <!-- end seller -->
                    </div>
                   
                    <div class="row g-2 align-items-center">
                        
                        <!-- discount_type -->
                        <div class="col-2">
                            {{ Form::label('discount_type','Discount_type:',array('style' => 'margin-top: 10px;')) }}
                        </div>
                        <div class="col-4">
                            <select name="discount_type" value="" class="form-control">
                                <option value="">Select</option>
                                <option value="Amount">Amount</option>
                                <option value="Percent">Percent</option>
                            </select>                        
                        </div>
                        <!-- end discount_type -->
                        <!-- discount_coup -->
                        <div class="col-2">
                            {{ Form::label('discount_coup','Discount_coup:',array('style' => 'margin-top: 10px;')) }}
                        </div>
                        <div class="col-4">
                            {{ Form::text('discount_coup',null, array('class'=>'form-control','required' => '', 'maxlength' => '255','placeholder' => 'Fixed or Percent'  ))  }}
                        </div>
                        <!-- end discount_coup -->
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-2">
                            {{ Form::label('expiry_date','Expiry_date:',array('style' => 'margin-top: 10px;')) }}
                        </div>
                        <div class="col-4" wire:ignore inline="true">
                            {{ Form::text('expiry_date',null, array('class'=>'form-control','required' => '', 'maxlength' => '255','placeholder' => 'Expiry Date','wire:model' => 'expiry_date', 'id' => 'expiry_date' ))  }}
                        </div>
                        <!-- active -->
                        <div class="col-2 ">
                            {{ Form::label('is_active', 'Active:') }}
                        </div>
                        <div class="col-4">
                            {{ Form::text('is_active',null, array('class' => 'form-control','required' => '', 'style'=>'margin-bottom: 5px;', 'placeholder' => '1 is active')) }}
                        </div>
                        <!-- end active -->
                    </div>
                    <!-- <div class="row g-2 align-items-center">
                        <div class="col-2">
                            {{ Form::label('quantity','Quantity:',array('style' => 'margin-top: 10px;')) }}
                        </div>
                        <div class="col-4">
                            {{ Form::text('quantity',null, array('class'=>'form-control','required' => '', 'maxlength' => '255','placeholder' => 'Quantity'  ))  }}
                        </div>
                    </div> -->
                    <br>
                    <!-- {{Form::label('detail',"Detail:")}}
                    {{Form::textarea('detail',null,array('class' => 'form-control','required' =>'' )) }} -->
                    <div class="row">
                        <div class="col-3">
                            {{ Form::submit('Create Coupon', array('class' => 'btn btn-success btn-lg btn-block','style' => 'margin-top: 20px;')) }}
                        </div>
                        <div class="col-3">
                            {{ Html::linkRoute('coupons.index', 'All Coupons',[],array('class'=>'btn btn-info btn-lg btn-block', 'style' => 'margin-top: 20px;')) }}
                        </div>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}
    
    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>
    <script>
       $(function(){
            $('#expiry_date').datepicker({
                dateFormat: 'yy-mm-dd'
            })
            .on('dp.change',function(ev){
                var data = $('#expiry_date').val();
                $this.set('expiry_date',data);
            })
       });  
    </script>

@endsection