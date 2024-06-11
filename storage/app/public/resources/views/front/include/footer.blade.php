
<div class="row">
    <div class="col-12 d-flex justify-content-center">
            <a href="{{route('index')}}"><img loading="lazy" alt="logo" src="{{$setting['logo'] ?? ""}}" width="150"></a>
    </div>
</div>
<hr class="hr-footer nav-vertical-bar">
<div class="row flex-md-row flex-column-reverse justify-content-between">
    <div class="col-md-4  justify-content-center">
        <div class="ftco-footer-widget mb-4 ml-md-5 text-md-start text-center">
            <h4 class="ftco-heading-2 text-white">Copyright Disclaimers</h4>
            <div class="row">
                <p class="mb-0 footer_copy text-white-50 text-justify">{{$setting['bottom_note'] ?? ''}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 d-flex justify-content-center">
        <div class="ftco-footer-widget mb-4 ml-md-5 text-md-start text-center">
            <h4 class="ftco-heading-2 text-white">Very Friendly Sharks</h4>
            <ul class="list-unstyled">
                @foreach(getPages('Very Friendly Sharks') as $page)
                <li ><a href="{{route('page',$page->slug)}}" class=" d-block text-decoration-none text-white-50 text-primary-hover">{{$page->short_name}}</a></li>
                @endforeach
                <li ><a href="{{route('help')}}" class=" d-block text-decoration-none text-white-50 text-primary-hover" title="Help Page">Help</a></li>

            </ul>
        </div>
    </div>
    <div class="col-md-2 d-flex justify-content-center">
        <div class="ftco-footer-widget mb-4 ml-md-5 text-md-start text-center">
            <h4 class="ftco-heading-2 text-white">Customer Resources</h4>
            <ul class="list-unstyled">
                @foreach(getPages('Customer Resources') as $page)
                <li ><a href="{{route('page',$page->slug)}}" class=" d-block text-decoration-none text-white-50 text-primary-hover">{{$page->short_name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-2 d-flex justify-content-center">
        <div class="ftco-footer-widget mb-4 ml-md-5 text-md-start text-center">
            <h4 class="ftco-heading-2 text-white">Other Links</h4>
            <ul class="list-unstyled">
                @foreach(getPages('Other Links') as $page)
                <li ><a href="{{route('page',$page->slug)}}" class=" d-block text-decoration-none text-white-50 text-primary-hover">{{$page->short_name}}</a></li>
                @endforeach
                <li ><a href="{{route('faqs')}}" class=" d-block text-decoration-none text-white-50 text-primary-hover" title="Frequently Asked Questions Page">FAQs</a></li>
                {{-- <li ><a href="{{route('seller.program')}}" class=" d-block text-decoration-none text-white-50 text-primary-hover" title="Frequently Asked Questions Page">Seller Program</a></li> --}}
            </ul>
        </div>
    </div>
    
</div>
<hr class="hr-footer nav-vertical-bar"hr>
<div class="row align-items-center flex-md-row flex-column-reverse">
    <div class="col-lg-4 col-12 d-flex justify-content-md-start justify-content-center mt-md-0 mt-2">
        <div class=" Copyright-Very-Fr text-white">
            <p class="mb-0">© 2021 - {{now()->format('Y')}} <span id="copyrightText"></span> {{$setting['copyright_text'] ?? ''}}</p>
        </div>
    </div>
    <div class="col-lg-4 col-12 d-flex justify-content-center">
        <a class="" target="_blank" href="https://mangopay.com" >
            <img class="filter_mango" width="100px" src="{{asset('images/banner/logo/mangopay_powered-a790a355.svg')}}" alt="">
        </a>
    </div>
    <div class="col-lg-4 col-12 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3 p-1 mt-user-fix">
        <ul class="ftco-footer-social list-unstyled mb-2 mb-user-fix d-flex">
            <li class="ftco-animate me-md-3 user_mr-fix me-0 px-1">
                <a class="border-site-dark" target="blank" href="{{$setting['facebook'] ?? ''}}" >
                    <i class="fa-brands fa-facebook fs-3 text-white"></i>
                </a>
            </li>
            <li class="ftco-animate  me-md-3 user_mr-fix me-0 px-1">
                <a class="border-site-dark" target="blank" href="{{$setting['instagram'] ?? ''}}" >
                <i class="fa-brands fa-instagram fs-3"></i>
                </a>
            </li>
            <li class="ftco-animate me-md-3 user_mr-fix me-0 px-1">
                <a class="border-site-dark" target="blank" href="{{$setting['discord'] ?? ''}}" >
                <i class="fa-brands fa-threads fs-3 text-white"></i>
                </a>
            </li>
            <li class="ftco-animate me-md-3 user_mr-fix me-0 px-1">
                <a class="border-site-dark" target="blank" class="" href="{{$setting['twitter'] ?? ''}}">
                    <i class="fa-brands fa-square-x-twitter fs-3  text-white"></i>
                </a>
            </li>
            <li class="ftco-animate me-md-3  user_mr-fix me-0 px-1">
                <a class="border-site-dark" target="blank" href="{{$setting['youtube'] ?? ''}}">
                    <i class="fa-brands fa-youtube fs-3"></i>
                </a>
            </li>
            <li class="ftco-animate me-md-3 user_mr-fix me-0 px-1">
                <a class="border-site-dark" target="blank" href="https://discord.com/invite/N292fZM7ez">
                    <img loading="lazy" class="img-invert" src="{{asset('images/nav-bar/discrod.png')}}" width="30" alt="discord">
                </a>
            </li>
        </ul>
    </div>
</div>