@extends('layouts.default')

<!-- content -->
@section('content')
<div class="page-content-header">
	<h1><span class="glyphicon glyphicon-flash"></span> Sign In!</h1>
</div>	
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url' => URL::route('sign-in-post'))) }}

	<div class="form-group">
		{{ Form::label('usr_email', '邮箱') }}
		{{ Form::email('usr_email', Input::old('usr_email'), array('class' => 'form-control', 'placeholder' => 'mrhph@whiledo.net')) }}
	</div>

	<div class="form-group">
		{{ Form::label('usr_password', '密码') }}
		{{ Form::password('usr_password', array('class' => 'form-control', 'value' => Input::old('usr_password'), 'placeholder' => '******')) }}
	</div>

	{{ Form::submit('Go Sign In!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}
@stop
<!-- content emd /-->