@extends('layouts.default')

<!-- content -->
@section('content')
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url' => URL::route('sign-up-post'))) }}

	<div class="form-group">
		{{ Form::label('usr_username', '账号') }}
		{{ Form::text('usr_username', Input::old('usr_username'), array('class' => 'form-control', 'placeholder' => 'mrhph')) }}
	</div>

	<div class="form-group">
		{{ Form::label('usr_email', '邮箱') }}
		{{ Form::email('usr_email', Input::old('usr_email'), array('class' => 'form-control', 'placeholder' => 'mrhph@whiledo.net')) }}
	</div>

	<div class="form-group">
		{{ Form::label('usr_password', '密码') }}
		{{ Form::password('usr_password', array('class' => 'form-control', 'value' => Input::old('usr_password'), 'placeholder' => '******')) }}
	</div>

	<div class="form-group">
		{{ Form::label('usr_password_again', '再次输入密码') }}
		{{ Form::password('usr_password_again', array('class' => 'form-control', 'value' => Input::old('usr_password'), 'placeholder' => '******')) }}
	</div>

	{{ Form::submit('Sign Up', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}
@stop
<!-- content emd /-->