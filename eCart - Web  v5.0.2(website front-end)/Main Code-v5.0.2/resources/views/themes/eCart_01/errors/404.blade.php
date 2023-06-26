

<div class="error_page my-3">
    <div class="container justify-content-center align-items-center d-flex text-center">
        <div class="inner_error_page ">
            <div class="error_image">
                <img src="{{URL::asset('images/404.webp')}}" alt="404" >
            </div>
            <div class="error_title">
                <h3 class="my-2">Oops! You're lost...</h3>
                <p>The page you are looking for might have been moved, renamed, or might never existed.</p>
            </div>
            <div class="back_home my-2">
                <a href="{{route('home')}}" class="btn btn-primary">Back Home</a>
            </div>
        </div>
    </div>
</div>
