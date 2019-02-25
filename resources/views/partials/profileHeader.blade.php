<div class="row">
    <div class="profile box">
        <div class="profile-header text-center">
            <div class="profile-img text-center">
                <img class="img-responsive img-circle m-auto"
                     src="@if (!empty($user->mini_profile_picture_link)) {{ asset( $user->profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
            </div>
        </div>
        <div class="profile-info text-center">
            <h3>{{ $user->name }}</h3>
            <h3>Elite Points: {{ $user->elite_points }}</h3>
            <p>Email: {{ $user->email }}</p>
        </div>
    </div>
</div>