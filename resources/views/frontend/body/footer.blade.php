@php
    $footer = App\Models\Footer::find(1);
@endphp


<footer class="footer">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-4">
                <div class="footer__widget">
                    <div class="fw-title">
                        <h5 class="sub-title">Contact us</h5>
                        <h4 class="title">{{ $footer->number }}</h4>
                    </div>
                    <div class="footer__widget__text">
                        <p>{{ $footer->short_description }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="footer__widget">
                    <div class="fw-title">
                        <h5 class="sub-title">my address</h5>
                        <h4 class="title">{{ $footer->address }}</h4>
                    </div>
                    <div class="footer__widget__address">

                        <a href="mailto:{{ $footer->email }}" class="mail">{{ $footer->email }}</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="copyright__wrap">
            <div class="row">
                <div class="col-12">
                    <div class="copyright__text text-center">
                        <p>{{ $footer->copyright }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
