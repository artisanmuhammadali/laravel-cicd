<div class="bottom-nav-support-div"></div>
<nav class="bottom-nav d-block d-md-none bg_dark_shark">
  <div class="bottom-nav-box">
    <ul class="bottom-nav-container p-0 m-0">
      <li class="bottom-nav-item" title="Home">
        <a href="{{route('index')}}" class="bottom-nav-item-link">
          <div class="bottom-nav-item-icon">
          <i class="fa fa-home" aria-hidden="true"></i>
          </div>
          <span class="bottom-nav-item-text">Home</span>
        </a>
      </li>
      @if(auth()->user())
      <li class="bottom-nav-item" title="Account">
        <a href="{{route('user.account')}}" class="bottom-nav-item-link">
          <div class="bottom-nav-item-icon">
          <i class="fa fa-user" aria-hidden="true"></i>
          </div>
          <span class="bottom-nav-item-text">Account</span>
        </a>
      </li>
      @if(Auth::user() && Auth::user()->role != "admin")
      <li class="bottom-nav-item" title="Cart">
        <a href="{{route('cart.index')}}" class="bottom-nav-item-link">
          <div class="bottom-nav-item-icon">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span class="position-absolute top-1 translate-middle badge rounded-pill cart-span fs-bread py-1 px-2">{{getUserCart(auth()->user()->id,'count')}}</span>
          </div>
          <span class="bottom-nav-item-text">Cart</span>
        </a>
      </li>
      @endif
      @else
      <li class="bottom-nav-item" title="Register">
        <a href="#" class="bottom-nav-item-link open_register_modal" data-bs-toggle="modal" data-bs-target="#registerModal" onclick="loadRecaptcha()">
          <div class="bottom-nav-item-icon">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
          </div>
          <span class="bottom-nav-item-text">Register</span>
        </a>
      </li>
      <li class="bottom-nav-item" title="Login">
        <a href="#" class="bottom-nav-item-link open_register_modal" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="loadRecaptcha()">
          <div class="bottom-nav-item-icon">
          <i class="fa fa-sign-in" aria-hidden="true"></i>
          </div>
          <span class="bottom-nav-item-text">Login</span>
        </a>
      </li>
      @endif
      <li class="bottom-nav-item" title="Product Ranges">
        <a href="#" class="bottom-nav-item-link" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="bottom-nav-item-icon">
            <i class="fa fa-window-maximize fa-rotate-270" aria-hidden="true"></i>
            </div>
        </a>
        <ul class="dropdown-menu bg_dark_shark" aria-labelledby="dropdownMenuButton3" data-popper-placement="top-end">
            <li>
                <p class="text-secondary mb-0 ps-2 small">Product Ranges</p>
            </li>
            <li>
              <a class="dropdown-item text-white text-capitalize text-ranges-hover" href="{{route('mtg.index')}}">Magic The Gathering</a>
              <ul class="ms-2 text-white">
                <li><a class="dropdown-item text-white text-capitalize small text-ranges-hover" href="{{route('mtg.expansion.index')}}">View All Expansions</a></li>
                <li><a class="dropdown-item text-white text-capitalize small text-ranges-hover" href="{{route('mtg.marketplace','single-cards')}}">View All Products</a></li>
              </ul>
            </li>
            <li><a class="dropdown-item text-white fw-bolder text-capitalize text-ranges-hover"  href="{{route('sw.index')}}">Star Wars Unlimited</a></li>
            <li><a class="dropdown-item text-secondary fw-bolder text-capitalize disabled" href="#">Flesh And Blood</a></li>
        </ul>
      </li>
      <li class="bottom-nav-item dropdown bottom-toggle-menu" title="Usefull Links">
        <a href="#" class="bottom-nav-item-link" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="bottom-nav-item-icon">
              <i class="fa fa-newspaper" aria-hidden="true"></i>
            </div>
        </a>
        <ul class="dropdown-menu bg_dark_shark" aria-labelledby="dropdownMenuButton2" data-popper-placement="top-end">
            <li>
                <p class="text-secondary mb-0 ps-2 small">Very Friendly Sharks</p>
                <ul class="list-unstyled">
                    @foreach(getPages('Very Friendly Sharks') as $page)
                        <li><a class="dropdown-item text-white text-capitalize text-ranges-hover" href="{{route('page',$page->slug)}}">{{$page->short_name}}</a></li>
                    @endforeach
                    <li><a class="dropdown-item text-white text-capitalize text-ranges-hover" href="{{route('help')}}">Help</a></li>
                </ul>
            </li>
            <li>
                <p class="text-secondary mb-0 ps-2 small">Customer Resources</p>
                <ul class="list-unstyled">
                    @foreach(getPages('Customer Resources') as $page)
                        <li><a class="dropdown-item text-white text-capitalize text-ranges-hover" href="{{route('page',$page->slug)}}">{{$page->short_name}}</a></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <p class="text-secondary mb-0 ps-2 small">Other Links</p>
                <ul class="list-unstyled">
                    @foreach(getPages('Other Links') as $page)
                    <li><a class="dropdown-item text-white text-capitalize text-ranges-hover" href="{{route('page',$page->slug)}}">{{$page->short_name}}</a></li>
                    @endforeach
                    <li><a class="dropdown-item text-white text-capitalize text-ranges-hover" href="{{route('faqs')}}">FAQs</a></li>
                    {{-- <li><a class="dropdown-item text-white text-capitalize text-ranges-hover" href="{{route('seller.program')}}">Seller Program</a></li> --}}
                </ul>
            </li>
        </ul>
      </li>
      @if(auth()->user())
      <li class="bottom-nav-item" title="Logout">
        <a href="{{route('user.account')}}" class="bottom-nav-item-link">
          <div class="bottom-nav-item-icon">
            <form class="d-flex justify-content-center" method="POST" action="{{route('logout')}}">
                        @csrf
                <button class="bottom-nav-item-link btn p-0 fs-1"  type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i></button>
            </form>
          </div>
          <span class="bottom-nav-item-text">Logout</span>
        </a>
      </li>
      @endif
    </ul>
  </div>
</nav>