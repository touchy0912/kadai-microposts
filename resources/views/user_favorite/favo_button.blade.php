

@if(Auth::user()->is_favorite($micropost->id))

{!! Form::open(['route'=>['user.unfavo',$micropost->id],'method'=>'delete']) !!}
{!! Form::button('<span class="glyphicon glyphicon-star"></span>' , array('class'=>'btn btn-warning btn-xs','type'=>'submit')) !!}
{!! Form::close() !!}


@else

{!! Form::open(['route'=>['user.favo',$micropost->id]]) !!}
{!! Form::button('<span class="glyphicon glyphicon-star-empty"></span>' , array('class'=>'btn btn-default btn-xs','type'=>'submit')) !!}
{!! Form::close() !!}

@endif

