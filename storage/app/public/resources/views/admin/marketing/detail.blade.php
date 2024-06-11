@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="row-grouping-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            {{-- <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">Email</h4>
                                
                            </div> --}}
                            <div class="card-header border-bottom d-flex">
                                <h6 class="card-title text-capitalize"><span class="fw-bolder">Subject:</span> {{$email->subject}}</h6>
                            </div>
                            <div class="card-body mt-2">
                                <!DOCTYPE html>
                                <html lang="en">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Email</title>
                                    <style>
                                        .button {
                                            -webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;
                                        }

                                    .button-blue,
                                    .button-primary {
                                        
                                    }
                                    .text-tiny {
                                        font-size: .7em !important;
                                    }
                                    .text-small {
                                font-size: .85em !important;
                                }
                                .text-big {
                                font-size: 1.4em !important;
                                }
                                .text-huge {
                                font-size: 1.8em !important;
                                }
                                figure > img {
                                    width: 60% !important;
                                    height: 60% !important;
                                }

                                figure {
                                text-align:center !important;
                                }

                                    </style>
                                    
                                </head>

                                <body style="">
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr style="background: #001d35;">
                                            <td style="justify-content: start;text-align: start;">
                                                <a href="{{route('index')}}" style="display: inline-block;">
                                                    <img width="200" src="https://img.veryfriendlysharks.co.uk/file_XkmW26pUb" class="logo" alt="VFS logo">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="append_data" style="padding-top:10px;padding-bottom:10px;font-size:14px;padding-left:10px;padding-right: 10px;width: 100%;height: 100%;text-align:center;">
                                                {!! $email->body !!}
                                            </td>
                                        </tr>
                                        @if($email->newsletter == 'Only marketing users')
                                        <tr>
                                            <td style="text-align:center;padding-bottom: 12px;">
                                                We don't like to say goodbye, but you can <a href="">unsubscribe here</a> if you want to leave from our newsletter list. 
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr style="background: #001d35;">
                                            <td style="justify-content: center;text-align: center; padding-top: 15px;">
                                                <a  target="blank" href="https://www.facebook.com/VeryFriendlySharks" >
                                                    <img   src="https://img.veryfriendlysharks.co.uk/file_AOKQhh7yJ" alt="">
                                                </a>
                                                <a  target="blank" href="https://twitter.com/SharksVery">
                                                    <img class="mt-4px" src="https://img.veryfriendlysharks.co.uk/file_r4CuVbiJp" alt="">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr style="background: #001d35;">
                                            <td style="justify-content: center;text-align: center;">
                                                <a href="{{route('index')}}" style="display: inline-block;">
                                                    <img width="200" src="https://img.veryfriendlysharks.co.uk/file_XkmW26pUb" class="logo" alt="VFS logo">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr style="background: #001d35;">
                                            <td style="justify-content: center;text-align: center; color: white; padding-bottom: 15px;">
                                                © 2021 - {{now()->format('Y')}}  Very Friendly Sharks Ltd
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </body>
                                </html>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">{{$email->newsletter == 'Single user' ? 'User' : 'Users'}}</h4>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    {{ $dataTable->table(['class' => 'table text-center table-striped w-100'],true) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection

@push('js')
@include('admin.components.datatablesScript')
@endpush
