<section class="section-content padding-bottom password__change">
    <a href="#" id="scroll"><span></span></a>
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-4">
               @include("themes.".get('theme').".user.sidebar")
            </div>
            <main class="col-xl-8 col-lg-6 col-md-6 col-12 mt-sm-3 mt-3 mt-md-0">
                <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <form method='POST'>
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label>{{__('msg.old_password')}}</label>
                                            <input class="form-control" name="current_password" type="password">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label>{{__('msg.new_password')}}</label>
                                            <input class="form-control" type="password" name="new_password">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label>{{__('msg.confirm_new_password')}}</label>
                                            <input class="form-control" type="password" name="new_password_confirmation">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block mt-4"> {{__('msg.change_password')}} </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>