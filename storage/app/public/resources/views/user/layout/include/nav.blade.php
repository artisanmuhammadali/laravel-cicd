
<section>
    <div class="row bg-site-primary m-0">
        <div class="col-12 p-0">
            @include('user.layout.include.header')
            <div class="nav-border w-100"></div>
            <div class="container pt-1">
                <div class="row">
                    <div class="col-12">
                        <div class="row d-flex justify-content-between">
                            <div class="  col-md-4 col-7 d-flex ">
                                <form class="d-flex">
                                    <div class="input-group mb-1 border site-border-color rounded-1">
                                        <input type="text"
                                            class="form-control input-padding bg-transparent text-white border-0 general_search_input"
                                            data-url="{{route('mtg.general.search')}}"
                                            aria-label="Text input with dropdown button">
                                        <span class="nav-vertical-bar my-auto d-md-block d-none">|</span>
                                        <a href="{{route('mtg.detailedSearch')}}"
                                            class="btn d-md-block d-none fw-lighter md-text input-padding nav-light-text bg-transparent border-0"
                                            type="button">
                                            Detailed Search
                                            <img class="mr-3" src="{{asset('images/nav-bar/32-filterOff.svg')}}"
                                                width="20">
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class=" col-md-5 col-5  d-flex   justify-content-end">
                                <div class="d-md-block d-none me-4">
                                    <a href="{{route('mtg.expansion.index')}}"
                                        class="btn nav-light-text pe-0 md-text  fw-lighter">Select Expansion</a>
                                </div>
                                <div class="dropdown col-4  col-md-3">
                                    <a href="#" class="btn  border site-border-color" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img class="w-100  d-md-block d-none"
                                            src="{{asset('images/banner/MTG_Primary_LL_4c_White_XL_V12.png')}}" alt="">
                                        <img class="d-md-none d-block" src="{{asset('images/nav-bar/Bitmap.png')}}"
                                            alt="">
                                    </a>
                                    <ul class="dropdown-menu bg-black" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item hover-ini" href="{{route('mtg.index')}}"><img
                                                    class="w-100 px-1 mb-1"
                                                    src="{{asset('images/banner/MTG_Primary_LL_4c_White_XL_V12.png')}}"
                                                    alt=""></a></li>
                                        <li><a href="" class="dropdown-item disabled " tabindex="-1" role="button"
                                                aria-disabled="true"><img class="w-100 px-1 mb-1"
                                                    src="{{asset('images/banner/logo-pokemon.png')}}" alt=""></a></li>
                                        <li><a href="" class="dropdown-item disabled" tabindex="-1" role="button"
                                                aria-disabled="true"><img class=" w-100 px-1 mb-1"
                                                    src="{{asset('images/banner/logo-fab.png')}}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <div class="search_tab_block">
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
