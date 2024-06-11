<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('index') }}">
                    <span
                        class="brand-logo">
                    </span>
                    <img src="{{$setting['favicon'] ?? ''}}" style="width:38px">
                    <h2 class="brand-text" style="margin-top:0px">VFS</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="@if(url()->current() == route('admin.dashboard')) active @endif nav-item"><a
                    class="d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <i data-feather="home"></i>Dashboard</a>
            </li>
            @can('Users')
            <li class="  nav-item">
                <a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>Users</a>
                <ul class="menu-content">
                    @can('Users_List')
                    <li class="@if(url()->current() == route('admin.user.list')) active @endif nav-item"><a
                            class="d-flex align-items-center" href="{{ route('admin.user.list') }}">
                            <i data-feather="circle"></i>List</a>
                    </li>
                    @endcan
                    {{--<li class="@if(url()->current() == route('admin.dispute.users')) active @endif nav-item"><a
                            class="d-flex align-items-center" href="{{ route('admin.dispute.users') }}">
                            <i data-feather="circle"></i>Dispute Users</a>
                    </li>
                    <li class="@if(url()->current() == route('admin.user.cancel.orders')) active @endif nav-item"><a
                            class="d-flex align-items-center" href="{{ route('admin.user.cancel.orders') }}">
                            <i data-feather="circle"></i>Cancel Order Users</a>
                    </li>
                    <li class="@if(url()->current() == route('admin.user.cancel.orders')) active @endif nav-item"><a
                            class="d-flex align-items-center" href="{{ route('admin.user.cancel.orders') }}">
                            <i data-feather="circle"></i>Reviews</a>
                    </li> --}}
                    @can('Users_Status')
                    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i>Status</a>
                        <ul class="menu-content">
                            @foreach(userStatuses() as $status)
                            <li class="@if(url()->current() == route('admin.user.status', $status)) active @endif">
                                <a class="d-flex align-items-center text-capitalize" href="{{ route('admin.user.status', $status) }}">
                                    <i data-feather="circle"></i> {{$status == 'ban' ? 'banned' : $status}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endcan
                    @can('Referral_Users')
                    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i>Referral Users</a>
                        <ul class="menu-content">
                            @foreach(userReferalTypes() as $referalType)
                            <li class="@if(url()->current() == route('admin.user.list', $referalType)) active @endif">
                                <a class="d-flex align-items-center text-capitalize" href="{{ route('admin.user.list', $referalType) }}">
                                    <i data-feather="circle"></i> {{$referalType}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('MTG')
            <li class="  nav-item"><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>MTG</a>
                <ul class="menu-content">
                    @can('Mtg_Set')
                    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i>Sets</a>
                        <ul class="menu-content">
                            <li class="@if(url()->current() == route('admin.mtg.sets.index', 'expansion')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.sets.index', 'expansion') }}"><i
                                        data-feather="circle"></i> Expansion</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.sets.index', 'special')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.sets.index', 'special') }}"><i
                                        data-feather="circle"></i> Special Sets</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.sets.index', 'child')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.sets.index', 'child') }}"><i
                                        data-feather="circle"></i> Child Sets</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.sets.index', 'new_arrival')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.sets.index', 'new_arrival') }}"><i
                                        data-feather="circle"></i> New Arrival Sets</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.standard.set.index')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.standard.set.index') }}"><i
                                        data-feather="circle"></i> Standard Sets</a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    @can('Mtg_Products')
                    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i>Products</a>
                        <ul class="menu-content">
                            <li class="@if(url()->current() == route('admin.mtg.products.index', 'sealed')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.products.index', 'sealed') }}"><i
                                        data-feather="circle"></i> Sealed</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.products.index', 'completed')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.products.index', 'completed') }}"><i
                                    data-feather="circle"></i> Complete</a>
                            <li class="@if(url()->current() == route('admin.mtg.products.index', 'single')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.products.index', 'single') }}"><i
                                    data-feather="circle"></i> Single</a>
                            </li>
                            <li class=" nav-item" style="margin: 0px 0px;"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i>New Arrival</a>
                                <ul class="menu-content">
                                    <li class="@if(url()->current() == route('admin.mtg.products.index', ['sealed','new_arrival'])) active @endif"><a
                                            class="d-flex align-items-center" href="{{ route('admin.mtg.products.index', ['sealed','new_arrival']) }}"><i
                                                data-feather="circle"></i> Sealed</a>
                                    </li>
                                    <li class="@if(url()->current() == route('admin.mtg.products.index', ['completed','new_arrival'])) active @endif"><a
                                        class="d-flex align-items-center" href="{{ route('admin.mtg.products.index', ['completed','new_arrival']) }}"><i
                                            data-feather="circle"></i> Complete</a>
                                </ul>
                            </li>
                            {{--<li class="@if(url()->current() == route('admin.mtg.products.index', 'new_arrival')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.products.index', 'new_arrival') }}"><i
                                    data-feather="circle"></i> New Arrival</a>
                            </li>--}}
                        </ul>
                    </li>
                    @endcan
                    @can('Settings_Attributes')
                    <li class="@if(url()->current() == route('admin.mtg.attributes.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.attributes.index') }}"><i
                                data-feather="circle"></i> Attributes</a>
                    </li>
                    @endcan
                    @can('Mtg_Apply_Attributes')
                    <li class="@if(url()->current() == route('admin.mtg.cards.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.cards.index', 'child') }}"><i
                                data-feather="circle"></i> Apply Attributes</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            {{-- SW-start  --}}
            <li>
                <li class="  nav-item"><a class="d-flex align-items-center" href="#"><i
                    data-feather="circle"></i>SW</a>
                    <ul class="menu-content">
                        <li class="@if(url()->current() == route('admin.mtg.products.index', 'sealed')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.sw.expansion.index') }}"><i
                                data-feather="circle"></i> Expansion</a>
                        </li>
                        <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i>Products</a>
                            <ul class="menu-content">
                                <li class="@if(url()->current() == route('admin.sw.products.index', 'single')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.sw.products.index', 'single') }}"><i
                                        data-feather="circle"></i>Single</a>
                                </li>
                                <li class="@if(url()->current() == route('admin.sw.products.index', 'sealed')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.sw.products.index', 'sealed') }}"><i
                                        data-feather="circle"></i>Sealed</a>
                                </li>
                                <li class="@if(url()->current() == route('admin.sw.products.index', 'completed')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.sw.products.index', 'completed') }}"><i
                                        data-feather="circle"></i>Completed</a>
                                </li>
                            </ul>
                        </li>
                        @can('Settings_Attributes')
                        <li class="@if(url()->current() == route('admin.sw.attributes.index')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.sw.attributes.index') }}"><i
                                    data-feather="circle"></i> Attributes</a>
                        </li>
                        @endcan
                    </ul>
                </li>
            </li>
            {{-- end-starwar  --}}
            @can('CMS')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>CMS</a>
                <ul class="menu-content">
                    @can('Cms_General')
                    <li class="@if(url()->current() == route('admin.mtg.cms.setting','general')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.cms.setting', 'general') }}"><i
                                data-feather="circle"></i> General</a>
                    </li>
                    @endcan
                    @can('Cms_Pages')
                    <li class="@if(url()->current() == route('admin.mtg.cms.pages.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.cms.pages.index') }}"><i
                                data-feather="circle"></i> Pages</a>
                    </li>
                    @endcan
                    <li class="@if(url()->current() == route('admin.mtg.cms.templates.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.cms.templates.index') }}"><i
                                data-feather="circle"></i> Templates</a>
                    </li> 
                    @can('Cms_Faqs')
                    <li class="@if(url()->current() == route('admin.mtg.cms.faqs.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.cms.faqs.index', 'general') }}"><i
                                data-feather="circle"></i> FAQs</a>
                    </li>
                    @endcan
                    @can('Cms_Faqs_Category')
                    <li class="@if(url()->current() == route('admin.mtg.cms.faq_categories.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.cms.faq_categories.index', 'general') }}"><i
                                data-feather="circle"></i> FAQs Categories</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            {{--@can('Help')
            <li class=" "><a class="d-flex align-items-center" href="#"><i data-feather='settings'></i>Help</a>
                <ul class="menu-content">
                    <li class="@if(url()->current() == route('admin.help')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.help') }}"><i
                                data-feather="circle"></i> List</a>
                    </li>
                </ul>
            </li>
            @endcan--}}
            @can('Redirect')
            <li class="@if(url()->current() == route('admin.redirect.index')) active @endif nav-item"><a
                    class="d-flex align-items-center" href="{{ route('admin.redirect.index') }}">
                    <i data-feather="circle"></i>Redirect</a>
            </li>
            @endcan
            @can('Settings')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>Settings</a>
                <ul class="menu-content">
                   
                    @can('Settings_Custom_Type')
                    <li class="@if(url()->current() == route('admin.mtg.custom-type.index')) active @endif">
                        <a class="d-flex align-items-center" href="{{ route('admin.mtg.custom-type.index') }}">
                            <i data-feather="circle"></i> Custom Type
                        </a>
                    </li>
                    @endcan
                    @can('Settings_Referral_Type')
                    <li class="@if(url()->current() == route('admin.user.referral.index')) active @endif">
                        <a class="d-flex align-items-center" href="{{ route('admin.user.referral.index') }}">
                            <i data-feather="circle"></i> Referral Type
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('PSP')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>PsP</a>
                <ul class="menu-content">
                    {{--<li class="@if(url()->current() == route('admin.psp.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.psp.index') }}"><i
                                data-feather="circle"></i> General Setting</a>
                    </li>--}}
                    @can('Psp_Postage')
                    <li class="@if(url()->current() == route('admin.postage.index')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.postage.index') }}"><i
                                data-feather="circle"></i> Postage</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('Accounts')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>Accounts</a>
                <ul class="menu-content">
                    @can('Account_withdraw')
                    <li class="@if(url()->current() == route('admin.account.withdraw.index')) active @endif nav-item"><a
                            class="d-flex align-items-center" href="{{ route('admin.account.withdraw.index') }}">
                            <i data-feather="circle"></i>Withdraw</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('CRM')
            <li class=" ">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>CRM
                </a>
                <ul class="menu-content">
                    @can('Crm_Users')
                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="file-text"></i>Users
                        </a>
                        <ul class="menu-content">
                            <li class="@if(url()->current() == route('admin.mtg.crm.site.visit')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.crm.site.visit') }}"><i
                                    data-feather="circle"></i> Site Visitors</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.account.registrations')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.crm.account.registrations') }}"><i
                                        data-feather="circle"></i>Registrations</a>
                            </li>
                            <!-- <li class="@if(url()->current() == route('admin.mtg.crm.accounts.deleted')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.crm.accounts.deleted') }}"><i
                                        data-feather="circle"></i> Del Accounts</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.accounts.deleted.list')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.crm.accounts.deleted.list') }}"><i
                                        data-feather="circle"></i> Deleted List</a>
                            </li> -->
                            <li class="@if(url()->current() == route('admin.mtg.crm.dispute.users.list')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.crm.dispute.users.list') }}"><i
                                        data-feather="circle"></i> Dispute Users</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.order.cancel.users.list')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.crm.order.cancel.users.list') }}"><i
                                        data-feather="circle"></i> Cancel Order</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.protection.users.list')) active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('admin.mtg.crm.protection.users.list') }}"><i
                                        data-feather="circle"></i> Protection Users</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.seller.to.buyer')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.crm.seller.to.buyer') }}"><i
                                        data-feather="circle"></i> Seller To Buyer</a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.collection.listing')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.crm.collection.listing') }}"><i
                                        data-feather="circle"></i> Collection</a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    @can('Crm_Orders')
                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="file-text"></i>Orders
                        </a>
                        <ul class="menu-content">
                            <li class="@if(url()->current() == route('admin.mtg.crm.orders')) active @endif">
                                <a class="d-flex align-items-center" href="{{ route('admin.mtg.crm.orders') }}">
                                    <i data-feather="circle"></i>Analytics
                                </a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.success.checkout')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.crm.success.checkout') }}"><i
                                        data-feather="circle"></i>Checkouts </a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.reviews.users.list')) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.mtg.crm.reviews.users.list') }}"><i
                                        data-feather="circle"></i> Reviews</a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    @can('Crm_Transactions')
                    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i>Transactions</a>
                        <ul class="menu-content">
                            <li class="@if(url()->current() == route('admin.mtg.crm.buyer.spending')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.crm.buyer.spending') }}"><i
                                data-feather="circle"></i>Buyer Spending </a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.seller.earning')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.crm.seller.earning') }}"><i
                                    data-feather="circle"></i>Seller Earning </a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.transactions')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.crm.transactions') }}"><i
                                    data-feather="circle"></i>Transactions </a>
                            </li>
                            <li class="@if(url()->current() == route('admin.mtg.crm.revenue')) active @endif"><a
                                class="d-flex align-items-center" href="{{ route('admin.mtg.crm.revenue') }}"><i
                                    data-feather="circle"></i>Revenue </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('Orders')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>Orders List</a>
                <ul class="menu-content">
                    @can('Order_List')
                    <li class="@if(url()->current() == route('admin.orders.index',['pending'])) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.orders.index',['pending']) }}"><i
                                data-feather="circle"></i>List</a>
                    </li>
                    @endcan
                    @can('Dispute_Orders')
                    <li class="@if(url()->current() == route('admin.orders.index',['dispute-orders'])) active @endif"><a
                            class="d-flex align-items-center" href="{{ route('admin.orders.index',['dispute-orders']) }}"><i
                                data-feather="circle"></i>Dispute Orders</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            {{--@can('CRM')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>CRM</a>
                <ul class="menu-content">
                    <li class="@if(url()->current() == route('admin.transaction.list')) active @endif nav-item"><a
                            class="d-flex align-items-center" href="{{ route('admin.transaction.list') }}">
                            <i data-feather='dollar-sign'></i>Transactions</a>
                    </li>
                </ul>
            </li>
            @endcan--}}
            @can('Authorization')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>Authorization</a>
                <ul class="menu-content">
                    <li class="nav-item @if(Route::is('admin.roles.index')) active @endif">
                        <a href="{{ route('admin.roles.index') }}"><i data-feather='zap'></i>Roles</a>
                    </li>
                    <li class="nav-item @if(Route::is('admin.teams.index')) active @endif">
                        <a href="{{ route('admin.teams.index') }}"><i data-feather='user'></i>Admins</a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('Marketing_Email')
            <li class=" "><a class="d-flex align-items-center" href="#"><i
                                    data-feather="circle"></i>Marketing Email</a>
                <ul class="menu-content">
                    <li class="nav-item @if(Route::is('admin.marketing.email')) active @endif">
                        <a href="{{ route('admin.marketing.email') }}"><i data-feather='mail'></i>Email</a>
                    </li>
                    <li class="nav-item @if(Route::is('admin.marketing.list')) active @endif">
                        <a href="{{ route('admin.marketing.list') }}"><i data-feather='mail'></i>Email Logs</a>
                    </li>
                </ul>
            </li>
            @endcan
            <!-- @can('Chat')
            <li class="@if(url()->current() == route('admin.mtg.chat')) active @endif nav-item"><a
                    class="d-flex align-items-center" href="{{ route('admin.mtg.chat') }}">
                    <i data-feather="circle"></i>Chat</a>
            </li>
            @endcan -->
            @can('Annoucement')
                <li class="@if(url()->current() == route('admin.announcement.index')) active @endif nav-item"><a
                    class="d-flex align-items-center" href="{{ route('admin.announcement.index') }}">
                    <i data-feather="circle"></i>Announcement</a>
                </li>
            @endcan
            <li class="@if(url()->current() == route('admin.surveys.index')) active @endif nav-item"><a
                class="d-flex align-items-center" href="{{ route('admin.surveys.index') }}">
                <i data-feather="circle"></i>Survey Form</a>
            </li> 


        </ul>
    </div>
</div>
