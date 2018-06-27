<ul class='media-list'>
    @foreach($microposts as $micropost)
    <?php $user=$micropost->user; ?>
    <li class='media'>
        <div class='media-left'>
            <img class='media-object img-rounded' src="{{Gravatar::src($user->email , 50)}}", alt=''>
        </div>
        <div class='media-body'>
            <div>
                {!! link_to_route('users.show',$user->name,['id'=>$user->id]) !!}<span class='text-muted'>posted at {{$micropost->created_at}}</span>
            </div>
            <div>
                <p>{!! nl2br(e($micropost->content)) !!}</p>
            </div>
                <div class='row'>
                    <span class='col-xs-1'>
                @include('user_favorite.favo_button',['micropost'=>$micropost])
                </span>
              <span class='col-xs-1'>
                @if(Auth::id()==$micropost->user_id)
                {!! Form::open(['route'=>['microposts.destroy',$micropost->id],'method'=>'delete']) !!}
                {!! Form::button('<span class="glyphicon glyphicon-trash"></span>' , array('class'=>'btn btn-basic btn-xs','type'=>'submit')) !!}
                {!! Form::close() !!}
                @endif
            </span>
            </div>
            
        </div>
        
    </li>
    @endforeach
    
</ul>

{!! $microposts->render() !!}