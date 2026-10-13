@extends('layouts.admin')

@section('content')


  <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Rooms</h5>
          <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
                <!-- Email input -->
                @csrf
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>
                @if($errors->has('name'))
                <p class="alert alert-danger">{{ $errors->first('name') }}</p>
                @endif
                <div class="form-outline mb-4 mt-4">
                  <input type="file" name="image" id="form2Example1" class="form-control" />
                 
                </div>
                @if($errors->has('image'))
                <p class="alert alert-danger">{{ $errors->first('image') }}</p>
                @endif  
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="price" id="form2Example1" class="form-control" placeholder="price" />
                 
                </div> 
                @if($errors->has('price'))
                <p class="alert alert-danger">{{ $errors->first('price') }}</p>
                @endif
                 <div class="form-outline mb-4 mt-4">
                  <input type="text" name="max_persons" id="form2Example1" class="form-control" placeholder="num_persons" />
                 
                </div> 
                @if($errors->has('max_persons'))
                <p class="alert alert-danger">{{ $errors->first('max_persons') }}</p>
                @endif
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="num_beds" id="form2Example1" class="form-control" placeholder="num_beds" />
                 
                </div> 
                @if($errors->has('num_beds'))
                <p class="alert alert-danger">{{ $errors->first('num_beds') }}</p>
                @endif
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="size" id="form2Example1" class="form-control" placeholder="size" />
                 
                </div> 
                @if($errors->has('size'))
                <p class="alert alert-danger">{{ $errors->first('size') }}</p>
                @endif
               <div class="form-outline mb-4 mt-4">
                <input type="text" name="view" id="form2Example1" class="form-control" placeholder="view" />
               
               </div> 
                @if($errors->has('view'))
                 <p class="alert alert-danger">{{ $errors->first('view') }}</p>
                 @endif
               <select name="hotel_id" class="form-control" id="exampleFormControlSelect1">
                <option>Choose Hotel Name</option>

                @foreach($hotels as $hotel)
                    <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                @endforeach
               </select>
               <br>
               @if($errors->has('hotel_id'))
                 <p class="alert alert-danger">{{ $errors->first('hotel_id') }}</p>
                 @endif
   

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
@endsection