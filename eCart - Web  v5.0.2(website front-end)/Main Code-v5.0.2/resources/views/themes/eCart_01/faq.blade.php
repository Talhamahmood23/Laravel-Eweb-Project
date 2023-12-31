<div class="section-content footerfix mt-5 faq_sec">
  <a href="#" id="scroll"><span></span></a>
  <div class="container padding-bottom">
    <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-uppercase text-center license">{{__('msg.Regular & Extended Licenses')}}</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 center-col">
          <!-- faq content -->
          <div class="panel-group faq-content" id="faq-one">
            <!-- faq item -->
            @if(count($data['faq']))
            @foreach($data['faq'] as $faq)
            <div class="panel">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#faq-{{ $faq->id }}" href="#faq-{{ $faq->id }}" class="collapsed" aria-expanded="false">
                  <div class="panel-title  text-uppercase ">{{ $faq->question }}<span class="pull-right "><i class="fas fa-plus"></i></span></div>
                </a>
              </div>
              <div id="faq-{{ $faq->id }}" class="panel-collapse collapse">
                <div class="panel-body">
                  {{ $faq->answer }}
                </div>
              </div>
            </div>
            @endforeach
            @else
            <!-- end faq item -->
            <div class="row text-center">
              <div class="col-12">
                <br><br>
                <h3>{{__('msg.no_faq_found')}}.</h3>
              </div>
              <div class="col-12">
                <br><br>
                <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>
                  {{__('msg.continue_shopping')}}
                </a>
              </div>
            </div>
            @endif
            <!-- end faq item -->
          </div>
          <!-- end faq -->
        </div>
      </div>
    </div>
  </div>
</div>