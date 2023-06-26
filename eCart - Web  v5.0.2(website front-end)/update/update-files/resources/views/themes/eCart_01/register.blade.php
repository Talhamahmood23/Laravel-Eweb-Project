<section class="footerfix section-content mt-5 padding-bottom">
    <div class="container">
        <div class="card mx-auto register-card">
            <article class="card-body">
                <header class="mb-4"><h4 class="card-title">{{__('msg.sign_up')}}</h4></header>
                <form method='POST' id='registerForm'>
                    @csrf
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="auth_uid" value="{{ $data['auth_uid'] }}">
                    <input type="hidden" name="mobile" value="{{ $data['mobile'] }}">
                    <input type="hidden" name="country" value="{{ $data['country'] }}">
                    <div class="form-group">
                        <div class="alert alert-danger error-hide" id="registerError"></div>
                    </div>
                    <div class="form-row">
                        <div class="col form-group">
                            <label>{{__('msg.full_name')}}</label>
                            <input type="text" name='display_name' class="form-control" value='{{ $data['display_name'] }}' required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__('msg.email')}}</label>
                        <input type="email" class="form-control" name='email' placeholder="" value='{{ $data['email'] }}' required>
                        <small class="form-text text-muted">{{__('msg.we_will_never_share_you_email_with_anyone_else')}}.</small>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>{{__('msg.mobile')}}</label>
                            <input type="text" class="form-control" name='mobile' placeholder="" value='{{ $data['mobile'] }}' readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>{{__('msg.create_password')}}</label>
                            <input class="form-control" name='password' type="password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('msg.repeat_password')}}</label>
                            <input class="form-control" name='password_confirmation' type="password" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>{{__('msg.referral_code')}}</label>
                            <input class="form-control" name='friends_code' type="text" value='{{ $data['friends_code'] }}'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" required> <div class="custom-control-label"> {{__('msg.I am agree with')}} <a href="{{ route('page', 'tnc') }}" target="_blank">{{__('msg.terms and contitions')}}</a>  </div> </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> {{__('msg.register')}}  </button>
                    </div>
                    <p class="text-center mt-4">{{__('msg.have_an_account')}} <a href="{{ route('login') }}">{{__('msg.log_in')}}</a></p>
                </form>
            </article>
        </div>
    </div>
</section>

<script src="{{ asset('js/register.js') }}"></script>
