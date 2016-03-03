@extends("bear::emails.base")

@section('message')

	<h1 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 24pt; color: #777777;">Change password.</h1>

	<p>To reset your password, please enter the following code on the reset page: </p>

	<h1 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 30pt; color: #777777;">{{$user->secret_token}}</h1>

	<p>If you don't have the reset page open anymore, <a href="{{url('/')}}/#!change">click here</a>.</p>

	<p>Thank you,</p>

@stop