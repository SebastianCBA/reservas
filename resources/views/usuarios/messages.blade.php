@extends('admin.layouts.app')

@section('title', 'Send Message')

@section('content')

<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif  

{!! Form::open(['route' => 'user.store_message', 'method' => 'POST']) !!}
{!! Form::hidden('user_id', $user->id) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<h4>Send Message to {{ $user->name }} ({{ $user->email }}). The user has set @php echo $user->language_id?'English':'Spanish'; @endphp as default language</h4>
<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			
            <div class="form-group">
                Title <br>
                {!! Form::text('name', $re->titulo, ['class' => 'form-control', 'placeholder' => 'Name', 'required']) !!}
            </div>
            <div class="form-group">
                Text <br>	
                {!! Form::textarea('message', $re->message, ['id'=>'message', 'class' => 'form-control', 'placeholder' => 'Message English', 'required']) !!}
            </div>


        		{!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
        
	</div>


{!! Form::close() !!}
</div>
@if(count($messages) > 0)
    <table class="table table-striped">
        <thead>
            <th>Id</th>
            <th>Text</th>
            <th>Mesagge</th>
        </thead>
        <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->id }}</td>
                    <td>{{ $message->titulo }}</td>
                    <td>{!! $message->message !!}</td>
                    <td>
                        <a href="{{ route('user.sendwm', ['id'=> $user->id, 'idm' =>$message->id]) }}" title="Send" 
                                
                                class="btn btn-success">                        
                                <span class="glyphicon glyphicon-eject" aria-hidden="true"></span>
                        </a>                                                
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>
@endif
@endsection

@section('js')

    <script src="vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script>
         CKEDITOR.replace( 'message' );
        // $('.textarea').ckeditor(); // if class is prefered.
    </script>

@endsection
