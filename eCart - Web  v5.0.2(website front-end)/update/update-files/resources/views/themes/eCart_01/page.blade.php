<section class="footerfix section-content mt-5 common__sec">
    <a href="#" id="scroll"><span></span></a>
    <div class="container padding-bottom">
        <div class="card p-3">
            <h3>{{ $data['title'] }}</h3>
            <p>
                {!! $data['content'] !!}
            </p>
        </div>
        <br><br>
        <a href="javascript: history.back()" class="btn btn-primary go__back"> « {{__('msg.go_back')}}</a>
    </div>
</section>
