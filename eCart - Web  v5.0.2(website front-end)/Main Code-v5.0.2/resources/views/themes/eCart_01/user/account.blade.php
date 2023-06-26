<section class="section-content padding-bottom ">
    <!--user address-->
    <a href="#" id="scroll"><span></span></a>
    <div class="page_title corner-title overflow-visible">
        <ol class="breadcrumb">
            <li class=" item-1"></li>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('msg.home')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('msg.my_account')}}</li>
        </ol>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-4">
               @include("themes.".get('theme').".user.sidebar")
            </div>
            <main class="col-xl-8 col-lg-6 col-md-6 col-12">
                <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mt-3 mt-md-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <form method='POST' enctype="multipart/form-data" id="profile_form">
                                   @csrf
                                    <div class="form-row reward_profile">
                                        <div class="col">
                                            <div class="reward-body-dtt">
                                                <div class="reward-img-icon">
                                                    <img id="user_profile" src="{{ $data['profile']['profile'] }}" alt="User">
                                                    <div class="img-add">
                                                        <input type="file" name="profile" accept="image/*" id="file" />
                                                        <label for="file"><i class="fas fa-camera"></i></label>
                                                        <input type="text" class="form-control" disabled placeholder="Upload File" id="file1" hidden>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col form-group">
                                            <label>{{__('msg.name')}}</label>
                                            <input type="text" name="name" class="form-control" value="{{ $data['profile']['name'] }}" required>
                                            <input type="hidden" name="token" class="form-control" value="{{ $data['token'] }}" required>
                                            <br/>
                                            <label>{{__('msg.email')}}</label>
                                            <input type="email" name="email" value="{{ $data['profile']['email'] }}" class="form-control">
                                            <br/>
                                            <label>{{__('msg.mobile')}}</label>
                                            <input type="text" value="{{ $data['profile']['mobile'] }}" class="form-control" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="form-group">
										<input type="hidden" value="{{ $data['profile']['user_id'] }}" class="form-control" name="id">
                                        <button type="submit" name="submit" value="submit" id="submit_btn" class="btn btn-primary btn-block mt-4">{{__('msg.update')}} </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!--end user address-->
</section>

